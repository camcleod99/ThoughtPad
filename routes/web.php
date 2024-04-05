<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ThoughtController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/search' , function () {
    return Inertia::render('Search/Index');
})->middleware(['auth', 'verified'])->name('search');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('thoughts', ThoughtController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

/* Thought Controller GET Routes */
Route::get('/thoughts', [ThoughtController::class, 'index'])->middleware(['auth', 'verified'])->name('thoughts.index');
Route::get('/drafts', [ThoughtController::class, 'drafts'])->middleware(['auth', 'verified'])->name('thoughts.drafts');
Route::get('/deleted', [ThoughtController::class, 'deleted'])->middleware(['auth', 'verified'])->name('thoughts.deleted');
Route::get('/search/results', [ThoughtController::class, 'results'])->middleware(['auth', 'verified'])->name('search.results');
Route::get('thoughts.search', [ThoughtController::class, 'search'])->middleware(['auth', 'verified'])->name('thoughts.search');

/* Thought Controller POST Routes */
Route::post('thoughts.updateStatus', [ThoughtController::class, 'updateStatus'])->middleware(['auth', 'verified'])->name('thoughts.updateStatus');
Route::post('thoughts.search', [ThoughtController::class, 'search'])->middleware(['auth', 'verified'])->name('search/results');
require __DIR__.'/auth.php';
