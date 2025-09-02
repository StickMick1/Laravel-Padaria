<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard (precisa de login e email verificado)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotas protegidas para qualquer usuário logado
Route::middleware('auth')->group(function () {
    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{product}', [CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/ticket', [OrderController::class, 'ticket'])->name('orders.ticket');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/pdf', [OrderController::class, 'ticketPdf'])->name('orders.pdf');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    //Admin ---------------------------------------------------
    // Listar todos os pedidos
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');

    // Detalhes de um pedido específico
    Route::get('/admin/orders/{order}', [OrderController::class, 'show'])->name('admin.orders.show');

    // Atualizar status (ex: finalizar pedido)
    Route::put('/admin/orders/{order}/finalizar', [OrderController::class, 'finalizar'])->name('admin.orders.finalizar');
});

// Rotas exclusivas para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return "Área administrativa - apenas admins podem ver isso.";
    })->name('admin.dashboard');

    Route::resource('/admin/users', UserController::class);
    Route::resource('/admin/products', ProductController::class);
    Route::resource('stockmovements', StockMovementController::class);
});

require __DIR__.'/auth.php';