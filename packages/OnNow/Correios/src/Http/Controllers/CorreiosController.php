<?php


namespace OnNow\Correios\Http\Controllers;

use App\Http\Controllers\Controller;
use FlyingLuscas\Correios\Client;
use FlyingLuscas\ViaCEP\ViaCEP;
use Illuminate\Support\Facades\Log;

class CorreiosController extends Controller
{

    public function consultarCep()
    {
        $zipcode =  request('zipcode');

        if (strlen($zipcode) < 8)
            return false;

        $correios = new ViaCEP();

        $zipcode = str_replace('-', '', $zipcode);

        $response = $correios->findByZipCode($zipcode);
        $response->district = $response->neighborhood;
        $response->uf = $response->state;

        Log::info('ViaCep Response: ' . $response->toJson());

        return $response->toJson();

    }

}