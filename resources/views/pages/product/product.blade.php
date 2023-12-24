@extends('pages.product.product_master')
@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
    <span class="breadcrumb-item active">Sản phẩm</span>
@stop

@section('content_product')
    <div class="col-md-9 content">
        <div class="row">
            <!-- ------- -->
            @foreach ($product as $key => $value)
                <div class="col-md-4">
                    <div class="image-item">
                        <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->product_name)) }}">
                            <img class="img-product" src="upload/product/{{ $value->product_image }}" alt="">
                        </a>

                        <form action="{{ URL::to('/save-cart') }}" method="post">
                            {{ csrf_field() }}
                            <div class="image-tools">
                                <button style="background: none;border: none;outline: none;" type="submit" class="add-cart"
                                    data-toggle="tooltip" data-placement="top" title="Thêm vào giỏ">
                                    <div class="cart-icon">
                                        <strong>+</strong>
                                    </div>
                                </button>

                            </div>
                            <input name="qty" type="hidden" value="1">
                            <input name="productid_hidden" type="hidden" value="{{ $value->product_id }}">
                        </form>
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
