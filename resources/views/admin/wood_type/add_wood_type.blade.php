@extends('layouts.master')

@section('title', 'Thêm loại gỗ')
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
                       Loại gỗ
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
                    <form action="{{URL::to('/save-wood-type')}}" method="POST" role="form"
                        enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Tên loại gỗ
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" id="name" placeholder="Tên loại gỗ" class="form-control" required=""
                                        name="wood_name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Slug
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" id="slug" readonly="true" class="form-control" name="wood_slug">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Mô tả loại gỗ
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <textarea rows="8" required="" placeholder="Mô tả" class="form-control"
                                        name="wood_desc"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Hiển thị
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <select name="wood_status" class="form-control">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiện</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: unset;">Thêm mới</button>
                            <a href="{{URL::to('/all-wood-type')}}" class="btn btn-outline-primary">Quay lại</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection()
@section('js')
<script>
$('input#name').keyup(function() {

var title, slug;

//Lấy text từ thẻ input title 
// title = document.getElementById("title").value;
title = $(this).val();
//Đổi chữ hoa thành chữ thường
slug = title.toLowerCase();

 //Đổi chữ hoa thành chữ thường
 slug = title.toLowerCase();
 
 //Đổi ký tự có dấu thành không dấu
 slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
 slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
 slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
 slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
 slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
 slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
 slug = slug.replace(/đ/gi, 'd');
 //Xóa các ký tự đặt biệt
 slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
 //Đổi khoảng trắng thành ký tự gạch ngang
 slug = slug.replace(/ /gi, "-");
 //Đổi nhiều ký tự gạch ngang liên tiếp thành 1 ký tự gạch ngang
 //Phòng trường hợp người nhập vào quá nhiều ký tự trắng
 slug = slug.replace(/\-\-\-\-\-/gi, '-');
 slug = slug.replace(/\-\-\-\-/gi, '-');
 slug = slug.replace(/\-\-\-/gi, '-');
 slug = slug.replace(/\-\-/gi, '-');
 //Xóa các ký tự gạch ngang ở đầu và cuối
 slug = '@' + slug + '@';
 slug = slug.replace(/\@\-|\-\@|\@/gi, '');
$('input#slug').val(slug);
});
</script>
@stop