<?php

namespace OnNow\Distributors\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $table = 'distributors';

    protected $fillable = [
        'name',
        'commission',
    ];
}