<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class InventoryService
{

    private function headers()
    {
        return [
            'X-API-KEY' => env('MICROSERVICE_API_KEY')
        ];
    }

    public function createProduct($data)
    {
        return Http::withHeaders($this->headers())
            ->post(env('FLASK_SERVICE').'/products', $data);
    }

    public function getProducts()
    {
        return Http::withHeaders($this->headers())
            ->get(env('FLASK_SERVICE').'/products');
    }

    public function getStock($productId)
    {
        return Http::withHeaders($this->headers())
            ->get(env('FLASK_SERVICE')."/products/$productId/stock");
    }

    public function updateStock($productId, $quantity)
    {
        return Http::withHeaders($this->headers())
            ->put(env('FLASK_SERVICE')."/products/$productId/stock", [
                "quantity" => $quantity
            ]);
    }

}