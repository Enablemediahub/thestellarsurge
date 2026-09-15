<?php

use App\Http\Controllers\Entrepreneurship\EntrepreneurshipController;
use Illuminate\Support\Facades\Route;

Route::domain('entrepreneurship.thestellarsurge.com')->group(function () {
    Route::get('/', [EntrepreneurshipController::class, 'index'])->name('event_planning.index');
});

Route::group([], function () {
    Route::get('/event_planning', [EntrepreneurshipController::class, 'index'])->name('event_planning.index.local');
    Route::get('/event_planning/gallery', [EntrepreneurshipController::class, 'gallery'])->name('event_planning.gallery.local');
    Route::post('/event_planning', [EntrepreneurshipController::class, 'store'])->name('event_planning.store.local');
    Route::redirect('/entrepreneurship', '/event_planning', 301);
});

Route::prefix('thestellarsurge/public')->group(function () {
    Route::get('/event_planning', [EntrepreneurshipController::class, 'index'])->name('event_planning.index.path');
    Route::get('/event_planning/gallery', [EntrepreneurshipController::class, 'gallery'])->name('event_planning.gallery.path');
    Route::post('/event_planning', [EntrepreneurshipController::class, 'store'])->name('event_planning.store.path');
    Route::redirect('/entrepreneurship', '/thestellarsurge/public/event_planning', 301);
});
