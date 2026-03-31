<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SachController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;


Route::get('/', [SachController::class, 'index']);

Route::get('/sach', [SachController::class, 'index'])->name('sach.index');
Route::get('/sach/theloai/{id}', [SachController::class, 'theoTheLoai'])->name('sach.theloai');
Route::get('/sach/{id}', [SachController::class, 'show'])->name('show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Account
  Route::get('/accountpanel', [AccountController::class, 'accountpanel'])
    ->middleware('auth')
    ->name('account');
    Route::post('/saveaccountinfo', [AccountController::class, 'saveaccountinfo'])->name('saveinfo');
});

require __DIR__.'/auth.php';