<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Services\SalesService;

class SaleController extends Controller
{

    protected $inventory;
    protected $sales;
    public function __construct(
        InventoryService $inventory,
        SalesService $sales
    ){
        $this->inventory = $inventory;
        $this->sales = $sales;
    }

    public function createSale(Request $request)
    {
        $productId = $request->productId;
        $quantity = $request->quantity;
        $stockResponse = $this->inventory->getStock($productId);
        $stock = $stockResponse->json()['stock'];
        if($stock < $quantity){
            return response()->json([
                "message"=>"Stock insuficiente"
            ],400);
        }
        $saleResponse = $this->sales->createSale([
            "productId"=>$productId,
            "quantity"=>$quantity
        ]);
        return response()->json($saleResponse->json());
    }
}