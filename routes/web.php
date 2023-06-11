<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('profile/{user}', [\App\Http\Controllers\FriendController::class, 'profile'])->name('friends.profile');

Route::middleware('auth')->group(function () {
    Route::post('/friends/{user}', [\App\Http\Controllers\FriendController::class, 'store'])->name('friends.store');
    Route::delete('/friends/{user}', [\App\Http\Controllers\FriendController::class, 'destroy'])->name('friends.destroy');
    Route::patch('/friends/{user}', [\App\Http\Controllers\FriendController::class, 'accept'])->name('friends.accept');
    Route::get('/friends', [\App\Http\Controllers\FriendController::class, 'index'])->name('friends.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
