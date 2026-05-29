<?php

use App\Http\Controllers\ExportController;
use App\Http\Controllers\SortingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sorting', [SortingController::class, 'index'])->name('sorting.index');
Route::post('/sorting/generate', [SortingController::class, 'generate'])->name('sorting.generate');

Route::prefix('export')->name('export.')->group(function () {
    Route::get('/', [ExportController::class, 'index'])->name('index');
    Route::post('start', [ExportController::class, 'start'])->name('start');
    Route::post('chunk', [ExportController::class, 'chunk'])->name('chunk');
    Route::get('download/{exportId}', [ExportController::class, 'download'])->name('download');
});
