<?php

use App\Http\Controllers\Events\EventController;
use Illuminate\Support\Facades\Route;

Route::domain('events.thestellarsurge.com')->group(function () {
    Route::get('/', [EventController::class, 'index'])->name('events.index');
    Route::get('/gallery', [EventController::class, 'galleryIndex'])->name('events.gallery.index');
    Route::get('/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner');
    Route::get('/{slug}', [EventController::class, 'show'])->name('events.show');
    Route::get('/{slug}/gallery', [EventController::class, 'gallery'])->name('events.gallery');
    Route::post('/{slug}/gallery/{galleryItem}/like', [EventController::class, 'likeGalleryItem'])->name('events.gallery.like');
    Route::post('/{slug}/gallery/{galleryItem}/comments', [EventController::class, 'commentGalleryItem'])->name('events.gallery.comment');
    Route::get('/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout');
    Route::post('/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase');
    Route::get('/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback');
    Route::get('/tickets/verify', [EventController::class, 'verifyTicket'])->name('events.ticket.verify');
    Route::post('/tickets/verify', [EventController::class, 'confirmTicket'])->name('events.ticket.verify.confirm');
    Route::get('/{slug}/success', [EventController::class, 'success'])->name('events.success');
    Route::get('/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf');
});

Route::domain('thestellarsurge.com')->group(function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index.production');
    Route::get('/events/gallery', [EventController::class, 'galleryIndex'])->name('events.gallery.index.production');
    Route::get('/events/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner.production');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.production');
    Route::get('/events/{slug}/gallery', [EventController::class, 'gallery'])->name('events.gallery.production');
    Route::post('/events/{slug}/gallery/{galleryItem}/like', [EventController::class, 'likeGalleryItem'])->name('events.gallery.like.production');
    Route::post('/events/{slug}/gallery/{galleryItem}/comments', [EventController::class, 'commentGalleryItem'])->name('events.gallery.comment.production');
    Route::get('/events/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout.production');
    Route::post('/events/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase.production');
    Route::get('/events/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback.production');
    Route::get('/events/tickets/verify', [EventController::class, 'verifyTicket'])->name('events.ticket.verify.production');
    Route::post('/events/tickets/verify', [EventController::class, 'confirmTicket'])->name('events.ticket.verify.confirm.production');
    Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success.production');
    Route::get('/events/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf.production');
});

Route::group([], function () {
    Route::get('/events', [EventController::class, 'index'])->name('events.index.local');
    Route::get('/events/gallery', [EventController::class, 'galleryIndex'])->name('events.gallery.index.local');
    Route::get('/events/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner.local');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.local');
    Route::get('/events/{slug}/gallery', [EventController::class, 'gallery'])->name('events.gallery.local');
    Route::post('/events/{slug}/gallery/{galleryItem}/like', [EventController::class, 'likeGalleryItem'])->name('events.gallery.like.local');
    Route::post('/events/{slug}/gallery/{galleryItem}/comments', [EventController::class, 'commentGalleryItem'])->name('events.gallery.comment.local');
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
    Route::get('/events/gallery', [EventController::class, 'galleryIndex'])->name('events.gallery.index.path');
    Route::get('/events/tickets/', [EventController::class, 'ticketScanner'])->name('events.ticket.scanner.path');
    Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show.path');
    Route::get('/events/{slug}/gallery', [EventController::class, 'gallery'])->name('events.gallery.path');
    Route::post('/events/{slug}/gallery/{galleryItem}/like', [EventController::class, 'likeGalleryItem'])->name('events.gallery.like.path');
    Route::post('/events/{slug}/gallery/{galleryItem}/comments', [EventController::class, 'commentGalleryItem'])->name('events.gallery.comment.path');
    Route::get('/events/{slug}/checkout', [EventController::class, 'checkout'])->name('events.checkout.path');
    Route::post('/events/{slug}/checkout', [EventController::class, 'purchase'])->name('events.purchase.path');
    Route::get('/events/payment/callback', [EventController::class, 'callback'])->name('events.payment.callback.path');
    Route::get('/events/tickets/verify', [EventController::class, 'verifyTicket'])->name('events.ticket.verify.path');
    Route::post('/events/tickets/verify', [EventController::class, 'confirmTicket'])->name('events.ticket.verify.confirm.path');
    Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success.path');
    Route::get('/events/{slug}/tickets/{reference}/pdf', [EventController::class, 'downloadTicket'])->name('events.ticket.pdf.path');
});
