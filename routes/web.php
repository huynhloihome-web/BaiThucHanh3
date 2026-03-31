<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SachController;
use App\Http\Controllers\BookManageController;
use Illuminate\Support\Facades\Route;

// Route trang chủ - chuyển hướng đến sach
Route::get('/', function () {
    return redirect('/sach');
});

// Routes cho sách
Route::get('/sach', [SachController::class, 'index'])->name('sach.index');
Route::get('/sach/theloai/{id}', [SachController::class, 'theoTheLoai'])->name('sach.theloai');
Route::get('/sach/{id}', [SachController::class, 'show'])->name('show');

// Route home cho menu
Route::get('/home', function() {
    return redirect('/sach');
})->name('home');

// Route quản lý sách
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('books', BookManageController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';