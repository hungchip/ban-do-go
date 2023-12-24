@extends('layouts.master')

@section('title', 'Chi tiết sản phẩm')
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
                            Sản phẩm
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

                        <form action="{{ URL::to('/update-product/' . $model->product_id) }}" method="POST" role="form"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Tên sản phẩm
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{{ $model->product_name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Số lượng sản phẩm
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{{ $model->product_qty }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Giá bán
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{{ $model->product_price }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Giá nhập
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{{ $model->product_cost }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Hình ảnh
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">

                                        <img src="{{ URL::to('upload/product/' . $model->product_image) }}" width="100"
                                            alt="">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Nội dung
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{!! $model->product_content !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Mô tả sản phẩm
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{!! $model->product_desc !!}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Danh mục sản phẩm
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{{ $cate->cate_name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Loại gỗ
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <p>{{ $wood->wood_name }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label">Hiển thị
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        @if ($model->product_status == 0)
                                            <p>Ẩn</p>
                                        @else
                                            <p>Hiện</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <a href="{{ URL::previous() }}" class="btn btn-outline-primary">Quay lại</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection()
