@section('title')
    Thông tin cá nhân
@stop

@extends('pages.master')
@section('content')
    <nav class="breadcrumb">
        <div class="container-fluid">

            <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
            <span class="breadcrumb-item active">Thông tin cá nhân</span>
        </div>
    </nav>
    <?php
    use Illuminate\Support\Facades\Session;
    $message = Session::get('message');
    if ($message) {
        echo '<span class="text-alert">' . $message . '</span>';
        Session::put('message', null);
    }
    ?>
    <section id="info_customer">
        <div class="container-fluid">
            <form autocomplete="off" action="{{ URL::to('/update-info') }}" method="POST" role="form"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                @foreach ($data_cus as $key => $value_cus)
                    <div class="row">
                        <div class="col-md-3">

                            @if (strpos($value_cus->customer_avatar, 'https://') !== false)
                                <img class="avatar" src="{{ $value_cus->customer_avatar }}" alt="">
                            @else
                                <img class="avatar" src="upload/avatar-user/{{ $value_cus->customer_avatar }}"
                                    alt="">
                            @endif
                            <label for="avatar" class="text-center" style="cursor: pointer; display: block;">Thay đổi ảnh
                                đại diện</label>
                            <input type="file" name="customer_avatar" id="avatar" style="display: none;">
                        </div>

                        <div class="col-md-9">
                            <div class="card-body">
                                <h3 class="text-center mb-4" style="color: black; font-weight: bold;">Thông tin chung</h3>

                                <div class="col-lg-12 form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-3 control-label text-right">Họ và tên
                                            <span class="required">*</span>:
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="customer_name" class="form-control"
                                                value="{{ $value_cus->customer_name }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-3 control-label text-right">Email
                                            <span class="required">*</span>:
                                        </label>
                                        <div class="col-sm-9">
                                            <p name="customer_email">{{ $value_cus->customer_email }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-3 control-label text-right">Số điện thoại
                                            <span class="required">*</span>:
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="text" name="customer_phone" class="form-control"
                                                value="{{ $value_cus->customer_phone }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary" style="width: unset;">Cập nhật</button>
                                    <a href="{{ URL::to('/trang-chu') }}" class="btn btn-outline-primary">Quay lại</a>
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach
            </form>

        </div>

    </section>

    <script>
        function readURL(input, img) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        };

        function browserURL(path, path2) {
            $(path).change(function() {
                readURL(this, path2);
            });
        };

        browserURL("#avatar", ".avatar");
    </script>
@stop
