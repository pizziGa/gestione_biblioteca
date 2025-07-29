<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CopyController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::redirect('dashboard', 'dashboard/catalogo');

    Route::get('dashboard/catalogo', [CatalogController::class, 'create'])->name('catalogo');
    Route::post('dashboard/catalogo', [CatalogController::class, 'store']);
    Route::post('dashboard/catalogo/{id}/update', [CatalogController::class, 'update']);
    Route::delete('dashboard/catalogo/{id}', [CatalogController::class, 'delete']);

    Route::get('dashboard/catalogo/{id}/copie', [CopyController::class, 'create'])->name('copie');
    Route::post('dashboard/catalogo/{id}/copie', [CopyController::class, 'store']);

    Route::get('dashboard/categorie', [CategoryController::class, 'create'])->name('categorie');
    Route::post('dashboard/categorie', [CategoryController::class, 'store']);
    Route::post('dashboard/categorie/{id}/update', [CategoryController::class, 'update']);
    Route::delete('dashboard/categorie/{id}', [CategoryController::class, 'delete']);

    Route::get('dashboard/prenotazioni', [BookingController::class, 'create'])->name('prenotazioni');
    Route::delete('dashboard/prenotazioni/{id}', [BookingController::class, 'delete']);

    Route::get('dashboard/utenti', [UserController::class, 'create'])->name('utenti');
    Route::post('dashboard/utenti', [UserController::class, 'store'])->name('app.create');
});
