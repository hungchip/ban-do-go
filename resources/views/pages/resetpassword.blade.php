@section('title')
Tìm mật khẩu
@stop

@extends('pages.master')
@section('content')
<section id="reset" style="padding: 60px 0;">
        <div class="container-fluid">
            <p>Quên mật khẩu? Vui lòng nhập tên đăng nhập hoặc địa chỉ email. Bạn sẽ nhận được một liên kết tạo mật khẩu mới qua email.</p>
            @if(Session::has('success'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                <strong>Thành công! </strong>{{Session::get('success')}}
            </div>
            @endif

            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                <strong>Lỗi! </strong>{{Session::get('error')}}
            </div>
            @endif

            <form  action="{{url('/recover-pass')}}" method="post">
            @csrf
                <label for="name" style="font-weight: bold;">Tên đăng nhập hoặc email</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" name="email_account" class="form-control">
                    </div>
                </div>
                <button type="submit" class="button" style="color: #fff;background-color: #2d2d2d; margin-top: 30px;">Đặt lại mật khẩu</button>
            </form>
        </div>
</section>
@stop