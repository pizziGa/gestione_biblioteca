<?php

use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::redirect('/', 'catalogo');

    Route::get('catalogo', [CustomerController::class, 'create'])->name('customer.catalogo');
    Route::get('catalogo/{id}', [CustomerController::class, 'show']);

    Route::get('prenotazioni', [CustomerController::class, 'myBookings'])->name('customer.prenotazioni');

    Route::post('prenotazioni', [BookingController::class, 'store'])->name('customer.prenotazione');
    Route::delete('prenotazioni/{id}', [BookingController::class, 'delete']);
});
