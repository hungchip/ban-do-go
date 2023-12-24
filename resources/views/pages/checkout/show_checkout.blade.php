@section('title')
    Thanh toán
@stop
@extends('pages.master')
@section('content')
    <nav class="breadcrumb">
        <div class="container-fluid">

            <a class="breadcrumb-item" href="{{ URL::to('/trang-chu') }}">Trang chủ</a>
            <span class="breadcrumb-item active">Thanh toán</span>
        </div>
    </nav>

    <section id="intro">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card ">
                        <div class="card-header">
                            <h3 class="card-title">Thông tin thanh toán</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ URL::to('/save-checkout') }}" method="post">
                                {{ csrf_field() }}
                                <label for="">Họ và tên:</label>
                                <input required="" type="text" class="form-control" name="shipping_name"
                                    placeholder="Họ tên">

                                <label for="">Email:</label>
                                <input required="" type="email" class="form-control" name="shipping_email"
                                    placeholder="Email">

                                <label for="">Số điện thoại:</label>
                                <input required="" type="text" class="form-control" name="shipping_phone"
                                    placeholder="Số điện thoại">

                                <label for="">Địa chỉ:</label>
                                <input required="" type="text" class="form-control" name="shipping_address"
                                    placeholder="Địa chỉ">

                                <label for="">Ghi chú:</label>
                                <textarea name="shipping_note" class="form-control" placeholder="Ghi chú" cols="30" rows="4"
                                    style="resize: none;"></textarea>
                                <div class="text-center" style="margin-top: 10px;">
                                    @if (Cart::total() != 0)
                                        <button class="btn btn-success">Thanh toán khi nhận hàng</button> &nbsp;&nbsp;&nbsp;
                                        <button name="payment" value="2" class="btn btn-info">Thanh toán
                                            online</button>
                                    @endif
                                    @if (Cart::total() == 0)
                                        <a style="color: #d09f11;font-weight: bold;" href="{{ URL::to('/san-pham') }}">Bạn
                                            chưa có sản phẩm nào trong giỏ hàng! Quay lại mua hàng!</a>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách sản phẩm</h3>

                        </div>
                        <div class="card-body">
                            <div class="cart-table table-responsive mb-40">
                                @foreach (Cart::content() as $value)
                                    <table class="">
                                        <tbody>
                                            <tr>
                                                <td class="pro-thumbnail">
                                                    <a href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->name)) }}">
                                                        <img src="{{ URL::to('/upload/product/' . $value->options->image) }}"
                                                            alt="">
                                                    </a>
                                                </td>

                                                <td class="pro-title">
                                                    <a
                                                        href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($value->name)) }}">{{ $value->name }}</a>
                                                    Số lượng: {{ $value->qty }}
                                                </td>
                                                <td class="pro-subtotal"><span
                                                        class="amount">{{ number_format($value->subtotal) }}&nbsp;₫</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>
                        </div>

                        <div class="card-footer">
                            Tổng tiền: <strong style="float: right;"><span class="amount"
                                    style="color: #D03E37;">{{ number_format(Cart::subtotalFloat()) }}&nbsp;₫</span></strong>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@stop
