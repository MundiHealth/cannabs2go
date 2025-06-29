<?php
/**
 * Created by PhpStorm.
 * User: zaira
 * Date: 05/02/20
 * Time: 16:06
 */

namespace PureEncapsulations\Product\Helpers;
use DB;
use Webkul\Product\Helpers\AbstractProduct;

/**
* Product Review Helper
*
 * @author Jitendra Singh <jitendra@webkul.com>
 * @copyright 2018 Webkul Software Pvt Ltd (http://www.webkul.com)
 */
class Review extends AbstractProduct
{
    /**
     * Returns the product's avg rating
     *
     * @param Product $product
     * @return float
     */
    public function getReviews($product)
    {
        static $reviews = [];

        if(array_key_exists($product->id, $reviews))
            return $reviews[$product->id];

        return $reviews[$product->id] = $product->reviews()->where('status', 'approved');
    }

    /**
     * Returns the product's avg rating
     *
     * @param Product $product
     * @return float
     */
    public function getAverageRating($product)
    {
        static $avgRating = [];

        if(array_key_exists($product->id, $avgRating))
            return $avgRating[$product->id];

        return $avgRating[$product->id] = number_format(round($product->reviews()->where('status', 'approved')->average('rating'), 2), 1);
    }

    /**
     * Returns the total review of the product
     *
     * @param Product $product
     * @return integer
     */
    public function getTotalReviews($product)
    {
        static $totalReviews = [];

        if(array_key_exists($product->id, $totalReviews))
            return $totalReviews[$product->id];

        return $totalReviews[$product->id] = $product->reviews()->where('status', 'approved')->count();
    }

    /**
     * Returns the total rating of the product
     *
     * @param Product $product
     * @return integer
     */
    public function getTotalRating($product)
    {
        static $totalRating = [];

        if(array_key_exists($product->id, $totalRating))
            return $totalRating[$product->id];

        return $totalRating[$product->id] = $product->reviews()->where('status','approved')->sum('rating');
    }

    /**
     * Returns the Percentage rating of the product
     *
     * @param Product $product
     * @return integer
     */
    public function getPercentageRating($product)
    {
        $reviews = $product->reviews()->where('status', 'approved')
            ->select('rating', DB::raw('count(*) as total'))
            ->groupBy('rating')
            ->orderBy('rating','desc')
            ->get();

        $totalReviews = $this->getTotalReviews($product);

        for ($i = 5; $i >= 1; $i--) {
            if (! $reviews->isEmpty()) {
                foreach ($reviews as $review) {
                    if ($review->rating == $i) {
                        $percentage[$i] = round(($review->total / $totalReviews) * 100);

                        break;
                    } else {
                        $percentage[$i]=0;
                    }
                }
            } else {
                $percentage[$i]=0;
            }
        }

        return $percentage;
    }
}