<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InventoryService;
use App\Services\SalesService;

class SaleController extends Controller
{
    protected $inventory;
    protected $sales;

    public function __construct(InventoryService $inventory, SalesService $sales)
    {
        $this->inventory = $inventory;
        $this->sales = $sales;
    }

    public function createSale(Request $request)
    {
        // Transformar request en array de productos
        $products = $request->input('products');

        // Si viene un solo producto con productId y quantity
        if (!$products && $request->input('productId') && $request->input('quantity')) {
            $products = [
                [
                    'product_id' => $request->input('productId'),
                    'quantity' => $request->input('quantity')
                ]
            ];
        }

        if (!$products || !is_array($products)) {
            return response()->json([
                "success" => false,
                "message" => "No se enviaron productos para la venta"
            ], 400);
        }

        $stockErrors = [];

        // Verificar stock de cada producto
        foreach ($products as $product) {
            $productId = $product['product_id'] ?? null;
            $quantity = $product['quantity'] ?? 0;

            if (!$productId) {
                return response()->json([
                    "success" => false,
                    "message" => "Falta product_id"
                ], 400);
            }

            $stockResponse = $this->inventory->getStock($productId);

            if ($stockResponse->failed()) {
                return response()->json([
                    "success" => false,
                    "message" => "Error consultando stock del producto $productId"
                ], 500);
            }

            $stock = $stockResponse->json()['stock'] ?? 0;

            if ($stock < $quantity) {
                $stockErrors[] = [
                    "product_id" => $productId,
                    "available" => $stock,
                    "requested" => $quantity
                ];
            }
        }

        if (!empty($stockErrors)) {
            return response()->json([
                "success" => false,
                "message" => "Stock insuficiente",
                "details" => $stockErrors
            ], 400);
        }

        // Crear venta en microservicio Express
        $saleResponse = $this->sales->createSale([
            'products' => $products
        ]);

        if ($saleResponse->failed()) {
            return response()->json([
                "success" => false,
                "message" => "Error registrando venta",
                "error" => $saleResponse->body()
            ], $saleResponse->status());
        }

        return response()->json([
            "success" => true,
            "sale" => $saleResponse->json()
        ]);
    }
}