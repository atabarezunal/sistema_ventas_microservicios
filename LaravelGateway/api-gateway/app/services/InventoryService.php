<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InventoryService
{

    public function createProduct($data)
    {
        return Http::post(env('FLASK_SERVICE').'/products',$data);
    }

    public function getProducts()
    {
        return Http::get(env('FLASK_SERVICE').'/products');
    }

    public function getStock($productId)
    {
        return Http::get(env('FLASK_SERVICE')."/products/$productId/stock");
    }

}