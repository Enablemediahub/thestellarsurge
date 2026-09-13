<?php

use App\Http\Controllers\Events\EventController;
use Illuminate\Support\Facades\Route;

Route::domain('events.thestellarsurge.com')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/{slug}', [EventController::class, 'show'])->name('events.show');
    Route::get('/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout');
    Route::post('/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase');
    Route::get('/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback');
    Route::get('/{slug}/success', [EventController::class, 'success'])->name('events.success');
    Route::get('/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf');
});

Route::domain('localhost')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index.local');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.local');
    Route::get('/events/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout.local');
    Route::post('/events/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase.local');
    Route::get('/events/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback.local');
    Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success.local');
    Route::get('/events/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf.local');
});

Route::domain('localhost')->prefix('thestellarsurge/public')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index.path');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.path');
    Route::get('/events/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout.path');
    Route::post('/events/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase.path');
    Route::get('/events/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback.path');
    Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success.path');
    Route::get('/events/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf.path');
});
