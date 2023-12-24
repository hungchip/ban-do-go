@section('title')
    Thay đổi mật khẩu
@stop

@extends('layouts.master')
@section('content')
    <nav class="breadcrumb">
        <div class="container-fluid">

            <a class="breadcrumb-item" href="{{URL::to('/dashboard')}}">Trang chủ</a>
            <span class="breadcrumb-item active">Thay đổi mật khẩu</span>
        </div>
    </nav>

    <section id="info_customer">
        <div class="container-fluid">
            <form action="{{URL::to('/update-admin-password')}}" role="form" enctype="multipart/form-data">
                {{csrf_field()}}

                <div class="row">
                    <div class="card-body">
                        <h3 class="text-center mb-4" style="color: black; font-weight: bold;">Thông tin chung</h3>
                        <?php

                            use Illuminate\Support\Facades\Session;

                            $message = Session::get('message');

                            if($message){
                                echo('<span class="text-alert" style="display: block;
                                padding-bottom: 15px;">'.$message.'</span>');
                                Session::put('message',NULL);
                            }
                            ?>
                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label text-right">Mật khẩu hiện tại
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password"  class="form-control" name="old_pass">
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label text-right">Mật khẩu mới
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9"> 
                                        <input type="password"  class="form-control" name="new_pass">
                                        @error('new_pass')
                                            <small><strong style="color: red;">{{$message}}</strong></small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 form-group">
                                <div class="row">
                                    <label for="" class="col-sm-3 control-label text-right">Xác nhận mật khẩu mới
                                        <span class="required">*</span>:
                                    </label>
                                    <div class="col-sm-9">
                                        <input type="password"  class="form-control" name="apply_pass">
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" style="width: unset;">Cập nhật</button>
                                <a href="{{URL::to('/dashboard')}}" class="btn btn-outline-primary">Quay lại</a>
                            </div>
                    </div>
                </div>
            </form>

        </div>

    </section>
@stop
