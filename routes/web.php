<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\StoreSettingsController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'success' => session('success'),
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    // Verifica o papel (role) do usuário autenticado
    $user = Auth::user();

    if ($user) {
        if ($user->role === 'admin') {
            // Redireciona para o painel de Admin
            return redirect()->route('admin.dashboard');
        }
        elseif ($user->role === 'store') {
            // Redireciona para o painel de Admin
            return redirect()->route('store.dashboard');
        }
    }
})
->middleware(['auth', 'verified'])
->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/stores/create', [AdminController::class, 'createStore'])->name('admin.stores.create');
    Route::post('/admin/stores', [AdminController::class, 'store'])->name('admin.stores.store');
    Route::get('/admin/stores', [AdminController::class, 'listStores'])->name('admin.stores');
    Route::get('/admin/stores/{id}', [AdminController::class, 'showStore'])->name('admin.stores.show');
    Route::get('/admin/stores/{id}/edit', [AdminController::class, 'editStore'])->name('admin.stores.edit');
    Route::patch('/admin/stores/{id}', [AdminController::class, 'updateStore'])->name('admin.stores.update');
    Route::patch('/admin/stores/{id}/toggleStatus', [AdminController::class, 'toggleStoreStatus'])->name('admin.stores.toggle');
    Route::delete('/admin/stores/{id}', [AdminController::class, 'destroyStore'])->name('admin.stores.destroy');

    Route::get('/store/dashboard', [StoreController::class, 'dashboard'])->name('store.dashboard');
    Route::patch('/store/update', [StoreSettingsController::class, 'update'])->name('store.update');
    Route::get('/store/categories', [CategoryController::class, 'index'])->name('store.categories.index');
    Route::post('/store/categories', [CategoryController::class, 'store'])->name('store.categories.store');
    Route::put('/store/categories/{category}', [CategoryController::class, 'update'])->name('store.categories.update');
    Route::delete('/store/categories/{id}', [CategoryController::class, 'destroy'])->name('store.categories.destroy');
});

require __DIR__.'/auth.php';
