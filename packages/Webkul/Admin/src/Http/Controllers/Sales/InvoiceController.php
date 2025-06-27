<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use OnNow\Xdeasy\Repositories\PhxCargo\PhxCargo;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Product\Models\ProductFlat;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\InvoiceRepository;
use PDF;

/**
 * Sales Invoice controller
 *
 * @author    Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * InvoiceRepository object
     *
     * @var array
     */
    protected $invoiceRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository   $orderRepository
     * @param  \Webkul\Sales\Repositories\InvoiceRepository $invoiceRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        InvoiceRepository $invoiceRepository
    )
    {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;

        $this->invoiceRepository = $invoiceRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view($this->_config['view']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $orderId
     * @return \Illuminate\View\View
     */
    public function create($orderId)
    {
        $order = $this->orderRepository->findOrFail($orderId);

        return view($this->_config['view'], compact('order'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $orderId
     * @return \Illuminate\Http\Response
     */
    public function store($orderId)
    {
        $order = $this->orderRepository->findOrFail($orderId);

        if (! $order->canInvoice()) {
            session()->flash('error', trans('admin::app.sales.invoices.creation-error'));

            return redirect()->back();
        }

        $this->validate(request(), [
            'invoice.items.*' => 'required|numeric|min:0',
        ]);

        $data = request()->all();

        $haveProductToInvoice = false;
        foreach ($data['invoice']['items'] as $itemId => $qty) {
            if ($qty) {
                $haveProductToInvoice = true;
                break;
            }
        }

        if (! $haveProductToInvoice) {
            session()->flash('error', trans('admin::app.sales.invoices.product-error'));

            return redirect()->back();
        }

        $this->invoiceRepository->create(array_merge($data, ['order_id' => $orderId]));

        $order->status = 'invoiced';
        $order->update();

        if (env('APP_ENV') == 'production'){
            $phx = new PhxCargo();
            $phx->createAwb($order);
        }

        session()->flash('success', trans('admin::app.response.create-success', ['name' => 'Invoice']));

        return redirect()->route($this->_config['redirect'], $orderId);
    }

    /**
     * Show the view for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function view($id)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        return view($this->_config['view'], compact('invoice'));
    }

    /**
     * Print and download the for the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print($id)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        $weight = 0;

        $invoice->items->each(function ($item) use ($invoice, &$weight){
            $product = app(ProductFlat::class);
            $product = $product->where("product_id", $item->product_id)
                ->where('channel', $invoice->order->channel->code)
                ->first();

            if (!$product->variants->isEmpty()) {
                $product->weight = $product->variants->first()->weight;
            }

            $weight += $product->weight * $item->qty;

            if ($product->amount_on_invoice) {
                $item->base_price = $product->amount_on_invoice;
                $item->base_total = $product->amount_on_invoice * $item->qty;
                $item->base_discount_amount = $item->base_total;
            }
        });

        $invoice->base_sub_total = $invoice->items->sum('base_total');

        if ($invoice->order->base_grand_total == 0 && !is_null($invoice->order->coupon_code)) {
            $invoice->base_discount_amount = 0;
            $invoice->grand_total = $invoice->base_sub_total * ($invoice->sub_total / $invoice->base_sub_total);
        }

        $exchange = ($invoice->sub_total / $invoice->base_sub_total) / 1.83;

        $invoice->base_shipping_amount = 4.70 * ($weight / 250);
        $invoice->total_before_tax = $invoice->base_sub_total - $invoice->base_discount_amount + $invoice->base_shipping_amount;
        if ($invoice->tax_amount > 0) {
            $invoice->base_grand_total = $invoice->grand_total / $exchange;
            $invoice->local_duties_fee_deposit = $invoice->base_grand_total - $invoice->total_before_tax;
        } else {
            $invoice->base_grand_total = $invoice->total_before_tax;
            $invoice->local_duties_fee_deposit = $invoice->tax_amount;
        }

        $pdf = PDF::loadView('admin::sales.invoices.pdf', compact('invoice'))->setPaper('a4');

        return $pdf->download('invoice-' . $invoice->order->increment_id . '.pdf');
    }

    public function zip($id)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        $weight = 0;
        foreach ($invoice->order->items as $item) {
            $weight += $item->total_weight;
        }

        $exchange = ($invoice->sub_total / $invoice->base_sub_total) / 1.83;

        $invoice->base_shipping_amount = 4.70 * ($weight / 250);
        $invoice->total_before_tax = $invoice->base_sub_total - $invoice->base_discount_amount + $invoice->base_shipping_amount;
        if ($invoice->tax_amount > 0) {
            $invoice->base_grand_total = $invoice->grand_total / $exchange;
            $invoice->local_duties_fee_deposit = $invoice->base_grand_total - $invoice->total_before_tax;
        } else {
            $invoice->base_grand_total = $invoice->total_before_tax;
            $invoice->local_duties_fee_deposit = $invoice->tax_amount;
        }

        // invoice
        $pathPdf = public_path('invoices/invoice-' . $invoice->created_at->format('d-m-Y') . '.pdf');
        $namePdf = 'invoice-' . $invoice->created_at->format('d-m-Y') . '.pdf';

        PDF::loadView('admin::sales.invoices.pdf', compact('invoice'))->setPaper('a4')->save($pathPdf);

        // zip
        $zipname = $invoice->order->increment_id . '.zip';
        $zip = new \ZipArchive();
        if ($zip->open('zips/' . $zipname, \ZipArchive::CREATE) === TRUE) {
            // prescription
            foreach ($invoice->order->prescriptions as $prescription) {
                $zip->addFile($prescription->path, $prescription->prescription);
            }

            $zip->addFile($pathPdf, $namePdf);
            $zip->close();
        } else {
            throw new \Exception('Failed to create zip file');
        }

        // Clear output buffer
        ob_end_clean();

        // Send headers and file
        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$zipname");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile('zips/' . $zipname);

        // Delete the zip file after download
        unlink('zips/' . $zipname);
    }
}
