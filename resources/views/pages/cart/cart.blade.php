@section('title')
    Giỏ hàng
@stop

@extends('pages.master')
@section('content')
    <nav class="breadcrumb">
        <div class="container-fluid">
            <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
            <span class="breadcrumb-item active">Giỏ hàng</span>
        </div>
    </nav>
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            <strong>Thành công!</strong>{{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('danger'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"></a>
            <strong>Không thành công!</strong>{{ Session::get('danger') }}
        </div>
    @endif
    <section id="guarantee">
        <div class="container-fluid">
            <div class="row">
                <div class="table-responsive">
                    <form action="{{ URL::to('/update-cart') }}" method="post">
                        {{ csrf_field() }}
                        <table class="table">
                            <thead>
                                <tr style="text-transform: uppercase;">
                                    <th colspan="3">Sản phẩm</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng cộng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $key => $value)
                                    <tr>
                                        <td class="pro-remove">
                                            <a href="{{ URL::to('/delete-cart/' . $value->rowId) }}" class="remove">x</a>
                                        </td>
                                        <td class="pro-thumbnail">
                                            <a href="{{ URL::to('chi-tiet-san-pham/' . $value->id) }}">
                                                <img src="{{ URL::to('/upload/product/' . $value->options->image) }}"
                                                    alt="">
                                            </a>
                                        </td>
                                        <td class="pro-name">
                                            <a
                                                href="{{ URL::to('chi-tiet-san-pham/' . $value->id) }}">{{ $value->name }}</a>
                                        </td>
                                        <td class="pro-price" data-title="Giá">
                                            <span class="amount">{{ number_format($value->price) }}&nbsp;₫</span>
                                        </td>
                                        <td class="pro-quantity">
                                            <div class="product-quantity">
                                                <input type="text" name="qty_update[{{ $value->rowId }}]"
                                                    value="{{ $value->qty }}">
                                            </div>
                                        </td>
                                        <td class="pro-subtotal" data-title="Tổng cộng">
                                            <span class="amount">{{ number_format($value->subtotal) }}&nbsp;₫</span>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="6" class="actions clear">
                                        <div class="continue-shopping pull-left text-left">
                                            <a class="button is-outline" href="{{ url('/san-pham') }}">← Tiếp tục xem sản
                                                phẩm</a>
                                        </div>

                                        <button type="submit" class="button mt-0 update" value="Cập nhật giỏ hàng"
                                            disabled="">Cập nhật giỏ hàng</button>
                                        <br>
                                        <br>

                                        <span style="font-style: italic;">**Vui lòng cập nhật giỏ hàng trước khi thanh
                                            toán</span>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <h3 class="h3-total">Tổng hóa đơn</h3>
                    <table style="width: 100%;">
                        <tbody>
                            <tr class="order-total">
                                <th>Tổng tiền</th>
                                <td>
                                    <strong><span
                                            class="amount">{{ number_format(Cart::subtotalFloat()) }}&nbsp;₫</span></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="button button-pay">
                        <?php

                use Illuminate\Support\Facades\Session;

                $customer_id = Session::get('customer_id');
                    if($customer_id!=NULL){
                    ?>
                        <a href="{{ URL::to('/thanh-toan') }}" style="color: #fff;">Tiến hành thanh toán </a>
                        <?php
                    }else{
                ?>
                        <a href="{{ URL::to('/dang-nhap') }}" style="color: #fff;">Tiến hành thanh toán</a>
                        <?php }?>
                    </div>

                </div>
            </div>
        </div>
    </section>
@stop
