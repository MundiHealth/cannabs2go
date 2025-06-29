<?php

namespace Webkul\Product\Helpers;

use Webkul\Attribute\Repositories\AttributeOptionRepository as AttributeOption;
use Illuminate\Support\Facades\Storage;

/**
 * Product Image Helper
 *
 * @author Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class ProductImage extends AbstractProduct
{
    /**
     * Retrieve collection of gallery images
     *
     * @param Product $product
     * @return array
     */
    public function getGalleryImages($product)
    {
        if (! $product)
            return [];

        $images = [];

        foreach ($product->images as $image) {
            if (! Storage::has($image->path))
                continue;

            $images[] = [
                'small_image_url' => url('storage/' . $image->path),
                'medium_image_url' => url('storage/' . $image->path),
                'large_image_url' => url('storage/' . $image->path),
                'original_image_url' => url('storage/' . $image->path),
            ];
        }

        if (! $product->parent_id && ! count($images)) {
            $images[] = [
                'small_image_url' => asset('vendor/webkul/ui/assets/images/product/small-product-placeholder.png'),
                'medium_image_url' => asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png'),
                'large_image_url' => asset('vendor/webkul/ui/assets/images/product/large-product-placeholder.png'),
                'original_image_url' => asset('vendor/webkul/ui/assets/images/product/large-product-placeholder.png')
            ];
        }

        return $images;
    }

    /**
     * Get product's base image
     *
     * @param Product $product
     * @return array
     */
    public function getProductBaseImage($product)
    {
        $images = $product ? $product->images : null;

        if ($images && $images->count()) {
            $image = [
                'small_image_url' => url('storage/' . $images[0]->path),
                'medium_image_url' => url('storage/' . $images[0]->path),
                'large_image_url' => url('storage/' . $images[0]->path),
                'original_image_url' => url('storage/' . $images[0]->path),
            ];
        } else {
            $image = [
                'small_image_url' => asset('vendor/webkul/ui/assets/images/product/small-product-placeholder.png'),
                'medium_image_url' => asset('vendor/webkul/ui/assets/images/product/meduim-product-placeholder.png'),
                'large_image_url' => asset('vendor/webkul/ui/assets/images/product/large-product-placeholder.png'),
                'original_image_url' => asset('vendor/webkul/ui/assets/images/product/large-product-placeholder.png'),
            ];
        }

        return $image;
    }
}