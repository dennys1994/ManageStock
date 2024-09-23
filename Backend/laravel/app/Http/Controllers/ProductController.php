<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Certifique-se de que o modelo Product está importado
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // Criar um novo produto
    public function store(Request $request)
    {
        // Verifica se o usuário foi autenticado com base na chave da API
        $user = $request->user; // Supondo que o usuário esteja sendo passado via middleware após autenticação pela API key
        
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);
    
        // Associa o produto ao usuário autenticado
        $validatedData['user_id'] = $user->id;
    
        $product = Product::create($validatedData);
    
        return response()->json($product, 201);
    }
    
    // Listar produtos do usuário autenticado
    public function index() {
        $products = Product::where('user_id', Auth::id())->get();
        return response()->json($products);
    }

    // Atualizar um produto
    public function update(Request $request, $id) {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        $product = Product::findOrFail($id);

        // Verifica se o produto pertence ao usuário autenticado
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->update($validatedData);
        return response()->json($product);
    }

    // Excluir um produto
    public function destroy($id) {
        $product = Product::findOrFail($id);

        // Verifica se o produto pertence ao usuário autenticado
        if ($product->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $product->delete();
        return response()->json(null, 204);
    }

    public function getProductById($id)
    {
        $product = Product::findOrFail($id);

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado.'], 404);
        }

        return response()->json($product, 200);
    }


}
