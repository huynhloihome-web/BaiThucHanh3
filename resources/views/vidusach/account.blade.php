@extends('components.book-layout')

@section('content')
<div class="container-fluid mt-3">
    <div class="row">
        {{-- 1. SIDEBAR BÊN TRÁI --}}
        <div class="col-md-3 pr-md-0">
            <div class="list-group shadow-sm">
                <a href="{{ url('/') }}" class="list-group-item list-group-item-action">
                    Trang chủ
                </a>
                <a href="{{ route('account') }}" class="list-group-item list-group-item-action active" style="background-color: #34495e; border-color: #34495e;">
                    Thông tin tài khoản
                </a>
                {{-- Giả định bạn có route quản lý sách --}}
                <a href="#" class="list-group-item list-group-item-action">
                    Quản lý sách 
                </a>
            </div>
        </div>

        {{-- 2. NỘI DUNG CẬP NHẬT BÊN PHẢI --}}
        <div class="col-md-9">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 text-primary text-center font-weight-bold">
                        CẬP NHẬT THÔNG TIN CÁ NHÂN 
                    </h5>
                </div>
                
                <div class="card-body">
                    {{-- Hiển thị thông báo thành công [cite: 305, 319] --}}
                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    {{-- Hiển thị lỗi validation [cite: 292, 299] --}}
                    @if($errors->any())
                        <div class="alert alert-danger shadow-sm">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    {{-- Form cập nhật [cite: 224, 336] --}}
                    <form method="POST" action="{{ route('saveinfo') }}" enctype="multipart/form-data">
                        @csrf {{-- [cite: 237, 342] --}}
                        <input type="hidden" name="id" value="{{ $user->id }}"> {{-- [cite: 236, 340] --}}
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-line text-sm-right">Tên </label>
                            <div class="col-sm-8">
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-line text-sm-right">Email </label>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-line text-sm-right">Số điện thoại </label>
                            <div class="col-sm-8">
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Nhập số điện thoại">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-line text-sm-right">Ảnh đại diện </label>
                            <div class="col-sm-8">
                                @if($user->photo)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/profile/'.$user->photo) }}" 
                                             class="img-thumbnail" 
                                             [cite_start]style="width: 100px; height: 100px; object-fit: cover;"> {{--  --}}
                                    </div>
                                @endif
                                <input type="file" name="photo" id="photo" accept="image/*" class="form-control-file"> {{-- [cite: 342] --}}
                                <small class="text-muted italic">Chấp nhận: jpeg, png, jpg, gif (Max: 2MB)</small>
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-sm-8 offset-sm-3 text-center">
                                <button type="submit" class="btn btn-primary px-4">
                                    Lưu cập nhật
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection