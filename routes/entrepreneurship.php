<?php

use App\Http\Controllers\Entrepreneurship\EntrepreneurshipController;
use Illuminate\Support\Facades\Route;

Route::domain('entrepreneurship.thestellarsurge.com')->group(function () {
    Route::get('/', [EntrepreneurshipController::class, 'index'])->name('entrepreneurship.index');
});

Route::group([], function () {
    Route::get('/entrepreneurship', [EntrepreneurshipController::class, 'index'])->name('entrepreneurship.index.local');
});

Route::prefix('thestellarsurge/public')->group(function () {
    Route::get('/entrepreneurship', [EntrepreneurshipController::class, 'index'])->name('entrepreneurship.index.path');
});
