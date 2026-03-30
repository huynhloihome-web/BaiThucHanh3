<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/add-test', function () {
    DB::table('sach')->insert([
        'ten_sach' => 'Nhà giả kim',
        'tac_gia' => 'Paulo Coelho',
        'gia' => 61620,
        'hinh_anh' => 'nhagiakim.jpg'
    ]);

    return "Đã thêm dữ liệu!";
});
use App\Http\Controllers\SachController;

Route::get('/', function () {
    return redirect('/sach');
});

Route::get('/sach', [SachController::class, 'index'])->name('sach.index');
Route::get('/sach/theloai/{id}', [SachController::class, 'theoTheLoai'])->name('sach.theloai');
Route::get('/sach/{id}', [SachController::class, 'show'])->name('show');