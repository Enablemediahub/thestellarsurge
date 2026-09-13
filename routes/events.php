<?php

use App\Http\Controllers\Events\EventController;
use Illuminate\Support\Facades\Route;

Route::domain('events.thestellarsurge.com')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner');
    Route::get('/{slug}', [EventController::class, 'show'])->name('events.show');
    Route::get('/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout');
    Route::post('/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase');
    Route::get('/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback');
    Route::get('/tickets/verify', [EventController::class, 'verifyTicket'])->name('events.ticket.verify');
    Route::post('/tickets/verify', [EventController::class, 'confirmTicket'])->name('events.ticket.verify.confirm');
    Route::get('/{slug}/success', [EventController::class, 'success'])->name('events.success');
    Route::get('/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf');
});

Route::group([], function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index.local');
    Route::get('/events/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner.local');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.local');
    Route::get('/events/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout.local');
    Route::post('/events/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase.local');
    Route::get('/events/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback.local');
    Route::get('/events/tickets/verify', [EventController::class, 'verifyTicket'])->name('events.ticket.verify.local');
    Route::post('/events/tickets/verify', [EventController::class, 'confirmTicket'])->name('events.ticket.verify.confirm.local');
    Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success.local');
    Route::get('/events/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf.local');
});

Route::prefix('thestellarsurge/public')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index.path');
    Route::get('/events/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner.path');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.path');
    Route::get('/events/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout.path');
    Route::post('/events/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase.path');
    Route::get('/events/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback.path');
    Route::get('/events/tickets/verify', [EventController::class, 'verifyTicket'])->name('events.ticket.verify.path');
    Route::post('/events/tickets/verify', [EventController::class, 'confirmTicket'])->name('events.ticket.verify.confirm.path');
    Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success.path');
    Route::get('/events/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf.path');
});
