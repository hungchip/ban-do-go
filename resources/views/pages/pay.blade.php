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
                            <form action="" method="post">

                                <label for="">Họ và tên:</label>
                                <input required="" type="text" class="form-control" name="fullname"
                                    placeholder="Họ tên">

                                <label for="">Email (Nếu có):</label>
                                <input type="email" class="form-control" name="email" placeholder="Email">

                                <label for="">Số điện thoại:</label>
                                <input required="" type="text" class="form-control" name="phone_number"
                                    placeholder="Số điện thoại">

                                <label for="">Địa chỉ:</label>
                                <input required="" type="text" class="form-control" name="address"
                                    placeholder="Địa chỉ">

                                <label for="">Ghi chú:</label>
                                <textarea name="note" class="form-control" placeholder="Ghi chú" cols="30" rows="4" style="resize: none;"></textarea>
                                <div class="text-center" style="margin-top: 10px;">

                                    <button class="btn btn-success">Đặt hàng</button>
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
                                                    <a href="{{ URL::to('chi-tiet-san-pham/' . $value->id) }}">
                                                        <img src="{{ URL::to('\/upload/' . $value->options->image) }}"
                                                            alt="">
                                                    </a>
                                                </td>

                                                <td class="pro-title">
                                                    <a
                                                        href="{{ URL::to('chi-tiet-san-pham/' . $value->id) }}">{{ $value->name }}</a>
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
                                    style="color: #D03E37;">6,582,000&nbsp;₫</span></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
