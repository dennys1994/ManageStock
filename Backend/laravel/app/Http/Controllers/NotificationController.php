<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function checkLowStock()
    {
        $lowStockProducts = Product::where('quantity', '<', 10)->get(); // Defina seu limite

        // Envie notificações por e-mail, por exemplo
        foreach ($lowStockProducts as $product) {
            Mail::to('user@example.com')->send(new LowStockNotification($product)); // Ajuste o email
        }

        return response()->json(['message' => 'Low stock notifications sent.'], 200);
    }
}
