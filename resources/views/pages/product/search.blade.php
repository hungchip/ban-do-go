@extends('pages.product.product_master')
@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
    <span class="breadcrumb-item active">Sản phẩm</span>
@stop
<section id="product">
    <div class="container-fluid">
        <div class="row">
            @section('content_product')
                <div class="col-md-9 content">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="text-center" style="color: #d09f11;font-weight: bold; margin-bottom: 15px;">KẾT QUẢ
                                TÌM KIẾM</h3>
                        </div>
                        <!-- ------- -->
                        @foreach ($search_product as $key => $value)
                            <div class="col-md-4">
                                <div class="image-item">
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . $value->product_id) }}">
                                        <img class="img-product" src="upload/product/{{ $value->product_image }}"
                                            alt="">
                                    </a>

                                    <div class="image-tools">
                                        <a href="#" class="add-cart" data-toggle="tooltip" data-placement="top"
                                            title="Thêm vào giỏ">
                                            <div class="cart-icon">
                                                <strong>+</strong>
                                            </div>

                                        </a>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <p>{{ $value->cate_name }}</p>
                                    <a href="" class="name-product">
                                        {{ $value->product_name }}
                                    </a>
                                    <p class="price">
                                        {{ number_format($value->product_price) }} ₫
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <!-- ------- -->

                    </div>
                </div>
            @stop
        </div>
    </div>
</section>
