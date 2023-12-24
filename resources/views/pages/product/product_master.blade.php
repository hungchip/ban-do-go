@section('title')
Sản phẩm
@stop
@extends('pages.master')
@section('content')
<nav class="breadcrumb" style="background: none; line-height: 35px;">
    <div class="container-fluid">
        @yield('breadcrumb')
        <div class="filter" style="float: right;">
            <!-- <p style="display: inline; margin-right: 20px;">Tìm thấy 10 sản phẩm</p> -->
            <form action="" style="float: right;">
            @csrf
                    <select name="sort" id="sort" class="form-control">
                        <option value="{{Request::url()}}?sort_by=none">Thứ tự mặc định</option>
                        <option {{Request::get('sort_by') == "spmn" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=spmn">Sản phẩm mới</option>

                        <option {{Request::get('sort_by') == "tang_dan" ? "selected='selected'" : "" }}  
                            value="{{Request::url()}}?sort_by=tang_dan">Giá tăng dần</option>

                        <option {{Request::get('sort_by') == "giam_dan" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=giam_dan">Giá giảm dần</option>

                        <option {{Request::get('sort_by') == "kytu_az" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=kytu_az">Tên từ A đến Z</option>

                        <option {{Request::get('sort_by') == "kytu_za" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=kytu_za">Tên từ Z đến A</option>
                    </select>
            </form>
        </div>
    </div>
</nav>

@if(Session::has('success'))
<div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
    <strong>Thành công!</strong>{{Session::get('success')}}
</div>
@endif


@if(Session::has('danger'))
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
    <strong>Không thành công!</strong>{{Session::get('danger')}}
</div>
@endif

<section id="product">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 filter-respon">
                <!-- <p style="display: inline; margin-right: 20px;line-height: 2.5;">Tìm thấy 10 sản phẩm</p> -->
                <!-- FORM MOBILE -->
                <form action="">
                    @csrf
                    <select name="sort" id="sort" class="form-control">
                        <option value="{{Request::url()}}?sort_by=none">Thứ tự mặc định</option>
                        <option {{Request::get('sort_by') == "spmn" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=spmn">Sản phẩm mới</option>

                        <option {{Request::get('sort_by') == "tang_dan" ? "selected='selected'" : "" }}  
                            value="{{Request::url()}}?sort_by=tang_dan">Giá tăng dần</option>

                        <option {{Request::get('sort_by') == "giam_dan" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=giam_dan">Giá giảm dần</option>

                        <option {{Request::get('sort_by') == "kytu_az" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=kytu_az">Tên từ A đến Z</option>

                        <option {{Request::get('sort_by') == "kytu_za" ? "selected='selected'" : "" }} 
                            value="{{Request::url()}}?sort_by=kytu_za">Tên từ Z đến A</option>
                    </select>
                </form>
            </div>

            <div class="col-md-3 sidebar-left">
            <form action="{{URL::to('/tim-kiem')}}" class="search-home" method="post">
                    {{csrf_field()}}
                    <input type="text" name="keywords_submit" placeholder="Tìm kiếm..." class="form-control">
                    <button class="btn"><i class="fas fa-search    "></i></button>
                </form>

                <span class="widget-title shop-sidebar">Danh mục sản phẩm</span>
                <div class="is-divider small"></div>
                <ul style="margin-bottom: 25px;">
                    @foreach($all_cate_product as $key => $value)
                    @if($value->cate_parent==0)
                    <li class="parent-cates">
                        <a href="" class="a-filter" data-toggle="collapse"
                            data-target="#{{$value->cate_slug}}">{{$value->cate_name}} <i
                                class="fas fa-angle-down"></i></a>
                        <ul class="children collapse" id="{{$value->cate_slug}}">
                            @foreach($all_cate_product as $key => $cate_sub)
                                @if($cate_sub->cate_parent == $value->cate_id)
                                    <li><a href="{{URL::to('/danh-muc-san-pham/'.Str::slug($cate_sub->cate_name))}}">{{$cate_sub->cate_name}}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                    @endif
                    @endforeach
                </ul>
                
                <span class="widget-title shop-sidebar">Loại gỗ</span>
                <div class="is-divider small"></div>
                <ul style="margin-bottom: 25px;">
                    @foreach($wood as $key => $value)
                    <li class="parent-cates">
                        <a href="{{URL::to('/loai-san-pham/'.Str::slug($value->wood_name))}}" class="a-filter">{{$value->wood_name}}</a>
                    </li>
                    @endforeach
                </ul>

                <span class="widget-title shop-sidebar">Lọc theo giá</span>
                <div class="is-divider small"></div>
                <form action="">
                    <!-- <input type="radio" id="1" name="filter-price"> <label for="1">Dưới 10 triệu</label> <br>
                    <input type="radio" id="2" name="filter-price"> <label for="2">Từ 10 đến 20 triệu</label> <br>
                    <input type="radio" id="3" name="filter-price"> <label for="3">Từ 20 đến 30 triệu</label> <br> -->
                    <input type="text" id="amount" number_format readonly style="border:0; color:#f6931f; font-weight:bold;">
                    <div id="slider-range"></div>
                    <input style="margin-top: 20px;width: 100%;" type="submit" name="filter_price" value="Lọc giá" class="btn btn-secondary">
                    <input type="hidden" name="start_price" id="start_price">
                    <input type="hidden" name="end_price" id="end_price">
                </form>
              
                <!-- ---VỪA XEM--- -->
                <span class="widget-title shop-sidebar" style="display: block;margin-top: 25px;">Sản phẩm vừa xem</span>
                <div class="is-divider small"></div>

                <div id="product_viewed">
                
                </div>
            </div>
            <!-- ---------------- -->
           @yield('content_product')
        </div>
    </div>
</section>
@stop

