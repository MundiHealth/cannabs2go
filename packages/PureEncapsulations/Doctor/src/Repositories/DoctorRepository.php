<?php


namespace PureEncapsulations\Doctor\Repositories;

use PureEncapsulations\Doctor\Models\Doctor;
use Webkul\Core\Eloquent\Repository;

class DoctorRepository extends Repository
{
    function model ()
    {
        return Doctor::class;
    }
}