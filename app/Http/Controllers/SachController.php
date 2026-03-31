<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\TheLoai;

class SachController extends Controller
{
    // Hiển thị tất cả sách
    public function index()
    {
        $saches = Sach::with('theLoai')->orderBy('id')->paginate(12);
        $title = 'Danh sách sách';
        return view('index', compact('saches', 'title'));
    }
    
    // Hiển thị sách theo thể loại
    public function theoTheLoai($id)
    {
        $theLoai = TheLoai::findOrFail($id);
        $saches = Sach::where('the_loai', $id)
                      ->with('theLoai')
                      ->orderBy('id')
                      ->paginate(12);
        $title = 'Thể loại: ' . $theLoai->ten_the_loai;
        return view('index', compact('saches', 'title'));
    }
    // Hiển thị chi tiết sách
    public function show($id)
    {
        // Lấy thông tin sách cùng với thể loại
        $sach = Sach::with('theLoai')->findOrFail($id);
        $title = 'Chi tiết sách: ' . $sach->tieu_de;
        
        // Lấy sách cùng thể loại (không bao gồm sách hiện tại)
        $sachCungTheLoai = Sach::where('the_loai', $sach->the_loai)
                               ->where('id', '!=', $id)
                               ->limit(5)
                               ->get();
        
        return view('show', compact('sach', 'title', 'sachCungTheLoai'));
    }
}