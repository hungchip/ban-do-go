@extends('pages.product.product_master')
@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
    <a class="breadcrumb-item" href="{{ URL::to('/san-pham') }}">Sản phẩm</a>
    @foreach ($cate_name as $key => $value)
        <span class="breadcrumb-item active">{{ $value->cate_name }}</span>
    @endforeach
@endsection

<section id="product">
    <div class="container-fluid">
        <div class="row">
            @section('content_product')
                <div class="col-md-9 content">

                    <div class="row">
                        <div class="col-md-12">
                            @foreach ($cate_name as $key => $value)
                                <h3 class="text-center"
                                    style="text-transform: uppercase; color: #d09f11;font-weight: bold; margin-bottom: 15px;">
                                    {{ $value->cate_name }}</h3>
                            @endforeach
                        </div>
                    </div>

                    <!-- ------- -->
                    <div class="row">

                        @foreach ($cate_by_id as $key => $value)
                            <div class="col-md-4">
                                <div class="image-item">
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->product_name)) }}">
                                        <img class="img-product" src="../upload/product/{{ $value->product_image }}"
                                            alt="">
                                    </a>

                                    <form action="{{ URL::to('/save-cart') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="image-tools">
                                            <button style="background: none;border: none;outline: none;" type="submit"
                                                class="add-cart" data-toggle="tooltip" data-placement="top"
                                                title="Thêm vào giỏ">
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
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->product_name)) }}"
                                        class="name-product">
                                        {{ $value->product_name }}
                                    </a>
                                    <p class="price">
                                        {{ number_format($value->product_price) }} ₫
                                    </p>
                                </div>
                            </div>
                        @endforeach
                        <!-- ------- -->
                        @foreach ($product as $key => $value1)
                            <div class="col-md-4">
                                <div class="image-item">
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value1->product_name)) }}">
                                        <img class="img-product" src="../upload/product/{{ $value1->product_image }}"
                                            alt="">
                                    </a>

                                    <form action="{{ URL::to('/save-cart') }}" method="post">
                                        {{ csrf_field() }}
                                        <div class="image-tools">
                                            <button style="background: none;border: none;outline: none;" type="submit"
                                                class="add-cart" data-toggle="tooltip" data-placement="top"
                                                title="Thêm vào giỏ">
                                                <div class="cart-icon">
                                                    <strong>+</strong>
                                                </div>
                                            </button>

                                        </div>
                                        <input name="qty" type="hidden" value="1">
                                        <input name="productid_hidden" type="hidden" value="{{ $value1->product_id }}">
                                    </form>
                                </div>

                                <div class="info-item">
                                    <p>{{ $value1->cate_name }}</p>
                                    <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value1->product_name)) }}"
                                        class="name-product">
                                        {{ $value1->product_name }}
                                    </a>
                                    <p class="price">
                                        {{ number_format($value1->product_price) }} ₫
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @stop
    </div>
    </div>
</section>
