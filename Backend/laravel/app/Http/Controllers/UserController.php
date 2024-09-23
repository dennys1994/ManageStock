<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function renewApiKey(Request $request)
    {
        // Verifica se o usuário está autenticado
        $user = $request->user;

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Gera uma nova chave de API
        $newApiKey = Str::random(60);
        $user->api_key = $newApiKey;
        $user->save();

        return response()->json(['api_key' => $newApiKey], 200);
    }
}
