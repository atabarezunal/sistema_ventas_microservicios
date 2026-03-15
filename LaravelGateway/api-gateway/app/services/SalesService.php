<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SalesService
{

    public function createSale($data)
    {
        return Http::post(env('EXPRESS_SERVICE').'/sales',$data);
    }

    public function getSales()
    {
        return Http::get(env('EXPRESS_SERVICE').'/sales');
    }

}