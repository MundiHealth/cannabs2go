<?php

namespace PureEncapsulations\Prescription\Models;

use Illuminate\Database\Eloquent\Model;
use Webkul\Sales\Models\OrderProxy;
use Illuminate\Support\Facades\Storage;

class Prescription extends Model
{

    protected $fillable = [
        'prescription',
        'extension',
        'path',
        'order_id'
    ];

    /**
     * Get the product that owns the image.
     */
    public function order()
    {
        return $this->belongsTo(OrderProxy::ModelClass());
    }

    /**
     * Get image url for the product image.
     */
    public function url()
    {
        return Storage::url($this->path);
    }

    /**
     * Get image url for the product image.
     */
    public function getUrlAttribute()
    {
        return $this->url();
    }

    /**
     * @param string $key
     *
     * @return bool
     */
//    public function isCustomAttribute($attribute)
//    {
//        return $this->attribute_family->custom_attributes->pluck('code')->contains($attribute);
//    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = parent::toArray();

        $array['url'] = $this->url;

        return $array;
    }
}