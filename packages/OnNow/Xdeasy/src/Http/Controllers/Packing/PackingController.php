<?php

namespace OnNow\Xdeasy\Http\Controllers\Packing;


use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use OnNow\Xdeasy\Exports\AwbExport;
use OnNow\Xdeasy\Exports\BringerAwbExport;
use OnNow\Xdeasy\Exports\FedexExport;
use OnNow\Xdeasy\Http\Controllers\Controller;
use OnNow\Xdeasy\Imports\FedexImport;
use OnNow\Xdeasy\Imports\WarehouseImport;
use Webkul\Product\Models\ProductFlat;
use Webkul\Sales\Repositories\InvoiceRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;
use PDF;

class PackingController extends Controller
{

    /**
     * Contains route related configuration
     *
     * @var array
     */
    protected $_config;

    /**
     * OrderRepository object
     *
     * @var array
     */
    protected $orderRepository;

    /**
     * ShipmentRepository object
     *
     * @var mixed
     */
    protected $shipmentRepository;
    protected $invoiceRepository;

    /**
     * Create a new controller instance.
     *
     * @param  \Webkul\Sales\Repositories\OrderRepository $orderRepository
     * @return void
     */
    public function __construct(
        OrderRepository $orderRepository,
        ShipmentRepository $shipmentRepository,
        InvoiceRepository $invoiceRepository
    )
    {
        $this->middleware('admin');

        $this->_config = request('_config');

        $this->orderRepository = $orderRepository;

        $this->shipmentRepository = $shipmentRepository;

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

    public function dispatched()
    {
        $data = request()->all();

        $orders = $this->orderRepository->findWhereIn('id', explode(',', $data['indexes']));

        foreach ($orders as $order){

            $items = [];

            foreach ($order->items as $item){
                $items[$item->id] = $item->qty_ordered;
            }

            $data = [
                'order_id' => $order->id,
                'shipment' => [
                    'carrier_title' => $order->channel_id == 20 ? 'FedEx' : 'Bringer',
                    'track_number' => $order->channel_id == 20 ? $order->awb_code : $order->increment_id,
                    'source' => 1,
                    'items' => $items
                ]
            ];

            $this->shipmentRepository->create(array_merge($data, ['order_id' => $order->id]));

            $order->status = 'dispatched';
            $order->update();
        }



        Session()->flash('success', 'Pedidos despachados com sucesso!');

       return redirect()->route('admin.xdeasy.packing');

        //return Excel::download(new AwbExport($orders), 'mawb.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function mawbGenerate()
    {
        $orders = $this->orderRepository->findWhereIn('status', ['separation']);

        return Excel::download(new AwbExport($orders), 'mawb.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function mawbBringerGenerate()
    {
        $orders = $this->orderRepository->findWhereIn('status', ['separation']);
        //$orders = $this->orderRepository->findWhereIn('increment_id', ['MP202000009714']);

        return Excel::download(new BringerAwbExport($orders), 'bringerMawb.csv', \Maatwebsite\Excel\Excel::CSV);
    }

    public function fedexReport()
    {
        $orders = $this->orderRepository
            ->findWhereIn('status', ['processing', 'separation', 'invoiced', 'dispatched'])
            ->where('channel_id', 20)
            ->where('created_at', '<=', Carbon::now()->subDays(1));

        //ob_end_clean();
        //ob_start();
        return Excel::download(new FedexExport($orders), 'fedex.xlsx');
    }

    public function fedexZipDocuments($id)
    {
        $invoice = $this->invoiceRepository->findOrFail($id);

        $weight = 0;
        foreach ($invoice->order->items as $item) {
            $weight += $item->total_weight;
        }

        $exchange = ($invoice->grand_total / $invoice->base_grand_total) / 1.83;

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

            if ($invoice->order->status == 'invoiced') {
                $invoice->order->status = 'separation';
                $invoice->order->save();
            }

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

    public function zip()
    {
        $orders = $this->orderRepository->findWhereIn('status', ['separation']);

        // zip
        $zipname = 'documentacao' . Carbon::now()->format('Ymd') . '.zip';
        $zip = new \ZipArchive();
        $zip->open('zips/'.$zipname, \ZipArchive::CREATE);

        foreach ($orders as $order) {
            $zip->addEmptyDir($order->increment_id);

            $invoice = $order->invoices->first();

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

            // invoice
            $pathPdf = public_path('invoices/invoice-' . $order->increment_id . '.pdf');
            $namePdf = $order->increment_id . '/invoice-' . $order->increment_id . '.pdf';

            PDF::loadView('admin::sales.invoices.pdf', compact('invoice'))->setPaper('a4')->save($pathPdf);

            //$zip->addFile($order->increment_id);
            $zip->addFile($pathPdf, $namePdf);

            foreach($order->prescriptions as $prescription) {
                $zip->addFile($prescription->path, $order->increment_id . '/' . $prescription->prescription);
            }

        }

        $zip->close();

        header("Content-type: application/zip");
        header("Content-Disposition: attachment; filename=$zipname");
        header("Content-Transfer-Encoding: binary");
        header("Pragma: no-cache");
        header("Expires: 0");
        readfile("zips/".$zipname);
    }

    public function warehouseImport()
    {
        $file = request()->file('file-update');

        $extension = $file->getClientOriginalExtension();
        $name = "warehouse_" . time() . "." . $extension;

        $path = $file->move('imports/warehouse', $name);

        Excel::import(new WarehouseImport, $path->getPathname());

        Session()->flash('success', 'Pedidos atualizados com sucesso!');

        return redirect()->route('admin.xdeasy.packing');

    }

    public function fedexTrackingImport()
    {
        $file = request()->file('file-update');
        $extension = $file->getClientOriginalExtension();
        $name = "fedex_tracking_" . time() . "." . $extension;
        $path = $file->move('imports/fedex', $name);

        Excel::import(new FedexImport(), $path->getPathname());

        Session()->flash('success', 'Pedidos atualizados com sucesso!');

        return redirect()->route('admin.xdeasy.packing');
    }

}