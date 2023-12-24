@section('title')
Đặt lại mật khẩu
@stop

@extends('pages.master')
@section('content')
<section id="reset" style="padding: 60px 0;">
        <div class="container-fluid">
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

            @php
                $token = $_GET['token'];
                $email = $_GET['email'];
            @endphp
            <form  action="{{url('/reset-new-pass')}}" method="post">
            @csrf
                <h2>Đặt lại mật khẩu</h2>
                <label for="name" style="font-weight: bold;">Nhập mật khẩu mới</label>
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" name="email" value="{{$email}}">
                        <input type="hidden" name="token" value="{{$token}}">
                        <input type="password" name="pass_account" class="form-control">
                    </div>
                </div>
                <button type="submit" class="button" style="color: #fff;background-color: #2d2d2d; margin-top: 30px;">Đặt lại mật khẩu</button>
            </form>
        </div>
</section>
@stop