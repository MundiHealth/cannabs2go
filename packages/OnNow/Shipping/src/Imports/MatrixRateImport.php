<?php


namespace OnNow\Shipping\Imports;

use OnNow\Shipping\Models\MatrixRate;
use Maatwebsite\Excel\Concerns\ToModel;

class MatrixRateImport implements ToModel
{

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        dd(1);
        return new MatrixRate();
    }

}