<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webkul\Product\Models\Product;

class FlushProductFlats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bagisto:flush_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush Product Flats Table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $products = Product::select('id', 'attribute_family_id')->get();
        $productFlat = app('Webkul\Product\Listeners\ProductFlat');

        foreach ($products as $product) {

            $productFlat->afterProductCreatedUpdated($product);

        }

    }
}
