<?php


namespace OnNow\PrimeiroPay\Models;


use Illuminate\Database\Eloquent\Model;

class PpayTransaction extends Model
{

    protected $fillable = ['order_id', 'response'];

}