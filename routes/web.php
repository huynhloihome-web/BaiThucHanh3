<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SachController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return redirect('/sach');
});

Route::get('/sach', [SachController::class, 'index'])->name('sach.index');
Route::get('/sach/theloai/{id}', [SachController::class, 'theoTheLoai'])->name('sach.theloai');
Route::get('/sach/{id}', [SachController::class, 'show'])->name('show');

Route::post('/cart/add', [SachController::class, 'cartadd'])->name('cartadd');
Route::get('/order', [SachController::class, 'order'])->name('order');
Route::post('/cart/delete', [SachController::class, 'cartdelete'])->name('cartdelete');
Route::post('/order/create', [SachController::class, 'ordercreate'])->middleware('auth')->name('ordercreate');
Route::post('/buy-now', [SachController::class, 'buyNow'])->name('buynow');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';