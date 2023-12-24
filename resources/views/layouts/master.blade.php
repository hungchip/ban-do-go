<!doctype html>
<html lang="en">

<head>
    <title>Admin</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <link rel="shortcut icon" href="{{url('/frontend')}}/images/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="stylesheet" href="{{url('/backend')}}/css/admin-home.css">
    <link rel="stylesheet" href="{{url('/backend')}}/css/morris.css">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{url('/backend')}}/css/tagsinput.css">
    <!-- <link rel="stylesheet" href="{{asset('public/backend/css/formValidation.min.css')}}"> -->
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- ======= -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('public/backend/js/formValidation.min.js')}}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js "></script>
    <script src="{{asset('public/backend/js/simple.money.format.js')}}"></script>
    <script src="{{asset('public/backend/js/tagsinput.js')}}"></script>

</head>

<body>
    <!-- ====BIỂU ĐỒ DOANH THU==== -->
    <script>
    $(document).ready(function() {
        chart30DaysOrder();
        // ---
        var chart = new Morris.Bar({
            element: 'myfirstchart',
            lineColors: ['#819C79','#fc8710','#FF6541','#A4ADD3','#766B56'],
            parseTime: false,
            hideHover: 'auto',
            xkey: 'period',
            ykeys: ['order','sales','profit','quantity'],
            labels: ['Đơn hàng','Doanh số','Lợi nhuận','Số lượng']
        });

        // ---HIỂN THỊ 30 NGÀY
        function chart30DaysOrder(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('/days-order')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    _token: _token,
                },
                success: function(data) {
                    chart.setData(data);
                }
            });
        }

        // ----LỌC NGÀY---
        $('.dashboard-filter').change(function(){
            var dashboard_value = $(this).val();
            var _token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{url('/dashboard-filter')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    dashboard_value: dashboard_value,
                    _token: _token,
                },
                success: function(data) {
                    chart.setData(data);
                }
            });
        });

        // --KIỂM TRA TỪ NGÀY ĐẾN NGÀY---
        $('#check_revenue').click(function() {
            var _token = $('input[name="_token"]').val();
            var from_date = $('#dateStart').val();
            var to_date = $('#dateEnd').val();
            $.ajax({
                url: "{{url('/filter-by-date')}}",
                method: "POST",
                dataType: "JSON",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    _token: _token,
                },
                success: function(data) {
                    chart.setData(data);
                }
            });
        });
    });
    </script>

    <!-- ===DUYỆT COMMENT=== -->
    <script>
    $(document).ready(function() {
        $('.comment_duyet_btn').click(function() {
            var comment_status = $(this).data('comment_status');
            var comment_id = $(this).data('comment_id');
            var comment_product_id = $(this).attr('id');
            if (comment_status == 1) {
                var alert = 'Duyệt thành công';
            } else {
                var alert = 'Bỏ duyệt thành công';
            }
            $.ajax({
                url: "{{url('/allow-comment')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    comment_status: comment_status,
                    comment_id: comment_id,
                    comment_product_id: comment_product_id
                },
                success: function(data) {
                    location.reload();
                    $('#notify_comment').html('<span class="text-danger">' + alert +
                        '</span>');
                }
            });
        });
        $('.btn-reply-comment').click(function() {
            var comment_id = $(this).data('comment_id');
            var comment = $('.reply_comment_' + comment_id).val();
            var comment_product_id = $(this).data('product_id');

            $.ajax({
                url: "{{url('/reply-comment')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    comment: comment,
                    comment_id: comment_id,
                    comment_product_id: comment_product_id
                },
                success: function(data) {
                    $('.reply_comment_' + comment_id).val('');
                    $('#notify_comment').html(
                        '<span class="text-danger">Trả lời thành công</span>');
                }
            });
        });
    });
    </script>

    <!-- ===THƯ VIỆN ẢNH SẢN PHẨM=== -->
    <script>
    $(document).ready(function() {
        load_gallery();

        function load_gallery() {
            var pro_id = $('.pro_id').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('/select-gallery')}}",
                method: "POST",
                data: {
                    pro_id: pro_id,
                    _token: _token
                },
                success: function(data) {
                    $('#gallery_load').html(data);
                }
            });
        }
        $('#file').change(function() {
            var error = '';
            var files = $('#file')[0].files;
            if (files.length > 4) {
                error += '<p>Nhập tối đa 4 ảnh</p>';
            } else if (files.size > 2000000) {
                error += '<p>Ảnh có kích thước quá lớn</p>';
            } else if (files.length == '') {
                error += '<p>Vui lòng chọn ảnh</p>';
            }
            if (error == '') {

            } else {
                $('#file').val('');
                $('#error_gallery').html('<span class="text-danger">' + error + '</span>');
                return false;
            }
        });
        $(document).on('blur', '.edit_gallery_name', function() {
            var gal_id = $(this).data('gal-id');
            var gal_text = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: "{{url('/update-gallery-name')}}",
                method: "POST",
                data: {
                    gal_id: gal_id,
                    gal_text: gal_text,
                    _token: _token
                },
                success: function(data) {
                    load_gallery();
                    $('#error_gallery').html(
                        '<span class="text-danger">Cập nhật tên thành công!</span>');
                }
            });
        });
        $(document).on('click', '.delete-gallery', function() {
            var gal_id = $(this).data('gal-id');
            var _token = $('input[name="_token"]').val();
            if (confirm('Bạn có muốn xóa hình ảnh này không?')) {
                $.ajax({
                    url: "{{url('/delete-gallery')}}",
                    method: "POST",
                    data: {
                        gal_id: gal_id,
                        _token: _token
                    },
                    success: function(data) {
                        load_gallery();
                        $('#error_gallery').html(
                            '<span class="text-danger">Xóa hình ảnh thành công!</span>');
                    }
                });
            }
        });

        $(document).on('change', '.file_image', function() {
            var gal_id = $(this).data('gal-id');
            var image = document.getElementById('file-' + gal_id).files[0];

            var form_data = new FormData();
            form_data.append("file", document.getElementById('file-' + gal_id).files[0]);
            form_data.append("gal_id", gal_id);

            $.ajax({
                url: "{{url('/update-gallery')}}",
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    load_gallery();
                    $('#error_gallery').html(
                        '<span class="text-danger">Cập nhật hình ảnh thành công!</span>'
                    );
                }
            });

        });
    });
    </script>

    <script>
    $(document).ready(function() {
        $('input.timepicker').timepicker({});
        $('.datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $('.price').simpleMoneyFormat();
    });
    </script>

    <header>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-lg-1">
                    <div class="logo">
                        <a href="{{URL::to('/dashboard')}}">
                            <img src="{{url('/frontend')}}/images/logo.png" alt="" style="width: 100%;">
                        </a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-10">
                    <nav class="navbar navbar-expand-xl navbar-light">
                        <button class="navbar-toggler d-xl-none" type="button" data-toggle="collapse"
                            data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="collapsibleNavId">
                            <ul class="navbar-nav">
                                <li class="nav-item active">
                                    <a href="{{URL::to('/dashboard')}}">
                                        <i class="fas fa-home"></i> Tổng quan
                                    </a>

                                </li>
                                @hasrole('admin')
                                <li class="nav-item">
                                    <a href="{{URL::to('/all-user')}}">
                                        <i class="fas fa-user-shield"></i>Admin
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{URL::to('/show-customer')}}">
                                        <i class="fas fa-users"></i> Khách hàng
                                    </a>
                                </li>
                                @endhasrole

                                @impersonate
                                <li class="nav-item">
                                    <a href="{{URL::to('/impersonate-destroy')}}">
                                        <i class="far fa-stop-circle"></i> Dừng chuyển user

                                    </a>
                                </li>
                                @endimpersonate

                                @hasAnyRoles(['admin','author'])
                                <li class="nav-item">
                                    <a href="">
                                        <i class="fas fa-paperclip"></i> Danh mục
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{URL::to('/all-cate-product')}}"> Danh mục sản phẩm</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::to('/all-wood-type')}}">Danh mục gỗ</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="{{URL::to('/all-product')}}">
                                        <i class="fas fa-chair"></i> Sản phẩm
                                    </a>
                                </li>
                                @endhasAnyRoles

                                @hasrole('admin')
                                <li class="nav-item">
                                    <a href="">
                                        <i class="fas fa-chart-bar"></i> Thống kê
                                    </a>
                                    <ul class="sub-menu">
                                        <li>
                                            <a href="{{URL::to('/statistical')}}">Thống kê chung</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::to('/view-filter-order')}}">Đơn hàng</a>
                                        </li>
                                        <li>
                                            <a href="{{URL::to('/hang-co-san')}}">Sản phẩm có sẵn trong kho</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="nav-item">
                                    <a href="{{URL::to('/all-contact')}}">
                                        <i class="fas fa-comments"></i> Phản hồi
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{URL::to('/all-order')}}">
                                        <i class="fas fa-shipping-fast"></i> Đơn hàng
                                    </a>
                                </li>
                                @endhasrole

                                @hasAnyRoles(['admin','author'])
                                <li class="nav-item">
                                    <a href="{{URL::to('/all-comment')}}">
                                        <i class="fas fa-comment    "></i> Bình luận
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{URL::to('/all-banner')}}">
                                        <i class="far fa-image"></i> Banner (Ảnh bìa)
                                    </a>
                                </li>
                                @endhasAnyRoles

                            </ul>
                        </div>
                    </nav>
                </div>

                <div class="col-md-5 col-lg-1">
                    <!-- <div class="dropdown"> -->
                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" v-pre>
                                <?php

                                    use Illuminate\Support\Facades\Auth;
                                    use Illuminate\Support\Facades\Session;
                                    if(Session::get('login_normal')){
                                        $name = Session::get('admin_name');
                                    }else{
                                        $name = Auth::user()->admin_name;
                                    }

                                    if($name){
                                        echo($name);
                                    }else{
                                        return view('admin.auth.login')->with('message','Phiên đăng nhập đã hết hạn, vui lòng đăng nhập lại!');
                                    }
                                ?>
                            </a>
                            <!-- nav-link dropdown-toggle -->
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{URL::to('/doi-mat-khau')}}">
                                    {{ __('Đổi mật khẩu') }}
                                </a>
                                <a class="dropdown-item" href="{{URL::to('/logout-auth')}}">
                                    {{ __('Đăng xuất') }}
                                </a>
                            </div>
                        </li>
                    </ul>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </header>
    <!-- ========= -->
    <section id="content" style="padding-top: 40px;">
        @yield('content')
    </section>
    <!-- ========== -->
    <section id="coppy-right " style="padding-top: 20px; ">
        <div class="container " style="text-align: center; ">
            <span>© Copyright <a href="https://facebook.com/ducluong1209" target="_blank">DucLuong</a></span>
        </div>
    </section>

    @yield('js')
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</body>

</html>
