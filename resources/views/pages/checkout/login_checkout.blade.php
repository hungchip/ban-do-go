@section('title')
    Đăng nhập
@stop

@extends('pages.master')
@section('content')
    <section id="reset" style="padding: 60px 0;">
        <div class="container-fluid">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                    <strong>Thành công! </strong>{{ Session::get('success') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
                    <strong>Lỗi! </strong>{{ Session::get('error') }}
                </div>
            @endif
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Đăng nhập</h3>
                        <?php
                        
                        use Illuminate\Support\Facades\Session;
                        
                        $message = Session::get('message');
                        
                        if ($message) {
                            echo '<span class="text-alert">' . $message . '</span>';
                            Session::put('message', null);
                        }
                        ?>
                        <form action="{{ URL::to('/login-customer') }}" method="post">
                            {{ csrf_field() }}
                            <label for="">Tên tài khoản hoặc địa chỉ email *</label>
                            <input required="" name="email_account" type="text" class="form-control">
                            <label for="">Mật khẩu *</label>
                            <input required="" name="password_account" type="password" class="form-control">

                            <button type="submit" class="button">Đăng nhập</button>

                            <a href="{{ URL::to('/tim-mat-khau') }}" class="forget">Quên mật khẩu?</a>
                        </form>

                        <ul>
                            <div class="row">
                                <div class="col-md-2">
                                    <li>
                                        <a href="{{ url('login-customer-google') }}" title="Đăng nhập bằng Google"><img
                                                src="frontend/images/google.png" alt="Đăng nhập bằng google"></a>
                                    </li>
                                </div>
                                <div class="col-md-2">
                                    <li>
                                        <a href="{{ url('login-customer-facebook') }}" title="Đăng nhập bằng Facebook"> <img
                                                src="frontend/images/facebook.png" alt="Đăng nhập bằng facebook"></a>
                                    </li>
                                </div>
                            </div>
                        </ul>
                    </div>

                    <div class="col-md-6" style="border-left: 1px solid #ececec;">
                        <h3>Đăng kí</h3>
                        <form action="{{ URL::to('/add-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <label for="">Địa chỉ email *</label>
                            <input name="customer_email" required="" type="email" class="form-control">
                            <div>
                                @error('customer_email')
                                    <small><strong style="color: red;">{{ $message }}</strong></small>
                                @enderror
                            </div>
                            <label for="">Mật khẩu *</label>
                            <input name="customer_password" required="" type="password" class="form-control">
                            @error('customer_password')
                                <small><strong style="color: red;">{{ $message }}</strong></small>
                            @enderror
                            <label for="">Họ và tên *</label>
                            <input name="customer_name" required="" type="text" class="form-control">

                            <label for="">Số điện thoại *</label>
                            <input name="customer_phone" required="" type="text" class="form-control">

                            <div class="clearfix"></div>
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
                            <br />
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="invalid-feedback"
                                    style="display:block; width: 100%; color: red;margin-bottom: 15px;">
                                    <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                </span>
                            @endif
                            <button class="button">Đăng ký</button>
                        </form>
                    </div>
                </div>
            </div>
    </section>
@stop
