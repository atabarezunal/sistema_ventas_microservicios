<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SalesService
{
    private function headers()
    {
        return [
            'X-API-KEY' => env('MICROSERVICE_API_KEY'),
            'Accept' => 'application/json'
        ];
    }

    
    public function createSale(array $data)
    {
        return Http::withHeaders($this->headers())
            ->post(env('EXPRESS_SERVICE').'/sales', $data);
    }

    public function getSales()
    {
        return Http::withHeaders($this->headers())
            ->get(env('EXPRESS_SERVICE').'/sales');
    }
}