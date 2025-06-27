<?php

namespace OnNow\Product\CacheFilters;

use Intervention\Image\Image;
use Intervention\Image\Filters\FilterInterface;

class Large implements FilterInterface
{
    public function applyFilter(Image $image)
    {
        $width = 800;
        $height = 800;

        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imgWidth  = $image->width();
        $imgHeight = $image->height();

        $vertical   = (($imgWidth < $imgHeight) ? true : false);

        if ($vertical){
            $image->resize($imgWidth, $imgWidth, function ($constraint) {
                $constraint->aspectRatio();
            });
            return $image->resizeCanvas($width, $height, 'center', false, '#fff');
        }

        return $image->resizeCanvas($width, $height, 'center', false, '#fff');
    }
}