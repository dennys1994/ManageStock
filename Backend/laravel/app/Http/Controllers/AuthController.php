<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request) {
        try {
            // Validação e criação do usuário
            $validatedData = $request->validate([
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:8',
            ]);
        
            $validatedData['password'] = bcrypt($validatedData['password']);
            $validatedData['api_key'] = Str::random(40);
        
            $user = User::create($validatedData);      
            return response()->json([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'api_key' => $user->api_key,
                ],
                'status' => 'success',
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Erro de validação.',
                'messages' => $e->validator->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao registrar usuário. Tente novamente.',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function login(Request $request) {
        // Validação e autenticação do usuário
        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
    
        if (!Auth::attempt($validatedData)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        $user = Auth::user();
        return response()->json(['api_key' => $user->api_key]);
    }
    
    
}
