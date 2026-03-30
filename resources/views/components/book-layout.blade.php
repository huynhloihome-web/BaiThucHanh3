<!DOCTYPE html>
<html>
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<head>
    <style>
        .navbar {
            background-color: #ff5850;
            font-weight: bold;
        }
        .nav-item a {
            color: #fff !important;
        }
        .navbar-nav {
            margin: 0 auto;
        }
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
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card-img-top {
            padding: 10px;
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
    <header style='text-align:center'>
        <img src="{{asset('images/banner_sach.jpg')}}" width="1000px">
    </header>

    <main style="width:1000px; margin:2px auto;">
        <div class='row'>
            <div class='col-3 pr-0'>
                <x-menu>
                    <x-slot name='item'>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{url('sach')}}">Trang chủ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('sach/theloai/1')}}">Tiểu thuyết</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('sach/theloai/2')}}">Truyện ngắn - tản văn</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('sach/theloai/3')}}">Tác phẩm kinh điển</a>
                        </li>
                    </x-slot>
                </x-menu>

                <img src="{{asset('images/sidebar_1.jpg')}}" width="100%" class='mt-1'>
                <img src="{{asset('images/sidebar_2.jpg')}}" width="100%" class='mt-1'>
            </div>

            <div class='col-9'>
                @yield('content')
            </div>
        </div>
    </main>
</body>
</html>