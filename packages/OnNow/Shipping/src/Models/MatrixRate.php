<?php


namespace OnNow\Shipping\Models;


use Illuminate\Database\Eloquent\Model;

class MatrixRate extends Model implements \OnNow\Shipping\Contracts\MatrixRate
{

    protected $fillable = [
        'country_id',
        'country_state_id',
        'city',
        'zip_code_from',
        'zip_code_to',
        'weight_from',
        'weight_to',
        'value',
        'description'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

}