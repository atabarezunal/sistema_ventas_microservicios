<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InventoryService;

class ProductController extends Controller
{

    protected $inventory;
    public function __construct(InventoryService $inventory)
    {
        $this->inventory = $inventory;
    }

    public function createProduct(Request $request)
    {
        $response = $this->inventory->createProduct($request->all());
        return response()->json($response->json());
    }

    public function getProducts()
    {
        $response = $this->inventory->getProducts();
        return response()->json($response->json());
    }

}