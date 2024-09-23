<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;

Route::middleware(\App\Http\Middleware\ApiKeyMiddleware::class)->group(function () {
    // Rota para criar um novo produto
    Route::post('/products', [ProductController::class, 'store']);
    // Rota para listar todos os produtos do usuário autenticado
    Route::get('/products', [ProductController::class, 'index']);

    Route::get('/products/{id}', [ProductController::class, 'getProductById']);
    // Rota para atualizar um produto existente pelo ID
    Route::put('/products/{id}', [ProductController::class, 'update']);
    // Rota para excluir um produto existente pelo ID
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    // Rota para registrar a venda de um produto pelo ID
    Route::post('/products/{id}/sell', [SalesController::class, 'store']);
    // Rota para verificar o estoque atual de todos os produtos
    Route::get('/inventory', [InventoryController::class, 'index']);
    // Rota para listar produtos com baixo estoque
    Route::get('/inventory/low-stock', [InventoryController::class, 'lowStock']);
    // Rota para listar todas as vendas realizadas pelo usuário autenticado
    Route::get('/sales', [SalesController::class, 'index']);    
    // Rota para filtrar o histórico de vendas por um intervalo de datas
    Route::get('/sales/period', [SalesController::class, 'salesByPeriod']);
    // Rota que permite que o usuário renove sua chave de API se necessário.
    Route::post('/users/renew-api-key', [UserController::class, 'renewApiKey']);
    
    Route::get('/export/inventory', [ExportController::class, 'exportInventory']);
    Route::get('/export/sales', [ExportController::class, 'exportSales']);

    Route::get('/notifications/low-stock', [NotificationController::class, 'checkLowStock']);


});

