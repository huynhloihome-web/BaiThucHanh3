@extends('components.book-layout')

@section('content')
<style>
    .order-wrapper {
        background: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0,0,0,0.08);
    }

    .order-title {
        color: #15c;
        font-weight: bold;
        font-size: 22px;
        text-align: center;
        margin-bottom: 20px;
    }

    .book-table {
        border-collapse: collapse;
        width: 100%;
        margin: 0 auto;
    }

    .book-table th,
    .book-table td {
        border: 1px solid #ddd;
        padding: 10px;
    }

    .book-table th {
        background-color: #f8f9fa;
        text-align: center;
    }

    .book-table td {
        vertical-align: middle;
    }

    .empty-cart {
        text-align: center;
        padding: 20px 0;
        color: #666;
    }

    .auth-box {
        text-align: center;
        margin-top: 20px;
    }

    .auth-box p {
        margin-bottom: 12px;
        font-weight: bold;
    }

    .payment-form {
        margin-top: 20px;
        text-align: center;
        font-weight: bold;
    }

    .payment-form select {
        width: 220px;
        display: inline-block;
    }

    .success-message {
        width: 100%;
        margin-bottom: 15px;
    }
</style>

<div class="order-wrapper">
    <div class="order-title">
        DANH SÁCH SẢN PHẨM
    </div>

    @if(session('status'))
        <div class="alert alert-success success-message">
            {{ session('status') }}
        </div>
    @endif

    <table class="book-table">
        <thead>
            <tr>
                <th style="width: 70px;">STT</th>
                <th>Tên sách</th>
                <th style="width: 120px;">Số lượng</th>
                <th style="width: 150px;">Đơn giá</th>
                <th style="width: 120px;">Xóa</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tongTien = 0;
            @endphp

            @forelse($data as $key => $row)
                @php
                    $soLuong = $quantity[$row->id] ?? 1;
                    $tongTien += $soLuong * $row->gia_ban;
                @endphp

                <tr>
                    <td align="center">{{ $key + 1 }}</td>
                    <td>{{ $row->tieu_de }}</td>
                    <td align="center">{{ $soLuong }}</td>
                    <td align="center">{{ number_format($row->gia_ban, 0, ',', '.') }}đ</td>
                    <td align="center">
                        <form method="POST" action="{{ route('cartdelete') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $row->id }}">
                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-cart">
                        Chưa có sản phẩm trong giỏ hàng
                    </td>
                </tr>
            @endforelse

            @if(count($data) > 0)
                <tr>
                    <td colspan="3" align="center"><b>Tổng cộng</b></td>
                    <td align="center"><b>{{ number_format($tongTien, 0, ',', '.') }}đ</b></td>
                    <td></td>
                </tr>
            @endif
        </tbody>
    </table>

    @auth
        <div class="payment-form">
            @if(count($data) > 0)
                <form method="POST" action="{{ route('ordercreate') }}">
                    @csrf

                    @foreach($data as $row)
                        <input type="hidden" name="book_id[]" value="{{ $row->id }}">
                        <input type="hidden" name="so_luong[{{ $row->id }}]" value="{{ $quantity[$row->id] ?? 1 }}">
                    @endforeach

                    <input type="hidden" name="order_type" value="{{ count($data) == 1 ? 'buy_now' : 'cart' }}">

                    <div class="mb-2">Hình thức thanh toán</div>

                    <select name="hinh_thuc_thanh_toan" class="form-control form-control-sm">
                        <option value="1">Tiền mặt</option>
                        <option value="2">Chuyển khoản</option>
                        <option value="3">Thanh toán VNPay</option>
                    </select>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-sm btn-primary">ĐẶT HÀNG</button>
                    </div>
                </form>
            @else
                <div style="margin-top: 15px;">
                    Vui lòng chọn sản phẩm cần mua
                </div>
            @endif
        </div>
    @else
        <div class="auth-box">
            @if(count($data) > 0)
                <p>Vui lòng đăng nhập trước khi đặt hàng</p>
                <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-success">Đăng ký</a>
            @else
                <p>Vui lòng chọn sản phẩm cần mua</p>
            @endif
        </div>
    @endauth
</div>
@endsection