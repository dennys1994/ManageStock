<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    // Registrar a venda de um produto
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1', // A quantidade deve ser um número inteiro positivo
        ]);

        // Encontra o produto
        $product = Product::findOrFail($id);

        // Verifica se o produto pertence ao usuário autenticado
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Verifica se há estoque suficiente
        if ($product->quantity < $validatedData['quantity']) {
            return response()->json(['message' => 'Insufficient stock'], 400);
        }

        // Atualiza a quantidade em estoque
        $product->quantity -= $validatedData['quantity'];
        $product->save();

        // Registra a venda
        $sale = Sale::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $validatedData['quantity'],
        ]);

        return response()->json($sale, 201);
    }

    // Exibir o histórico de vendas de todos os produtos do usuário
    public function index()
    {
        $sales = Sale::with('product')->where('user_id', auth()->id())->get();
        return response()->json($sales);
    }

    // Filtrar o histórico de vendas por um intervalo de datas
    public function salesByPeriod(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $sales = Sale::with('product')
            ->where('user_id', auth()->id())
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        return response()->json($sales);
    }
}
