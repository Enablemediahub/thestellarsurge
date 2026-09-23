<?php

use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\Main\CommunityController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/events.php';
require __DIR__.'/entrepreneurship.php';
require __DIR__.'/training.php';

Route::group([], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/about', 'main.about')->name('about');
    Route::view('/contact', 'main.contact')->name('contact');
    Route::get('/consultation', [\App\Http\Controllers\Main\ContentController::class, 'consultation'])->name('consultation');
    Route::get('/blogsurge', [\App\Http\Controllers\Main\ContentController::class, 'blog'])->name('blogsurge');
    Route::get('/blogsurge/{slug}', [\App\Http\Controllers\Main\ContentController::class, 'post'])->name('blogsurge.post');
    Route::post('/consultation', [CommunityController::class, 'consultation'])->name('consultation.store');
    Route::post('/testimonials', [CommunityController::class, 'testimonial'])->name('testimonials.store');
    Route::post('/subscribe', [CommunityController::class, 'subscribe'])->name('subscribers.store');
    require __DIR__.'/auth.php';
});

Route::domain('thestellarsurge.com')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/about', 'main.about')->name('about');
    Route::view('/contact', 'main.contact')->name('contact');
    Route::get('/consultation', [\App\Http\Controllers\Main\ContentController::class, 'consultation'])->name('consultation.production');
    Route::get('/blogsurge', [\App\Http\Controllers\Main\ContentController::class, 'blog'])->name('blogsurge.production');
    Route::get('/blogsurge/{slug}', [\App\Http\Controllers\Main\ContentController::class, 'post'])->name('blogsurge.post.production');
    Route::post('/consultation', [CommunityController::class, 'consultation'])->name('consultation.store.production');
    Route::post('/testimonials', [CommunityController::class, 'testimonial'])->name('testimonials.store.production');
    Route::post('/subscribe', [CommunityController::class, 'subscribe'])->name('subscribers.store.production');
    require __DIR__.'/auth.php';
});

Route::prefix('thestellarsurge/public')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.path');
    Route::get('/consultation', [\App\Http\Controllers\Main\ContentController::class, 'consultation'])->name('consultation.path');
    Route::get('/blogsurge', [\App\Http\Controllers\Main\ContentController::class, 'blog'])->name('blogsurge.path');
    Route::get('/blogsurge/{slug}', [\App\Http\Controllers\Main\ContentController::class, 'post'])->name('blogsurge.post.path');
    Route::post('/consultation', [CommunityController::class, 'consultation'])->name('consultation.store.path');
    Route::post('/testimonials', [CommunityController::class, 'testimonial'])->name('testimonials.store.path');
    Route::post('/subscribe', [CommunityController::class, 'subscribe'])->name('subscribers.store.path');
});

Route::get('/manifest.json', function () {
    return response()->file(public_path('manifest.json'));
});

Route::get('/ticket-scanner-manifest.json', function () {
    return response()->file(public_path('ticket-scanner-manifest.json'));
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

