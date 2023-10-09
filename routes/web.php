<?php

use App\Http\Middleware\TelegramAuthMiddleware;
use App\Livewire\HomePage;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/livewire/update', $handle)->middleware([TelegramAuthMiddleware::class]);
});


Route::get('/', HomePage::class)->name('home');