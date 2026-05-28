<?php

use App\Http\Controllers\SortingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sorting', [SortingController::class, 'index'])->name('sorting.index');
Route::post('/sorting/generate', [SortingController::class, 'generate'])->name('sorting.generate');
