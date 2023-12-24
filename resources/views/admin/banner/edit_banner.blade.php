@extends('layouts.master')

@section('title', 'Sửa banner')
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
                            Banner
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
                        @foreach ($edit_banner as $key => $edit_value)
                            <form action="{{ URL::to('/update-banner/' . $edit_value->banner_id) }}" method="POST"
                                role="form" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="col-lg-12 form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-3 control-label">Hình ảnh
                                            <span class="required">*</span>:
                                        </label>
                                        <div class="col-sm-9">
                                            <input type="file" value="{{ $edit_value->banner_image }}"
                                                name="banner_image">
                                            <img src="{{ URL::to('upload/banner/' . $edit_value->banner_image) }}"
                                                width="100" alt="">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <div class="row">
                                        <label for="" class="col-sm-3 control-label">Hiển thị
                                            <span class="required">*</span>:
                                        </label>
                                        <div class="col-sm-9">
                                            <select name="banner_status" class="form-control">
                                                <option value="0">Ẩn</option>
                                                <option value="1">Hiện</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                        @endforeach
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: unset;">Lưu</button>
                            <a href="{{ URL::to('/all-banner') }}" class="btn btn-outline-primary">Quay lại</a>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection()
