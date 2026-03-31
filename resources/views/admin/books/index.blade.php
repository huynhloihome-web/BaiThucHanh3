{{-- resources/views/admin/books/index.blade.php --}}
@extends('admin.layout')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white text-center">
        <h4 class="mb-0">DANH MỤC SÁCH</h4>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-light">
                    <tr>
                        <th>Tiêu đề</th>
                        <th>Nhà xuất bản</th>
                        <th>Nhà cung cấp</th>
                        <th>Tác giả</th>
                        <th>Hình thức bìa</th>
                        <th>Giá bán</th>
                        <th>Hình ảnh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                    <tr>
                        <td>{{ $book->tieu_de }}</td>
                        <td>{{ $book->nha_xuat_ban ?? '---' }}</td>
                        <td>{{ $book->nha_cung_cap ?? '---' }}</td>
                        <td>{{ $book->tac_gia ?? '---' }}</td>
                        <td>{{ $book->hinh_thuc_bia ?? '---' }}</td>
                        <td>{{ number_format($book->gia_ban, 0, ',', '.') }}</td>
                        <td class="text-center">
                            @if($book->link_anh_bia)
                                <img src="{{ $book->link_anh_bia }}" 
                                     style="width: 50px; height: 70px; object-fit: cover;" 
                                     alt="{{ $book->tieu_de }}">
                            @elseif($book->file_anh_bia)
                                <img src="{{ asset('storage/book_image/'.$book->file_anh_bia) }}" 
                                     style="width: 50px; height: 70px; object-fit: cover;" 
                                     alt="{{ $book->tieu_de }}">
                            @else
                                <span class="text-muted">Chưa có ảnh</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.books.edit', $book->id) }}" 
                               class="btn btn-sm btn-warning">
                                Sửa
                            </a>
                            <form action="{{ route('admin.books.destroy', $book->id) }}" 
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Bạn có chắc chắn muốn xóa sách này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Xóa
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Chưa có dữ liệu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection