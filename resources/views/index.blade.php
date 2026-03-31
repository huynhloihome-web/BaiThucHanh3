@extends('components.book-layout')

@section('content')
<style>
    .list-book {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .book {
        margin: 0;
        text-align: center;
    }

    .card {
        transition: transform 0.3s, box-shadow 0.3s;
        border: none;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }

    .card-img-top {
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .card:hover .card-img-top {
        transform: scale(1.05);
    }

    .no-image {
        background: #f5f5f5;
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        flex-direction: column;
    }

    .card-title {
        font-size: 16px;
        height: 48px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .card-title a {
        color: #333;
        text-decoration: none;
    }

    .card-title a:hover {
        color: #ff5850;
    }

    .btn-danger {
        background-color: #ff5850;
        border-color: #ff5850;
    }

    .btn-danger:hover {
        background-color: #e64a42;
        border-color: #e64a42;
    }

    .card-text {
        font-size: 14px;
    }

    .book-actions {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    @media (max-width: 768px) {
        .list-book {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .list-book {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="list-book">
    @forelse($saches as $sach)
        <div class="book">
            <div class="card h-100">
                <a href="{{ url('sach/' . $sach->id) }}">
                    @if($sach->link_anh_bia && filter_var($sach->link_anh_bia, FILTER_VALIDATE_URL))
                        <img src="{{ $sach->link_anh_bia }}" class="card-img-top" alt="{{ $sach->tieu_de }}">
                    @else
                        <div class="no-image">
                            <i class="fas fa-book fa-3x"></i>
                            <p style="margin-top: 5px;">Không có ảnh</p>
                        </div>
                    @endif
                </a>

                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ url('sach/' . $sach->id) }}">
                            {{ Str::limit($sach->tieu_de, 50) }}
                        </a>
                    </h5>

                    <p class="card-text mb-1">
                        <strong>Tác giả:</strong> {{ $sach->tac_gia ?? 'Không rõ' }}
                    </p>

                    <p class="card-text mb-2">
                        <strong>Giá:</strong>
                        <span style="color: #ff5850; font-weight: bold;">
                            {{ number_format($sach->gia_ban) }} đ
                        </span>
                    </p>

                    <div class="book-actions">
                        <a href="{{ url('sach/' . $sach->id) }}" class="btn btn-danger btn-sm">
                            Xem chi tiết
                        </a>

                        <button class="btn btn-success btn-sm add-product" book_id="{{ $sach->id }}">
                            Thêm vào giỏ hàng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p>Không có sách nào.</p>
        </div>
    @endforelse
</div>

@if(method_exists($saches, 'links'))
    <div class="d-flex justify-content-center mt-4">
        {{ $saches->links() }}
    </div>
@endif

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    $(".add-product").click(function () {
        let id = $(this).attr("book_id");
        let num = 1;

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('cartadd') }}",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "num": num
            },
            success: function (data) {
                $("#cart-number-product").html(data);
                alert("Đã thêm sách vào giỏ hàng");
            },
            error: function () {
                alert("Không thể thêm vào giỏ hàng");
            }
        });
    });
});
</script>
@endsection