<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

// Rotas exclusivas para administradores
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return "Área administrativa - apenas admins podem ver isso.";
    })->name('admin.dashboard');
});

require __DIR__.'/auth.php';