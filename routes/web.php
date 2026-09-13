<?php

use App\Http\Controllers\Main\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::domain('localhost')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/about', 'main.about')->name('about');
    Route::view('/contact', 'main.contact')->name('contact');
    require __DIR__.'/auth.php';
});

Route::domain('thestellarsurge.com')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::view('/about', 'main.about')->name('about');
    Route::view('/contact', 'main.contact')->name('contact');
    require __DIR__.'/auth.php';
});

Route::get('/manifest.json', function () {
    return response()->file(public_path('manifest.json'));
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

require __DIR__.'/events.php';
require __DIR__.'/entrepreneurship.php';
require __DIR__.'/training.php';
