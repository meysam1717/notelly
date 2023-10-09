<?php

use App\Http\Middleware\TelegramAuthMiddleware;
use App\Livewire\Folder\AddFolder;
use App\Livewire\Folder\EditFolder;
use App\Livewire\HomePage;
use App\Livewire\Note\AddNote;
use App\Livewire\Note\EditNote;
use App\Livewire\Note\NoteList;
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
Route::get('/add-folder', AddFolder::class)->name('add-folder');
Route::get('/folder/{id}/edit', EditFolder::class)->name('edit-folder');
Route::get('/folder/{id}/notes', NoteList::class)->name('note-list');
Route::get('/folder/{id}/add-note', AddNote::class)->name('add-note');
Route::get('/folder/{id}/note/{noteId}/edit', EditNote::class)->name('edit-note');