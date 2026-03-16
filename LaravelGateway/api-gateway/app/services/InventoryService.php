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

    private function baseUrl()
    {
        return env('FLASK_SERVICE'); // debe coincidir con tu .env
    }

    public function createProduct($data)
    {
        return Http::withHeaders($this->headers())
            ->post($this->baseUrl() . '/products', $data);
    }

    public function getProducts()
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl() . '/products');
    }

    public function getStock($productId)
    {
        return Http::withHeaders($this->headers())
            ->get($this->baseUrl() . "/products/$productId/stock");
    }

    public function updateStock($productId, $quantity)
    {
        return Http::withHeaders($this->headers())
            ->put($this->baseUrl() . "/products/$productId/stock", [
                "quantity" => $quantity
            ]);
    }
}