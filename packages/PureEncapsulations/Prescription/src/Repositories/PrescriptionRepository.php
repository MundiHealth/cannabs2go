<?php
namespace PureEncapsulations\Prescription\Repositories;

use PureEncapsulations\Prescription\Models\Prescription;
use Webkul\Core\Eloquent\Repository;

class PrescriptionRepository extends Repository
{
    protected $rules;

    function model()
    {
        return Prescription::class;
    }

}