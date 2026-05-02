<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProdukController;
// use App\Http\Controllers\IndexController;
Route::get('/', [ProdukController::class, 'index'])->name('index');
