<?php


namespace OnNow\Shipping\Observers;


use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use OnNow\Shipping\Imports\MatrixRateImport;

class MatrixRateObserver
{

    public function creating()
    {
        $request = request();
        if (!isset($request['sales.carriers.matrixrate']))
            return;

        return;

        $file = Input::file('sales.carriers.matrixrate.table');
        dd($file);

        dd($request->all());

        $extension = $file->getClientOriginalExtension();
        $name = $request->order_id . "_" . time() . "." . $extension;

        dd($name);

        Excel::import(new MatrixRateImport, public_path('matrix_rate/' . $file));
    }

}