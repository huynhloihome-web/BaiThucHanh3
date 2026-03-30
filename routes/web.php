<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SachController;

Route::get('/', function () {
    return redirect('/sach');
});

Route::get('/sach', [SachController::class, 'index'])->name('sach.index');
Route::get('/sach/theloai/{id}', [SachController::class, 'theoTheLoai'])->name('sach.theloai');
Route::get('/sach/{id}', [SachController::class, 'show'])->name('show');