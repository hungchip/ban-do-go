@extends('layouts.master')

@section('title', 'Sửa sản phẩm')
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
                    @foreach($edit_product as $key =>$edit_value)
                    <form action="{{URL::to('/update-product/'.$edit_value->product_id)}}" method="POST" role="form"
                        enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Tên sản phẩm
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$edit_value->product_name}}" id="name" class="form-control"
                                        required="" name="product_name">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Slug
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$edit_value->product_slug}}" id="slug" readonly="true" class="form-control" name="product_slug">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Số lượng sản phẩm
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$edit_value->product_qty}}" class="form-control"
                                         name="product_qty">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Giá bán
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$edit_value->product_price}}" class="form-control price"
                                        required="" name="product_price">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Giá nhập
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$edit_value->product_cost}}" class="form-control price"
                                        required="" name="product_cost">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Hình ảnh
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="file" value="{{$edit_value->product_image}}"
                                        name="product_image">
                                    <img src="{{URL::to('public/upload/product/'.$edit_value->product_image)}}" width="100"
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
                                    <textarea rows="8" required="" class="form-control"
                                       id="ckeditor" name="product_content">{{$edit_value->product_content}}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Mô tả sản phẩm
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <textarea rows="8" required="" class="form-control"
                                    id="ckeditor1"   name="product_desc">{{$edit_value->product_desc}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Tags sản phẩm
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <input type="text" value="{{$edit_value->product_tags}}"  data-role="tagsinput" name="product_tags" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Danh mục sản phẩm
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                <select name="product_cate" class="form-control">
                                        @foreach($cate_product as $value)
                                        @if($value->cate_parent == 0)
                                        <option value="{{$value->cate_id}}">{{$value->cate_name}}</option>

                                        @foreach($cate_product as $cate_sub)
                                        @if($cate_sub->cate_parent!=0 && $cate_sub->cate_parent==$value->cate_id)
                                        <option value="{{$cate_sub->cate_id}}">---{{$cate_sub->cate_name}}---</option>
                                        @endif
                                        @endforeach
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Loại gỗ
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <select name="product_wood" class="form-control">
                                        @foreach($wood_type as $value)
                                        @if($value->wood_id==$edit_value->wood_type_id)
                                        <option selected value="{{$value->wood_id}}">{{$value->wood_name}}</option>
                                        @else
                                        <option value="{{$value->wood_id}}">{{$value->wood_name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Hiển thị
                                    <span class="required">*</span>:
                                </label>
                                <div class="col-sm-9">
                                    <select name="product_status" class="form-control">
                                        <option value="0">Ẩn</option>
                                        <option value="1">Hiện</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: unset;">Lưu</button>
                            <a href="{{URL::to('/all-product')}}" class="btn btn-outline-primary">Quay lại</a>
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
CKEDITOR.replace('ckeditor',{
    filebrowserImageUploadUrl : "{{url('uploads-ckeditor?_token='.csrf_token())}}",
    filebrowserBrowseUrl :"{{url('file-browser?_token='.csrf_token())}}",
    filebrowserUploadMethod : "form"
});
CKEDITOR.replace('ckeditor1',{
    filebrowserImageUploadUrl : "{{url('uploads-ckeditor?_token='.csrf_token())}}",
    filebrowserBrowseUrl :"{{url('file-browser?_token='.csrf_token())}}",
    filebrowserUploadMethod : "form"
});

$('input#name').keyup(function() {

var title, slug;

//Lấy text từ thẻ input title 
// title = document.getElementById("title").value;
title = $(this).val();
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
//In slug ra textbox có id “slug”
$('input#slug').val(slug);
});
</script>
@stop