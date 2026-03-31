{{-- resources/views/admin/books/edit.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header bg-warning text-dark">
        <h4 class="mb-0"><i class="fas fa-edit"></i> CẬP NHẬT SÁCH</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.books.update', $book->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="tieu_de" class="form-control" value="{{ old('tieu_de', $book->tieu_de) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nhà xuất bản</label>
                        <input type="text" name="nha_xuat_ban" class="form-control" value="{{ old('nha_xuat_ban', $book->nha_xuat_ban) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nhà cung cấp</label>
                        <input type="text" name="nha_cung_cap" class="form-control" value="{{ old('nha_cung_cap', $book->nha_cung_cap) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Tác giả</label>
                        <input type="text" name="tac_gia" class="form-control" value="{{ old('tac_gia', $book->tac_gia) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Hình thức bìa</label>
                        <select name="hinh_thuc_bia" class="form-control">
                            <option value="">-- Chọn --</option>
                            <option value="Bìa Mềm" {{ old('hinh_thuc_bia', $book->hinh_thuc_bia) == 'Bìa Mềm' ? 'selected' : '' }}>Bìa Mềm</option>
                            <option value="Bìa Cứng" {{ old('hinh_thuc_bia', $book->hinh_thuc_bia) == 'Bìa Cứng' ? 'selected' : '' }}>Bìa Cứng</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Thể loại</label>
                        <select name="the_loai" class="form-control">
                            <option value="">-- Chọn thể loại --</option>
                            @foreach($theLoais as $theLoai)
                            <option value="{{ $theLoai->id }}" {{ old('the_loai', $book->the_loai) == $theLoai->id ? 'selected' : '' }}>
                                {{ $theLoai->ten_the_loai }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Giá bán <span class="text-danger">*</span></label>
                        <input type="number" name="gia_ban" class="form-control" value="{{ old('gia_ban', $book->gia_ban) }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Link ảnh bìa (URL)</label>
                        <input type="text" name="link_anh_bia" class="form-control" value="{{ old('link_anh_bia', $book->link_anh_bia) }}" placeholder="https://...">
                        <small class="text-muted">Nhập URL ảnh từ internet (VD: từ Fahasa)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Hoặc upload ảnh mới</label>
                        @if($book->file_anh_bia)
                            <div class="mb-2">
                                <img src="{{ asset('storage/book_image/'.$book->file_anh_bia) }}" 
                                     style="width: 100px; height: auto;" alt="{{ $book->tieu_de }}">
                            </div>
                        @endif
                        <input type="file" name="file_anh_bia" class="form-control" accept="image/*">
                        <small class="text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Ảnh hiện tại:</label>
                        @if($book->link_anh_bia)
                            <div class="mt-1">
                                <img src="{{ $book->link_anh_bia }}" style="width: 100px; height: auto;" alt="{{ $book->tieu_de }}">
                                <br>
                                <small class="text-info">Đang dùng link: {{ Str::limit($book->link_anh_bia, 50) }}</small>
                            </div>
                        @elseif($book->file_anh_bia)
                            <div class="mt-1">
                                <img src="{{ asset('storage/book_image/'.$book->file_anh_bia) }}" style="width: 100px; height: auto;" alt="{{ $book->tieu_de }}">
                                <br>
                                <small class="text-info">Đang dùng ảnh upload</small>
                            </div>
                        @else
                            <span class="text-muted">Chưa có ảnh</span>
                        @endif
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea name="mo_ta" class="form-control" rows="5">{{ old('mo_ta', $book->mo_ta) }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</div>
@endsection