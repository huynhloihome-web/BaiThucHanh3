@extends('components.book-layout')

@section('content')
<style>
    .book-detail-container {
        background: #fff;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .book-cover {
        text-align: center;
        margin-bottom: 20px;
        position: sticky;
        top: 20px;
    }

    .book-cover img {
        max-width: 100%;
        border-radius: 10px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        transition: transform 0.3s;
    }

    .book-cover img:hover {
        transform: scale(1.02);
    }

    .no-image {
        background: #f5f5f5;
        padding: 100px 20px;
        text-align: center;
        border-radius: 10px;
        color: #999;
    }

    .book-title {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .book-meta {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
    }

    .meta-item {
        display: flex;
        padding: 10px 0;
        border-bottom: 1px solid #e9ecef;
    }

    .meta-item:last-child {
        border-bottom: none;
    }

    .meta-label {
        font-weight: bold;
        color: #ff5850;
        min-width: 140px;
        font-size: 16px;
    }

    .meta-value {
        color: #555;
        font-size: 16px;
    }

    .meta-value a {
        color: #ff5850;
        text-decoration: none;
    }

    .meta-value a:hover {
        text-decoration: underline;
    }

    .book-price {
        background: linear-gradient(135deg, #ff5850 0%, #ff7e6b 100%);
        color: white;
        padding: 15px 20px;
        border-radius: 10px;
        margin: 20px 0;
        text-align: center;
    }

    .price-label {
        font-size: 18px;
        margin-bottom: 5px;
    }

    .price-value {
        font-size: 32px;
        font-weight: bold;
    }

    .book-actions {
        margin-top: 20px;
    }

    .quantity-box {
        margin-bottom: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .book-description {
        margin-top: 40px;
    }

    .section-title {
        color: #ff5850;
        font-size: 24px;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 3px solid #ff5850;
        display: inline-block;
    }

    .description-content {
        line-height: 1.8;
        text-align: justify;
        background: #fafafa;
        padding: 20px;
        border-radius: 10px;
        max-height: 500px;
        overflow-y: auto;
    }

    .related-books {
        margin-top: 50px;
    }

    .related-title {
        color: #ff5850;
        font-size: 24px;
        margin-bottom: 25px;
        padding-bottom: 10px;
        border-bottom: 3px solid #ff5850;
        display: inline-block;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 20px;
        margin-top: 20px;
    }

    .related-book-item {
        text-align: center;
        transition: transform 0.3s;
    }

    .related-book-item:hover {
        transform: translateY(-5px);
    }

    .related-book-item a {
        text-decoration: none;
    }

    .related-book-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .related-book-title {
        font-size: 14px;
        font-weight: bold;
        color: #333;
        height: 40px;
        overflow: hidden;
        margin: 8px 0;
    }

    .related-book-price {
        color: #ff5850;
        font-weight: bold;
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .book-detail-container {
            padding: 15px;
        }

        .book-title {
            font-size: 24px;
        }

        .meta-label {
            min-width: 110px;
            font-size: 14px;
        }

        .related-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 576px) {
        .related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>

<div class="book-detail-container">
    <div class="row">
        <div class="col-md-4">
            <div class="book-cover">
                @if($sach->link_anh_bia && filter_var($sach->link_anh_bia, FILTER_VALIDATE_URL))
                    <img src="{{ $sach->link_anh_bia }}" alt="{{ $sach->tieu_de }}" style="width: 100%;">
                @else
                    <div class="no-image">
                        <i class="fas fa-book fa-4x"></i>
                        <p style="margin-top: 10px;">Không có ảnh bìa</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <h1 class="book-title">{{ $sach->tieu_de }}</h1>

            <div class="book-meta">
                <div class="meta-item">
                    <div class="meta-label">Tác giả:</div>
                    <div class="meta-value">{{ $sach->tac_gia ?? 'Không rõ' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Nhà cung cấp:</div>
                    <div class="meta-value">{{ $sach->nha_cung_cap ?? 'Không rõ' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Nhà xuất bản:</div>
                    <div class="meta-value">{{ $sach->nha_xuat_ban ?? 'Không rõ' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Hình thức bìa:</div>
                    <div class="meta-value">{{ $sach->hinh_thuc_bia ?? 'Không rõ' }}</div>
                </div>
                <div class="meta-item">
                    <div class="meta-label">Thể loại:</div>
                    <div class="meta-value">
                        <a href="{{ url('sach/theloai/' . $sach->the_loai) }}">
                            {{ $sach->theLoai->ten_the_loai ?? 'Không xác định' }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="book-price">
                <div class="price-label">Giá bán</div>
                <div class="price-value">{{ number_format($sach->gia_ban) }} đ</div>
            </div>

            <div class="book-actions">
                <div class="quantity-box">
                    <label for="product-number"><strong>Số lượng mua:</strong></label><br>
                    <input
                        type="number"
                        id="product-number"
                        min="1"
                        value="1"
                        class="form-control"
                        style="width:120px; display:inline-block;"
                    >
                </div>

                <div class="action-buttons">
                    <button class="btn btn-success btn-sm" id="add-to-cart">
                        Thêm vào giỏ hàng
                    </button>

                    <form method="POST" action="{{ route('buynow') }}" style="display:inline-block; margin:0;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $sach->id }}">
                        <input type="hidden" name="num" id="buy-now-number" value="1">
                        <button type="submit" class="btn btn-danger btn-sm">
                            Mua ngay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="book-description">
        <div class="section-title">Mô tả sách</div>
        <div class="description-content">
            {!! nl2br(e($sach->mo_ta)) !!}
        </div>
    </div>

    @if($sachCungTheLoai->count() > 0)
        <div class="related-books">
            <div class="related-title">Sách cùng thể loại</div>
            <div class="related-grid">
                @foreach($sachCungTheLoai as $sachLienQuan)
                    <div class="related-book-item">
                        <a href="{{ url('sach/' . $sachLienQuan->id) }}">
                            @if($sachLienQuan->link_anh_bia && filter_var($sachLienQuan->link_anh_bia, FILTER_VALIDATE_URL))
                                <img src="{{ $sachLienQuan->link_anh_bia }}" alt="{{ $sachLienQuan->tieu_de }}">
                            @else
                                <div style="background: #f5f5f5; height: 180px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                    <i class="fas fa-book fa-3x" style="color: #ccc;"></i>
                                </div>
                            @endif

                            <div class="related-book-title">
                                {{ \Illuminate\Support\Str::limit($sachLienQuan->tieu_de, 40) }}
                            </div>

                            <div class="related-book-price">
                                {{ number_format($sachLienQuan->gia_ban) }} đ
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
    $("#add-to-cart").click(function () {
        let id = "{{ $sach->id }}";
        let num = $("#product-number").val();

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

    $("#product-number").on("input change", function () {
        $("#buy-now-number").val($(this).val());
    });
});
</script>
@endsection