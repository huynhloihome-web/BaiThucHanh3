<?php
// app/Http/Controllers/BookManageController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sach;
use App\Models\TheLoai;
use Illuminate\Support\Facades\Storage;

class BookManageController extends Controller
{   
    // Hiển thị danh sách sách
    public function index()
    {
        $books = Sach::orderBy('id', 'desc')->get();
        return view('admin.books.index', compact('books'));
    }

    // Hiển thị form thêm sách
    public function create()
    {
        $theLoais = TheLoai::all();
        return view('admin.books.create', compact('theLoais'));
    }

    // Xử lý thêm sách
    public function store(Request $request)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:200',
            'nha_cung_cap' => 'nullable|string|max:50',
            'nha_xuat_ban' => 'nullable|string|max:50',
            'tac_gia' => 'nullable|string|max:100',
            'hinh_thuc_bia' => 'nullable|string|max:50',
            'mo_ta' => 'nullable|string',
            'file_anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gia_ban' => 'required|numeric',
            'the_loai' => 'nullable|integer'
        ]);

        $data = [
            'tieu_de' => $request->tieu_de,
            'nha_cung_cap' => $request->nha_cung_cap,
            'nha_xuat_ban' => $request->nha_xuat_ban,
            'tac_gia' => $request->tac_gia,
            'hinh_thuc_bia' => $request->hinh_thuc_bia,
            'mo_ta' => $request->mo_ta,
            'gia_ban' => $request->gia_ban,
            'the_loai' => $request->the_loai
        ];

        // Xử lý upload ảnh
        if ($request->hasFile('file_anh_bia')) {
            $fileName = 'image_' . time() . '_' . $request->file('file_anh_bia')->getClientOriginalName();
            $request->file('file_anh_bia')->storeAs('public/book_image', $fileName);
            $data['file_anh_bia'] = $fileName;
        }

        Sach::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Thêm sách thành công!');
    }

    // Hiển thị form sửa sách
    public function edit($id)
    {
        $book = Sach::findOrFail($id);
        $theLoais = TheLoai::all();
        return view('admin.books.edit', compact('book', 'theLoais'));
    }

    // Xử lý cập nhật sách
    public function update(Request $request, $id)
    {
        $request->validate([
            'tieu_de' => 'required|string|max:200',
            'nha_cung_cap' => 'nullable|string|max:50',
            'nha_xuat_ban' => 'nullable|string|max:50',
            'tac_gia' => 'nullable|string|max:100',
            'hinh_thuc_bia' => 'nullable|string|max:50',
            'mo_ta' => 'nullable|string',
            'file_anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gia_ban' => 'required|numeric',
            'the_loai' => 'nullable|integer'
        ]);

        $book = Sach::findOrFail($id);
        
        $data = [
            'tieu_de' => $request->tieu_de,
            'nha_cung_cap' => $request->nha_cung_cap,
            'nha_xuat_ban' => $request->nha_xuat_ban,
            'tac_gia' => $request->tac_gia,
            'hinh_thuc_bia' => $request->hinh_thuc_bia,
            'mo_ta' => $request->mo_ta,
            'gia_ban' => $request->gia_ban,
            'the_loai' => $request->the_loai
        ];

        // Xử lý upload ảnh mới
        if ($request->hasFile('file_anh_bia')) {
            // Xóa ảnh cũ nếu có
            if ($book->file_anh_bia && Storage::exists('public/book_image/' . $book->file_anh_bia)) {
                Storage::delete('public/book_image/' . $book->file_anh_bia);
            }
            
            $fileName = 'image_' . time() . '_' . $request->file('file_anh_bia')->getClientOriginalName();
            $request->file('file_anh_bia')->storeAs('public/book_image', $fileName);
            $data['file_anh_bia'] = $fileName;
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Cập nhật sách thành công!');
    }

    // Xử lý xóa sách
    public function destroy($id)
    {
        $book = Sach::findOrFail($id);
        
        // Xóa ảnh nếu có
        if ($book->file_anh_bia && Storage::exists('public/book_image/' . $book->file_anh_bia)) {
            Storage::delete('public/book_image/' . $book->file_anh_bia);
        }
        
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Xóa sách thành công!');
    }
}