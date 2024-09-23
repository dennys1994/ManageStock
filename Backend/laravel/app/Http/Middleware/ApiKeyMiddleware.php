<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use App\Models\User; // Certifique-se de importar o modelo User

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
{
    $apiKeyHeader = $request->header('authorization');

    if ($apiKeyHeader && preg_match('/Bearer\s(\S+)/', $apiKeyHeader, $matches)) {
        $apiKey = $matches[1];
    } else {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $user = User::where('api_key', $apiKey)->first();
    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $request->user = $user;

    if ($user) {
        Auth::login($user); // Isso autentica o usuário
    }
    

    return $next($request);
}


}