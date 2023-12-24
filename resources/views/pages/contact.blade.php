@section('title')
    Liên hệ
@stop

@extends('pages.master')
@section('content')
    <nav class="breadcrumb">
        <div class="container-fluid">

            <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
            <span class="breadcrumb-item active">Liên hệ</span>
        </div>
    </nav>

    <section id="contact">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ 'frontend/images/contact.jpg' }}" alt="">
                </div>

                <div class="col-md-6">
                    <h3>Đồ Gỗ Đức Lương</h3>
                    <div class="list">
                        <p>
                            <i class="fas fa-map-marker-alt"></i>Liên Hà - Đông Anh - Hà Nội
                        </p>
                        <p>
                            <i class="fas fa-mobile-alt"></i><a href="tel:0335562246" class="phone">033 556 2246</a>
                            <a href="tel:0961222863" class="phone"> / 096 1222 863</a>
                        </p>
                        <p>
                            <i class="far fa-envelope"></i><a href="">dogoducluong68@gmail.com</a>
                        </p>
                        <p>
                            <i class="fab fa-facebook-f"></i><a href="https://www.facebook.com/dogomynghehoalam">Đồ Gỗ Mỹ
                                Nghệ Hoa Lâm</a>
                        </p>
                    </div>
                    <h3>Liên hệ với chúng tôi</h3>
                    <form action="{{ URL::to('/mail-contact') }}" method="post">
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-md-6">
                                <input required="" name="contact_name" type="text" class="form-control"
                                    placeholder="Họ và tên">
                            </div>
                            <div class="col-md-6">
                                <input required="" name="contact_email" type="email" class="form-control"
                                    placeholder="Email">
                            </div>
                            <br> <br>
                            <div class="col-md-6">
                                <input required="" name="contact_phone" type="text" class="form-control"
                                    placeholder="Số điện thoại">
                            </div>
                            <div class="col-md-6">
                                <input required="" name="contact_topic" type="text" class="form-control"
                                    placeholder="Chủ đề">
                            </div>
                            <br> <br>
                            <div class="col-md-12">
                                <textarea required="" name="contact_content" id="" rows="5" class="form-control"
                                    placeholder="Lời nhắn"></textarea>
                            </div>
                        </div>
                        <br>
                        <div class="text-center">
                            <button type="submit">Gửi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@stop
