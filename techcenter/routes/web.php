<?php

// Rutas de la página pública, el ingreso social, el panel del cliente y el del admin.

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PartController;
use App\Http\Controllers\CuentaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Support\Facades\Route;

// Página pública del taller.
Route::get('/', function () {
    return view('inicio');
})->name('inicio');

// Ingreso con Google, Microsoft o GitHub. El nombre del proveedor va en la URL.
Route::get('auth/{provider}/redirect', [SocialAuthController::class, 'redirect'])
    ->whereIn('provider', ['google', 'microsoft', 'github'])
    ->name('social.redirect');

Route::get('auth/{provider}/callback', [SocialAuthController::class, 'callback'])
    ->whereIn('provider', ['google', 'microsoft', 'github'])
    ->name('social.callback');

// Después del login, manda al panel que corresponde al rol.
Route::get('/dashboard', function () {
    return redirect(auth()->user()->panelRoute());
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Panel del cliente. Un admin no entra aquí.
Route::middleware(['auth', 'role:cliente'])->prefix('cuenta')->name('cuenta.')->group(function () {
    Route::get('/', [CuentaController::class, 'index'])->name('inicio');
    Route::get('/pedidos/{order}', [CuentaController::class, 'show'])->name('pedidos.show');
});

// Panel del administrador: catálogo, inventario y todos los pedidos.
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('inicio');
    Route::get('/partes', [PartController::class, 'index'])->name('partes.index');
    Route::get('/partes/crear', [PartController::class, 'create'])->name('partes.create');
    Route::post('/partes', [PartController::class, 'store'])->name('partes.store');
    Route::get('/partes/{part}/editar', [PartController::class, 'edit'])->name('partes.edit');
    Route::put('/partes/{part}', [PartController::class, 'update'])->name('partes.update');
    Route::get('/pedidos', [AdminOrderController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/crear', [AdminOrderController::class, 'create'])->name('pedidos.create');
    Route::post('/pedidos', [AdminOrderController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{order}', [AdminOrderController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{order}', [AdminOrderController::class, 'update'])->name('pedidos.update');
});

require __DIR__.'/auth.php';
