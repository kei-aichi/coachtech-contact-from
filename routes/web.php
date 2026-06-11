<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;


Route::get('/', [ContactController::class, 'index']);

Route::post('/confirm', [ContactController::class, 'confirm']);

Route::post('/back', [ContactController::class, 'back']);

Route::post('/contacts', [ContactController::class, 'store']);

Route::get('/thanks', [ContactController::class, 'thanks']);


Route::get('/admin', [ContactController::class, 'admin'])->middleware('auth')->name('admin');

Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->middleware('auth')
    ->name('contacts.destroy');

Route::get('/export', [ContactController::class, 'export'])
    ->name('export');
