<?php

namespace OnNow\Distributors\Repositories;

use Webkul\Core\Eloquent\Repository;

class DistributorRepository extends Repository
{
    function model()
    {
        return 'OnNow\Distributors\Models\Distributor';
    }
}