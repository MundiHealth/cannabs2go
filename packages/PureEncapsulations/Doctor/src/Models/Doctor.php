<?php

namespace PureEncapsulations\Doctor\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PureEncapsulations\Doctor\Contracts\Doctor as DoctorContract;


class Doctor extends Authenticatable implements DoctorContract
{
    //
    use Notifiable, SoftDeletes;

    protected $table = 'doctors';

    protected $fillable = [
        'doctor_reg',
        'name',
        'patient',
        'prescription_date',
        'purchase_date',
        'purchase',
        'order_number'
    ];

    protected $dates = ['deleted_at'];

}
