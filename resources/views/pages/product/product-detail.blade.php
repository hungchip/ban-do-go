@extends('pages.product.product_master')
@section('breadcrumb')
    <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
    <a class="breadcrumb-item" href="{{ URL::to('/san-pham') }}">Sản phẩm</a>
    @foreach ($detail_product as $key => $value)
        <a class="breadcrumb-item"
            href="{{ URL::to('/danh-muc-san-pham/' . Str::slug($value->cate_name)) }}">{{ $value->cate_name }}</a>
        <span class="breadcrumb-item active">{{ $value->product_name }}</span>
    @endforeach
@stop

@section('content_product')
    <div class="col-md-9 content">
        @foreach ($detail_product as $key => $value)
            <input type="hidden" name="" id="product_viewd_id" value="{{ $value->product_id }}">
            <input type="hidden" name="" id="viewed_productname{{ $value->product_id }}"
                value="{{ $value->product_name }}">
            <input type="hidden" name="" id="viewed_producturl{{ $value->product_id }}"
                value="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->product_name)) }}">
            <input type="hidden" name="" id="viewed_productimage{{ $value->product_id }}"
                value="{{ asset('public/upload/product/' . $value->product_image) }}">
            <input type="hidden" name="" id="viewed_productprice{{ $value->product_id }}"
                value="{{ number_format($value->product_price) }}">

            <div class="row" style="border-bottom: 1px dotted #ddd; margin: 0;">
                <div class="col-md-6">
                    <img src="{{ '../upload/product/' . $value->product_image }}" alt="">
                    <a href="{{ '../upload/product/' . $value->product_image }}" class="click-a-img"
                        data-lightbox="pro"></a>

                    <!-- THƯ VIỆN ẢNH -->
                    <div class="row" style="    margin-top: 20px;">
                        @foreach ($gallery as $key => $value_gal)
                            <div class="col-md-3">
                                <img src="{{ url('/upload/gallery/' . $value_gal->gallery_image) }}" alt="">
                                <a href="{{ url('/upload/gallery/' . $value_gal->gallery_image) }}" class="click-a-img"
                                    data-lightbox="pro"></a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info">
                        <span class="widget-title shop-sidebar">
                            <h3>{{ $value->product_name }}</h3>
                        </span>
                        <div class="is-divider small"></div>

                        <span class="amount"
                            style="font-size: 1.5em;">{{ number_format($value->product_price) }}&nbsp;₫</span>
                        <p style="padding-top: 15px; text-align: justify;">
                            {!! $value->product_desc !!}
                        </p>
                        <form id="wistlist_action{{ $value->product_id }}" action="{{ URL::to('/save-cart') }}"
                            method="post">
                            {{ csrf_field() }}
                            <!-- ---ADD CARD--- -->
                            <div class="product-quantity">
                                <input type="text" name="qty" value="1">
                            </div>
                            <input name="productid_hidden" type="hidden" value="{{ $value->product_id }}">

                            <input type="hidden" id="wistlist_productname{{ $value->product_id }}"
                                value="{{ $value->product_name }}">
                            <input type="hidden" id="wistlist_productprice{{ $value->product_id }}"
                                value="{{ number_format($value->product_price) }}">
                            <div class="d-none">
                                <a id="wistlist_producturl{{ $value->product_id }}"
                                    href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->product_name)) }}">
                                    <img id="wistlist_productimage{{ $value->product_id }}"
                                        src="{{ '../upload/product/' . $value->product_image }}" alt="">
                                </a>
                            </div>

                            <div class="button button-pay" style="width: auto; margin-top: 0;">
                                @if ($value->product_qty == 0)
                                    <a href="tel:0335562246" style="color:#fff;">Liên hệ</a>
                                @else
                                    <button type="submit"
                                        style="outline: none;background: none;border: none;color: currentColor;text-transform: uppercase;font-weight: bold;">Thêm
                                        giỏ hàng</button>
                                @endif
                            </div>
                        </form>
                        <button class="button_wishlist" id="{{ $value->product_id }}" onclick="add_wistlist(this.id);">Sản
                            phẩm
                            yêu thích</button>
                        @if ($value->product_qty)
                            <p style="margin-top: 20px; margin-bottom: 0;"><b>Có sẵn: {{ $value->product_qty }} sản
                                    phẩm</b></p>
                        @else
                            <p style="margin-top: 20px; margin-bottom: 0;"><b>Hàng đặt(Giao trong vòng 7-15 ngày kể từ ngày
                                    đặt
                                    )</b></p>
                        @endif
                    </div>
                    <span>Danh mục: <a href="" class="cate">{{ $value->cate_name }}</a></span>
                    <fieldset>
                        <legend>Tags</legend>
                        <p><i class="fas fa-tags"></i>
                            @php
                                $tags = $value->product_tags;
                                $tags = explode(',', $tags);
                            @endphp
                            @foreach ($tags as $tag)
                                <a href="{{ url('/tag/' . Str::slug($tag)) }}" class="tags_style">{{ $tag }}</a>
                            @endforeach
                        </p>
                    </fieldset>
                    <!-- SHARE FACEBOOK -->
                    <div id="fb-root"></div>
                    <script async defer crossorigin="anonymous"
                        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0&appId=742875069588229&autoLogAppEvents=1"
                        nonce="8apGcw9i"></script>
                    <div class="fb-share-button" data-href="{{ $url }}" data-layout="button" data-size="large">
                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                            class="fb-xfbml-parse-ignore">
                            Chia sẻ</a>
                    </div>
                </div>
            </div>

            <!-- -------- -->
            <div class="row" style="padding-top: 40px;">
                <div class="col-md-12">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="mota-tab" data-toggle="tab" href="#mota" role="tab"
                                aria-controls="mota" aria-selected="true">Mô tả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="binhluan-tab" data-toggle="tab" href="#binhluan" role="tab"
                                aria-controls="binhluan" aria-selected="false">Bình luận</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="danhgia-tab" data-toggle="tab" href="#danhgia" role="tab"
                                aria-controls="danhgia" aria-selected="false">Đánh giá ({{ $comment_count }})</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="mota" role="tabpanel"
                            aria-labelledby="mota-tab">
                            <p>{!! $value->product_content !!}</p>
                        </div>

                        <div class="tab-pane fade" id="binhluan" role="tabpanel" aria-labelledby="binhluan-tab">
                            <div class="fb-comments" data-href="{{ $url }}" data-width="100%"
                                data-numposts="10">
                            </div>
                        </div>

                        <div class="tab-pane fade" id="danhgia" role="tabpanel" aria-labelledby="danhgia-tab">
                            @if ($comment_count == 0)
                                <h3>Đánh giá</h3>
                                <p>Chưa có đánh giá nào</p>
                            @endif
                            <div class="form-review">
                                @if ($comment_count == 0)
                                    <h3>Hãy là người đầu tiên nhận xét "{{ $value->product_name }}"</h3>
                                @endif
                                <form action="">
                                    @csrf
                                    <input type="hidden" class="comment_product_id" name="comment_product_id"
                                        value="{{ $value->product_id }}">
                                    <div id="comment_show"></div>
                                </form>
                                <form action="" style="padding-top: 20px;">
                                    <div id="notify_comment"></div>
                                    <p style="margin: 0; font-weight: bold;">Đánh giá của bạn</p>
                                    <div class="rate-star">
                                        <ul class="list-inline">
                                            <?php
                                            if($customer_id!=NULL){
                                            ?>
                                            @for ($count = 1; $count <= 5; $count++)
                                                <?php
                                                if ($count <= $rating) {
                                                    $color = 'color: #ffcc00;';
                                                } else {
                                                    $color = 'color: #ddd;';
                                                }
                                                ?> <li id="{{ $value->product_id }}-{{ $count }}"
                                                    data-index="{{ $count }}"
                                                    data-product_id="{{ $value->product_id }}"
                                                    data-rating="{{ $rating }}" class="rating"
                                                    style="cursor: pointer; {{ $color }} font-size: 30px; display: inline;">
                                                    &#9733
                                                </li>
                                            @endfor
                                            <?php
                                            }else{
                                            ?>
                                            <a href="{{ URL::to('/dang-nhap') }}"
                                                style="cursor: pointer;color: #ddd; font-size: 30px; display: inline;">&#9733&#9733&#9733&#9733&#9733</a>
                                            <?php }?>

                                        </ul>
                                    </div>
                                    <label for="comment">Nhận xét của bạn *</label>
                                    <textarea name="comment" id="comment" rows="8" class="form-control comment_content"></textarea>
                                    <input id="name" type="hidden" class="comment_name" name="comment_name"
                                        value="{{ $customer_name }}">
                                    <!-- <input id="name" type="hidden" name="customer_id" value="{{ $customer_id }}"> -->

                                    <?php
                                            if($customer_id!=NULL){
                                            ?>
                                    <button type="button" class="button send-comment"
                                        style="background-color: #2d2d2d;color: #fff;margin-top: 25px;">Gửi đi
                                    </button>
                                    <?php
                                            }else{
                                            ?>
                                    <a class="button" style="background-color: #2d2d2d;color: #fff;margin-top: 25px;"
                                        href="{{ URL::to('/dang-nhap') }}">Gửi đi</a>
                                    <?php }?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- ------- -->
        <div class="row" style="padding-top: 40px;">
            <div class="col-md-12">
                <h4 class="sptt">Sản phẩm tương tự</h4>
                <div class="owl-carousel owl-theme">
                    @foreach ($relative_product as $key => $value)
                        <div class="item">
                            <div class="image-item">
                                <a href="">
                                    <img class="img-product" src="{{ '../upload/product/' . $value->product_image }}"
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
                </div>
            </div>
        </div>
    </div>

@stop


@section('js')
    <script>
        $(document).ready(function() {
            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 5
                    }
                }
            });
        });
    </script>
@stop
