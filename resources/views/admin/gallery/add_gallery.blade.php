@extends('layouts.master')

@section('title', 'Thêm thư viện ảnh')
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
                        Thư viện ảnh
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2>@yield('title')</h2>
                </div>

                <form action="{{url('/insert-gallery/'.$pro_id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3" align="right"></div>
                        <div class="col-md-6">
                            <input type="file" id="file" name="file[]" accept="image/*" multiple>
                            <span id="error_gallery"></span>
                        </div>
                        <div class="col-md-3">
                            <input style="width:unset;" type="submit" value="Tải ảnh" name="upload"
                                class="btn btn-success">
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <input type="hidden" name="pro_id" value="{{$pro_id}}" class="pro_id">
                                <div id="gallery_load" style="width: 100%;">
                                        
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection()