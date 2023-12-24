<!doctype html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="{{ url('/frontend') }}/images/logo.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/frontend') }}/owlcarousel/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/owlcarousel/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/master.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/home.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/cart.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/contact.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/intro.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/pay.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/product.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/product-detail.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/lightbox.min.css">
    <link rel="stylesheet" href="{{ url('/frontend') }}/css/quick-alo.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ url('/frontend') }}/js/lightbox-plus-jquery.min.js"></script>
    <script src="{{ url('/frontend') }}/owlcarousel/owl.carousel.min.js"></script>
    <script src="{{ url('/frontend') }}/js/amount.js"></script>
    <script src="{{ url('/frontend') }}/js/master.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
</head>

<body>
    <!-- Load Facebook SDK for JavaScript -->
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v10.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your Chat Plugin code -->
    <div class="zalo-chat-widget" data-oaid="678553295609368423" data-welcome-message="Rất vui khi được hỗ trợ bạn!"
        data-autopopup="0" data-width="350" data-height="420"></div>

    <script src="https://sp.zalo.me/plugins/sdk.js"></script>
    <!-- HEADER -->
    <style>
        #fb-root iframe {
            bottom: 80px !important;
        }
    </style>
    <div id="fb-root"></div>
    <div class="fb-customerchat" attribution="setup_tool" page_id="831036317274604"></div>
    <header>
        <div class="container-fluid">
            <div class="row header-top" style="align-items: center; height: 100px;background-color: #f5f5f5;">
                <div class="col-md-4 search menu-respon">
                    <form action="{{ URL::to('/tim-kiem') }}" autocomplete="off" class="search-home" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="keywords_submit" id="keywords" class="form-control search"
                            placeholder="Tìm kiếm...">
                        <div id="search_ajax"></div>
                        <button type="submit"> <i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>

                <div class="col-md-4" id="logo">
                    <div class="text-center">
                        <a href="{{ URL::to('/trang-chu') }}">
                            <img src="{{ url('/frontend') }}/images/logo.png" alt="" class="logo">
                        </a>
                    </div>
                </div>

                <div class="col-md-4 cart-loggin">
                    <ul class="list-log">
                        <?php
                            use Illuminate\Support\Facades\Session;
                            $customer_id = Session::get('customer_id');
                            $customer_name = Session::get('customer_name');
                            if($customer_id!=NULL){
                        ?>
                        <li>

                            <a style="cursor: pointer;" id="dropdownMenuButton" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <span>{{ $customer_name }} <i class="fas fa-angle-down    "></i></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="{{ URL::to('/thong-tin-ca-nhan') }}">Thông
                                    tin cá nhân</a>
                                <a class="dropdown-item" href="{{ URL::to('/lich-su-mua-hang') }}">Lịch sử
                                    mua hàng</a>
                                <a class="dropdown-item" href="{{ URL::to('/thay-doi-mat-khau') }}">Đổi mật
                                    khẩu</a>
                                <a class="dropdown-item" href="{{ URL::to('/logout-checkout') }}">Đăng xuất</a>

                            </div>
                        </li>
                        <?php
                        }else{
                        ?>
                        <li>
                            <a href="" data-toggle="modal" data-target="#form-login" class="loggin">
                                <span>Đăng nhập</span>
                            </a>
                        </li>
                        <?php }?>
                        <li class="has-dropdown">
                            <a href="{{ URL::to('/gio-hang') }}">
                                <span class="cart">Giỏ hàng</span>

                                <span class="cart-icon">
                                    <strong>{{ Cart::count() }}</strong>
                                </span>
                            </a>
                            <ul class="nav-dropdown nav-dropdown-simple">
                                <li class="shopping_cart">
                                    <div class="shopping_cart_content">
                                        @foreach (Cart::content() as $value)
                                            <ul class="cart_list ">
                                                <li class="mini_cart_item">
                                                    <a href="{{ URL::to('/delete-cart/' . $value->rowId) }}"
                                                        class=" remove_from_cart_button"
                                                        aria-label="Xóa sản phẩm này">×</a>
                                                    <a href="{{ URL::to('chi-tiet-san-pham/' . $value->id) }}">
                                                        <img src="{{ URL::to('/upload/product/' . $value->options->image) }}"
                                                            class="product-image">
                                                        {{ $value->name }}
                                                    </a>

                                                    <span class="quantity">{{ $value->qty }} × <span
                                                            class="amount">{{ number_format($value->price) }}&nbsp;₫</span>
                                                    </span>
                                                </li>
                                            </ul>
                                        @endforeach
                                        <p class=" total">
                                            <strong>Tổng cộng:</strong>
                                            <span class="amount">
                                                {{ number_format(Cart::subtotalFloat()) }}&nbsp;₫
                                            </span>
                                        </p>
                                        <p class="buttons">
                                            <a href="{{ URL::to('/gio-hang') }}" class="button checkout">Xem giỏ
                                                hàng</a>
                                            <?php
                                                $customer_id = Session::get('customer_id');
                                                if($customer_id!=NULL){
                                            ?>
                                            <a href="{{ URL::to('/thanh-toan') }}" class="button getpay">Thanh
                                                toán</a>
                                            <?php
                                            }else{
                                            ?>
                                            <a href="{{ URL::to('/dang-nhap') }}" class="button getpay">Thanh
                                                toán</a>
                                            <?php }?>

                                        </p>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- =======FORM ĐN-ĐK========= -->
                <div class="modal fade" id="form-login" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="text-right" style="padding-right: 20px;">
                                <button type="button" style="outline: none;" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                    <span aria-hidden="true" style="font-size: 46px;">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Đăng nhập</h3>
                                        <form action="{{ URL::to('/login-customer') }}" method="post">
                                            {{ csrf_field() }}
                                            <label for="">Tên tài khoản hoặc địa chỉ email *</label>
                                            <input required="" name="email_account" type="text"
                                                class="form-control">
                                            <label for="">Mật khẩu *</label>
                                            <input required="" name="password_account" type="password"
                                                class="form-control">

                                            <button type="submit" class="button">Đăng nhập</button>
                                            <!-- <input type="checkbox" id="remember">
                                            <label for="remember" class="remember">Ghi nhớ mật khẩu</label> -->

                                            <a href="{{ URL::to('/tim-mat-khau') }}" class="forget">Quên mật
                                                khẩu?</a>
                                        </form>
                                        <ul>
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <li>
                                                        <a href="{{ url('login-customer-google') }}"
                                                            title="Đăng nhập bằng Google"><img
                                                                src="frontend/images/google.png"
                                                                alt="Đăng nhập bằng google"></a>
                                                    </li>
                                                </div>
                                                <div class="col-md-2">
                                                    <li>
                                                        <a href="{{ url('login-customer-facebook') }}"
                                                            title="Đăng nhập bằng Facebook"> <img
                                                                src="frontend/images/facebook.png"
                                                                alt="Đăng nhập bằng facebook"></a>
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
                                            <input name="customer_email" required="" type="email"
                                                class="form-control">
                                            <div>
                                                @error('customer_email')
                                                    <small><strong
                                                            style="color: red;">{{ $message }}</strong></small>
                                                @enderror
                                            </div>
                                            <label for="">Mật khẩu *</label>
                                            <input name="customer_password" required="" type="password"
                                                class="form-control">
                                            @error('customer_password')
                                                <small><strong style="color: red;">{{ $message }}</strong></small>
                                            @enderror
                                            <label for="">Họ và tên *</label>
                                            <input name="customer_name" required="" type="text"
                                                class="form-control">

                                            <label for="">Số điện thoại *</label>
                                            <input name="customer_phone" required="" type="text"
                                                class="form-control">

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
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="background-color: #f5f5f5;">
                <div class="respon">
                    <nav class="navbar navbar-expand-sm navbar-light ">
                        <a class="navbar-brand" href="#">
                            <img src="{{ url('/frontend') }}/images/logo.png" class="logo">
                        </a>
                        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse"
                            data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="collapsibleNavId">
                            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                                <li class="nav-item">
                                    <form action="" class="res">
                                        <input type="text" class="form-control search" placeholder="Tìm kiếm...">
                                        <button type="submit"> <i class="fa fa-search"
                                                aria-hidden="true"></i></button>
                                    </form>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('/gioi-thieu') }}">Giới thiệu</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('/san-pham') }}">Sản phẩm</a>
                                    <ul class="sub-menu">
                                        @foreach ($all_cate_product as $key => $value_cate)
                                            <li class="sub-menu-item">
                                                <a href="{{ URL::to('/danh-muc-san-pham/' . $value_cate->cate_id) }}"
                                                    class="sub-menu-link">{{ $value_cate->cate_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('/bao-hanh') }}">Bảo hành</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ URL::to('/lien-he') }}">Liên hệ</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">Đăng nhập</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">
                                        Giỏ hàng
                                        <span class="cart-icon">
                                            <strong>1</strong>
                                        </span></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- NAV -->
            <div class="row main-menu">
                <ul class="menu">
                    <li class="menu-item">
                        <a class="menu-link" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ URL::to('/gioi-thieu') }}">Giới thiệu</a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ URL::to('/san-pham') }}">Sản phẩm</a>
                        <ul class=" nav-dropdown nav-dropdown-simple">
                            @foreach ($all_cate_product as $key => $value_cate)
                                @if ($value_cate->cate_parent == 0)
                                    <li class="sub-menu-item">
                                        <a href="{{ URL::to('/danh-muc-san-pham/' . Str::slug($value_cate->cate_name)) }}"
                                            class="sub-menu-link">{{ $value_cate->cate_name }}</a>
                                        <ul class="sub-menu-2">
                                            @foreach ($all_cate_product as $key => $cate_sub)
                                                @if ($cate_sub->cate_parent == $value_cate->cate_id)
                                                    <li><a
                                                            href="{{ URL::to('/danh-muc-san-pham/' . Str::slug($cate_sub->cate_name)) }}">{{ $cate_sub->cate_name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ URL::to('/bao-hanh') }}">Bảo hành</a>
                    </li>
                    <li class="menu-item">
                        <a class="menu-link" href="{{ URL::to('/lien-he') }}">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    @yield('content')

    <!-- ======FOOTER======= -->
    <footer>
        <div class="sec-footer">
            <div class="section-bg-overlay"></div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img src="{{ url('/frontend') }}/images/logo.png" width="70%" class="logo" alt="">
                    <ul class="list-contact">
                        <li>
                            <i class="fas fa-home"></i>
                            <span class="address">Liên Hà - Đông Anh - Hà Nội</span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <a href="tel:0335562246" class="phone">033 556 2246</a>
                            <a href="tel:0961222863" class="phone"> / 096 1222 863</a>
                        </li>
                        <li>
                            <i class="fas fa-mail-bulk"></i>
                            <a href="" class="mail">dogoducluong68@gmail.com</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <div class="direc">
                        <h3>Điều hướng</h3>
                        <ul class="list-direc">
                            <li>
                                <a href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/gioi-thieu') }}">Giới thiệu</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/san-pham') }}">Sản phẩm</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/bao-hanh') }}">Bảo hành</a>
                            </li>
                            <li>
                                <a href="{{ URL::to('/lien-he') }}">Liên hệ</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- ---- -->
                <div id="fb-root"></div>
                <script async defer crossorigin="anonymous"
                    src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v11.0&appId=742875069588229&autoLogAppEvents=1"
                    nonce="V02noz12"></script>
                <!-- ---- -->
                <div class="col-md-4">
                    <div class="contact-us">
                        <h3>Liên hệ với chúng tôi</h3>
                        <span><a href="https://www.facebook.com/dogomynghehoalam" data-toggle="tooltip"
                                title="Folow on Facebook"><i class="fab fa-facebook-f"></i></a></span>
                        <span><a href="" data-toggle="tooltip" title="Folow on Instagram"><i
                                    class="fab fa-instagram"></i></a></span>
                        <span><a href="" data-toggle="tooltip" title="Folow on Google"><i
                                    class="fab fa-google-plus-g"></i></a></span>
                        <span><a href="" data-toggle="tooltip" title="Folow on Youtube"><i
                                    class="fab fa-youtube"></i></a></span>
                        <!-- <h3>Đã chứng nhận</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ url('/frontend') }}/images/dathongbao-1024x388.png" width="100%"
                                    alt="">
                            </div>
                            <div class="col-md-6">
                                <img src="{{ url('/frontend') }}/images/dadangky-1024x384.png" width="100%" alt="">
                            </div>
                        </div> -->
                        <div class="fb-page" data-href="https://www.facebook.com/dogomynghehoalam" data-tabs=""
                            data-width="" data-height="" data-small-header="false"
                            data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/dogomynghehoalam"
                                class="fb-xfbml-parse-ignore">
                                <a href="https://www.facebook.com/dogomynghehoalam">Đồ Gỗ Mỹ Nghệ Hoa Lâm</a>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <section id="copyright">
        <p class="text-center">© All rights reserved. Thiết kế website</p>
    </section>

    <a href="" class="btn-top">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </a>

    <!-- --QUICK ALO-- -->
    <div class="quick-alo-phone quick-alo-green quick-alo-show" id="quick-alo-phoneIcon">
        <a href="tel:0335562246" title="Liên hệ nhanh">
            <div class="quick-alo-ph-circle"></div>
            <div class="quick-alo-ph-circle-fill"></div>
            <div class="quick-alo-ph-img-circle"></div>
        </a>
    </div>
    <!-- ---- -->
    @yield('js')

    <script>
        $(document).ready(function() {
            load_comment();

            function load_comment() {
                var product_id = $('.comment_product_id').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/load-comment') }}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        _token: _token
                    },
                    success: function(data) {
                        $('#comment_show').html(data);
                    }
                });
            }
            $('.send-comment').click(function() {
                var product_id = $('.comment_product_id').val();
                var comment_name = $('.comment_name').val();
                var comment_content = $('.comment_content').val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/send-comment') }}",
                    method: "POST",
                    data: {
                        product_id: product_id,
                        comment_name: comment_name,
                        comment_content: comment_content,
                        _token: _token
                    },
                    success: function(data) {
                        $('#notify_comment').html(
                            '<p class="text text-success">Thêm bình luận thành công, bình luận đang chờ duyệt</p>'
                        );
                        load_comment();
                        $('#notify_comment').fadeOut(10000);
                        $('.comment_name').val('');
                        $('.comment_content').val('');
                    }
                });
            });
        });
    </script>
    <script>
        $('#keywords').keyup(function() {
            var query = $(this).val();
            if (query != '') {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: "{{ url('/autocomplete-ajax') }}",
                    method: "POST",
                    data: {
                        query: query,
                        _token: _token
                    },
                    success: function(data) {
                        $('#search_ajax').fadeIn();
                        $('#search_ajax').html(data);
                    }
                });
            } else {
                $('#search_ajax').fadeOut();
            }
        });
        $(document).on('click', '.li_search_ajax', function() {
            $('#keywords').val($(this).text());
            $('#search_ajax').fadeOut();
        });
    </script>

    <!-- //ĐÁNH GIÁ SAO -->
    <script>
        function remove_background(product_id) {
            for (var count = 1; count <= 5; count++) {
                $('#' + product_id + '-' + count).css('color', '#ddd');
            }
        }
        //hover
        $(document).on('mouseenter', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data("product_id");
            remove_background(product_id);
            for (var count = 1; count <= index; count++) {
                $('#' + product_id + '-' + count).css('color', '#ffcc00');
            }
        });
        //nhả
        $(document).on('mouseleave', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data("product_id");
            var rating = $(this).data("rating");
            remove_background(product_id);
            for (var count = 1; count <= index; count++) {
                $('#' + product_id + '-' + count).css('color', '#ddd');
            }
        });
        //click
        $(document).on('click', '.rating', function() {
            var index = $(this).data("index");
            var product_id = $(this).data("product_id");
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{ url('/insert-rating') }}",
                method: "POST",
                data: {
                    index: index,
                    product_id: product_id,
                    _token: _token
                },
                success: function(data) {
                    if (data == 'done') {
                        alert("Bạn đã đánh giá " + index + " sao trên 5 sao");
                    } else {
                        alert("Lỗi đánh giá");
                    }
                }
            });
        });
    </script>

    <!-- YÊU THÍCH SẢN PHẨM -->
    <script>
        function view() {
            if (localStorage.getItem('data') != null) {
                var data = JSON.parse(localStorage.getItem('data'));
                data.reverse();
                for (i = 0; i < 8; i++) {
                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    var id = data[i].id;
                    var action = data[i].action;

                    $('#row_wishlist').append(
                        '<div class="col-md-3"><div class="image-item"><a href="' + url +
                        '"><img class="img-product" src="' + image +
                        '" alt=""></a><form action="' + action +
                        '" method="post">{{ csrf_field() }}<div class="image-tools"><button style="background: none;border: none;outline: none;" type="submit"class="add-cart" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ"><div class="cart-icon"><strong>+</strong></div></button><input name="qty" type="hidden" value="1"><input name="productid_hidden" type="hidden" value="' +
                        id + '"></div></form><div class="info-item"><a href="" class="name-product">' +
                        name + '</a><p class="price">' + price + '₫</p></div></div>'
                    );
                }

            }
        }
        view();

        function add_wistlist(clicked_id) {
            var id = clicked_id;
            var name = document.getElementById('wistlist_productname' + id).value;
            var price = document.getElementById('wistlist_productprice' + id).value;
            var image = document.getElementById('wistlist_productimage' + id).src;
            var url = document.getElementById('wistlist_producturl' + id).href;
            var action = document.getElementById('wistlist_action' + id).action;

            var newItem = {
                'url': url,
                'id': id,
                'name': name,
                'price': price,
                'image': image,
                'action': action,
            }

            if (localStorage.getItem('data') == null) {
                localStorage.setItem('data', '[]');
            }

            var old_data = JSON.parse(localStorage.getItem('data'));

            var matches = $.grep(old_data, function(obj) {
                return obj.id == id;
            });
            if (matches.length) {
                alert('Sản phẩm bạn đã yêu thích nên không thể thêm!!');
            } else {
                old_data.push(newItem);
                $('#row_wishlist').append(
                    '<div class="col-md-3"><div class="image-item"><a href="' + newItem.url +
                    '"><img class="img-product" src="' + newItem.image +
                    '" alt=""></a><form action=""method="post">{{ csrf_field() }}<div class="image-tools"><button style="background: none;border: none;outline: none;" type="submit"class="add-cart" data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ">div class="cart-icon"><strong>+</strong></div></button><input name="qty" type="hidden" value="1"><input name="productid_hidden" type="hidden" value="' +
                    id + '"></div></form></div><div class="info-item"><a href="" class="name-product">' +
                    newItem.name + '</a><p class="price">' + newItem.price + '₫</p></div></div>'

                );
            }
            localStorage.setItem('data', JSON.stringify(old_data));
        };
    </script>

    <!-- LỌC SẢN PHÂM -->
    <script>
        $(document).ready(function() {
            $('#sort').on('change', function() {
                var url = $(this).val();
                if (url) {
                    window.location = url;
                }
                return false;
            });
        });
    </script>
    <!-- LỌC GIÁ -->
    <script>
        $(document).ready(function() {
            $("#slider-range").slider({
                orientation: "horizontal",
                range: true,
                min: 5000000,
                max: 100000000,
                steps: 100000,
                values: [5000000, 80000000],
                slide: function(event, ui) {
                    $("#amount").val(ui.values[0] + " ₫" + " -  " + ui.values[1] + " ₫");
                    $("#start_price").val(ui.values[0]);
                    $("#end_price").val(ui.values[1]);
                }
            });
            $("#amount").val($("#slider-range").slider("values", 0) + " ₫" + " - " + $("#slider-range").slider(
                "values", 1) + " ₫");
        });
    </script>

    <!-- -----VỪA XEM------ -->
    <script>
        function viewed() {
            if (localStorage.getItem('viewed') != null) {
                var data = JSON.parse(localStorage.getItem('viewed'));
                data.reverse();
                // document.getElementById('product_viewed').style.overflow = 'scroll';
                // document.getElementById('product_viewed').style.height = '500px';
                for (i = 0; i < 3; i++) {
                    var name = data[i].name;
                    var price = data[i].price;
                    var image = data[i].image;
                    var url = data[i].url;
                    var id = data[i].id;
                    // var action = data[i].action;
                    $('#product_viewed').append(
                        '<div class="row product" style="padding-bottom: 20px;"><div class="col-md-5"><a href="' + url +
                        '"><img src="' + image +
                        '" alt=""></a></div><div class="col-md-7"><a href="' + url +
                        '" class="name-pro">' + name + '</a><span class="amount">' + price + '&nbsp;₫</span></div>'
                    );
                }

            }
        }
        product_viewed();
        viewed();

        function product_viewed() {
            var product_id = $('#product_viewd_id').val();
            if (product_id != undefined) {
                var id = product_id;
                var name = document.getElementById('viewed_productname' + id).value;
                var price = document.getElementById('viewed_productprice' + id).value;
                var image = document.getElementById('viewed_productimage' + id).value;
                var url = document.getElementById('viewed_producturl' + id).value;

                var newItem = {
                    'url': url,
                    'id': id,
                    'name': name,
                    'price': price,
                    'image': image
                }

                if (localStorage.getItem('viewed') == null) {
                    localStorage.setItem('viewed', '[]');
                }

                var old_data = JSON.parse(localStorage.getItem('viewed'));

                var matches = $.grep(old_data, function(obj) {
                    return obj.id == id;
                });
                if (matches.length) {
                    // old_data.pop(matches);
                    // old_data.push(newItem);
                } else {
                    old_data.push(newItem);
                    $('#product_viewed').append(
                        '<div class="row product" style="padding-bottom: 20px;"><div class="col-md-5"><a href="' +
                        newItem.url +
                        '"><img src="' + newItem.image +
                        '" alt=""></a></div><div class="col-md-7"><a href="' + newItem.url +
                        '" class="name-pro">' + newItem.name + '</a><span class="amount">' + newItem.price +
                        '&nbsp;₫</span></div>'
                    );
                }
                localStorage.setItem('viewed', JSON.stringify(old_data));
            }

        };
    </script>

    <!-- Hủy đơn hàng -->
    <script>
        function Huydonhang(id) {
            var id = id;
            var lydo = $('.lydohuydon' + id).val();
            var order_status = "Đơn hàng hủy";
            var _token = $('input[name="_token"]').val();
            //    alert(id);
            if ($('.lydohuydon' + id).val() == "") {
                alert("Vui lòng điền lý do");
            } else {
                $.ajax({
                    url: '{{ url('/huy-don-hang') }}',
                    method: 'POST',
                    data: {
                        id: id,
                        lydo: lydo,
                        order_status: order_status,
                        _token: _token
                    },
                    success: function(data) {
                        alert("Hủy đơn hàng thành công!");
                        location.reload();
                    }
                });
            }
        }
    </script>
    <!--Xác nhận đơn hàng -->
    <script>
        function Xacnhan(id) {
            var id = id;
            var order_status = "Xác nhận";
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: '{{ url('/xac-nhan-don') }}',
                method: 'POST',
                data: {
                    id: id,
                    order_status: order_status,
                    _token: _token
                },
                success: function(data) {
                    alert("Xác nhận đơn hàng thành công!");
                    location.reload();
                }
            });

        }
    </script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
