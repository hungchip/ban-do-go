@section('title')
    Giới thiệu
@stop

@extends('pages.master')
@section('content')
    <nav class="breadcrumb">
        <div class="container-fluid">

            <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
            <span class="breadcrumb-item active">Giới thiệu</span>
        </div>
    </nav>

    <section id="intro">
        <div class="container-fluid">
            <div class="text-center">
                <h3>Đồ Gỗ Đức Lương</h3>
            </div>
            <div class="banner">
                <img src="{{ 'frontend/images/11.jpg' }}" alt="" style="height: 310px;">
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="icon">

                        <img src="{{ 'frontend/images/agenda.png' }}" alt="">
                    </div>
                    <div class="info">
                        <h4>Đồ Gỗ Đức Lương</h4>
                        <p>Liên Hà - Đông Anh - Hà Nội</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="icon">

                        <img src="{{ 'frontend/images/smartphone.png' }}" alt="">
                    </div>
                    <div class="info">
                        <h4>Điện thoại</h4>
                        <a href="tel:0335562246" class="phone">033 556 2246</a>
                        <a href="tel:0961222863" class="phone"> / 096 1222 863</a>
                        <p>Zalo: Đồ Gỗ Đức Lương / Đồ Gỗ Mỹ Nghệ Hoa Lâm</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="icon">

                        <img src="{{ 'frontend/images/mail.png' }}" alt="">
                    </div>
                    <div class="info">
                        <h4>Email</h4>
                        <p>dogoducluong68@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
