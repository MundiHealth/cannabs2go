<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Webkul\Product\Repositories\ProductImageRepository;
use Webkul\Product\Repositories\ProductRepository;

class RelationImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:relation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Relacionar imagens aos produtos';

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var ProductImageRepository
     */
    protected $productImageRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $productRepository,
                                ProductImageRepository $productImageRepository)
    {
        $this->productRepository = $productRepository;

        $this->productImageRepository = $productImageRepository;

        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $products = $this->productRepository->all();

        foreach ($products as $product) {

            if(Storage::disk('public')->exists('product/' . $product->id)){

                if (!$product->images->isEmpty())
                    continue;

                $files = Storage::disk('public')->files('product/' . $product->id);

                array_map(function ($file) use ($product) {
                    $extensionArray = explode('.', $file);

                    if (end($extensionArray) == 'pdf')
                        return;

                    $this->productImageRepository->firstOrCreate([
                        'type' => null,
                        'path' => $file,
                        'product_id' => $product->id
                    ]);

                    echo "File {$file} inserted for product #{$product->id}\n\n";

                }, $files);
            }
        }

    }
}
