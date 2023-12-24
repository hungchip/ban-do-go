@extends('layouts.master')

@section('title', 'Thêm user')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <a href="">
                            <i class="fas fa-home"> Trang chủ</i>
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                       Admin
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2>@yield('title')</h2>
                </div>
              
                <div class="card-body">
                    <h6 class="text-center mb-4" style="color: black; font-weight: bold;">Thông tin chung</h6>
                    <form action="{{URL::to('/save-user')}}" method="POST" role="form"
                        enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Tên 
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" placeholder="Tên " class="form-control" required=""
                                        name="admin_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Email
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                <input type="email" placeholder="Email" class="form-control" required=""
                                        name="admin_email">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Mật khẩu
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                <input type="password" placeholder="Mật khẩu" class="form-control" required=""
                                        name="admin_password">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Số điện thoại
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                <input type="text" placeholder="Số điện thoại" class="form-control" required=""
                                        name="admin_phone">
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: unset;">Thêm mới</button>
                            <a href="{{URL::to('/all-user')}}" class="btn btn-outline-primary">Quay lại</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection()