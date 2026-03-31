<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Trang sách' }}</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
     .navbar {
    background-color: #ff5850;
    font-weight: bold;
    padding: 0; 
    }
    .navbar .ml-auto {
    padding-right: 10px;
}

    .container {
        max-width: 1140px;
        padding-left: 0;
        padding-right: 0;
    }

    .nav-link {
        color: #fff !important;
    }

    /* GRID SÁCH */
    .list-book {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    /* CARD */
    .book {
        text-align: center;
    }

    .card {
        height: 100%;
        border-radius: 10px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    /* ẢNH SÁCH (QUAN TRỌNG NHẤT) */
    .card-img-top {
        width: 100%;
        height: 250px;          /* cố định chiều cao */
        object-fit: cover;      /* ảnh không méo */
        padding: 10px;
    }

    /* TEXT */
    .card-title {
        font-size: 16px;
        font-weight: bold;
        min-height: 40px; /* giữ đều chiều cao tiêu đề */
    }

    .card-text {
        font-size: 14px;
        color: #555;
    }
   
    
/* RESPONSIVE */
@media (max-width: 992px) {
    .list-book {
        grid-template-columns: repeat(3, 1fr);
    }
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
</head>

<body>

    

 <header class="mt-2">
    <div class="container">
        <img src="{{asset('images/banner_sach.jpg')}}" class="img-fluid w-100">
        
        {{-- NAVBAR nằm NGAY TRONG container để bằng chiều rộng banner --}}
        <nav class="navbar navbar-expand-lg">
            {{-- Không dùng thêm class container ở đây nữa vì đã nằm trong container cha --}}
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('sach') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('sach/theloai/1') }}">Tiểu thuyết</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('sach/theloai/2') }}">Truyện ngắn - tản văn</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('sach/theloai/3') }}">Tác phẩm kinh điển</a>
                </li>
            </ul>

        {{-- USER --}}
        <ul class="navbar-nav ml-auto">
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('account') }}">Quản lý</a>

                        <div class="dropdown-divider"></div>

                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button class="dropdown-item" type="submit">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </li>
            @else
                <li class="nav-item">
    <a href="{{ route('login') }}" class="btn btn-sm btn-primary mr-2">
        Đăng nhập
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('register') }}" class="btn btn-sm btn-success">
        Đăng ký
    </a>
</li>
            @endauth
        </ul>

    </div>
</nav>

    {{-- CONTENT FULL --}}
    <main class="container mt-3">
        @yield('content')
    </main>

    {{-- JS --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>