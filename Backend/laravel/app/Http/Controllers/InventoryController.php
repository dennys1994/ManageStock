<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    // Listar todos os produtos com suas quantidades em estoque
    public function index()
    {
        $products = Product::all(['id', 'name', 'quantity']);
        return response()->json($products);
    }

    // Listar produtos com baixo estoque
    public function lowStock()
    {
        $lowStockThreshold = 10; // Defina seu limite de baixo estoque aqui
        $products = Product::where('quantity', '<', $lowStockThreshold)->get(['id', 'name', 'quantity']);
        return response()->json($products);
    }
}

