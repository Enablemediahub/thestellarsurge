<?php

use App\Http\Controllers\Training\TrainingController;
use Illuminate\Support\Facades\Route;

Route::domain('training.thestellarsurge.com')->group(function () {
    Route::get('/', [TrainingController::class, 'index'])->name('training.index');
});

Route::domain('localhost')->group(function () {
    Route::get('/training', [TrainingController::class, 'index'])->name('training.index.local');
});

Route::domain('localhost')->prefix('thestellarsurge/public')->group(function () {
    Route::get('/training', [TrainingController::class, 'index'])->name('training.index.path');
});
