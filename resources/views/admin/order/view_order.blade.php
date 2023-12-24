@extends('layouts.master')
@section('title','Chi tiết đơn hàng')
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
                        Chi tiết đơn hàng
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title') </h2>
                    <div class="col-lg-2 float-right">
                    <?php 
                        foreach($order_by_id as $value){
                            $order_id = $value->order_id;
                        }
                    ?>
                        <a target="_blank" href="{{url('/print-pdf/'.$order_id)}}" class="btn btn-success" style="display: block;">In PDF</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="text-center" style="margin-top: 20px;">
                        <?php
                    use Illuminate\Support\Facades\Session;
                    $message = Session::get('message');
                    if($message){
                        echo('<span class="text-alert">'.$message.'</span>');
                        Session::put('message',NULL);
                    }
                ?>
                    </div>
                    <h3 class="text-center text-uppercase">Thông tin khách hàng</h3>
                    <div class="table-responsive-md">
                        <table class="table mt-5 table-striped table-bordered table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Tên</th>
                                    <th>Địa chỉ Email</th>
                                    <th>Số điện thoại</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                foreach($order_by_id as $value_cus){
                                    $cus_name = $value_cus->customer_name;
                                    $cus_email = $value_cus->customer_email;
                                    $cus_phone = $value_cus->customer_phone;
                                }
                            ?>
                                
                                <tr>
                                    <td>{{$cus_name}}</td>
                                    <td>{{$cus_email}}</td>
                                    <td>{{$cus_phone}}</td>
                                </tr>
                              
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <hr>
                    <h3 class="text-center text-uppercase">Thông tin vận chuyển</h3>
                    <div class="table-responsive-md">
                        <table class="table mt-5 table-striped table-bordered table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Tên</th>
                                    <th>Địa chỉ Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ giao hàng</th>
                                    <th>Ghi chú</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                foreach($order_by_id as $value_shipping){
                                    $s_name = $value_shipping->shipping_name;
                                    $s_email = $value_shipping->shipping_email;
                                    $s_phone = $value_shipping->shipping_phone;
                                    $s_address = $value_shipping->shipping_address;
                                    $s_note = $value_shipping->shipping_note;
                                }
                            ?>
                                <tr>
                                    <td>{{$s_name}}</td>
                                    <td>{{$s_email}}</td>
                                    <td>{{$s_phone}}</td>
                                    <td>{{$s_address}}</td>
                                    <td>{{$s_note}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <hr>
                    <h3 class="text-center text-uppercase">Thông tin đơn hàng</h3>
                    <div class="table-responsive-md">
                        <table class="table mt-5 table-striped table-bordered table-hover">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>Tên sản phẩm</th>
                                  
                                    <th>Số lượng</th>
                                    <th>Giá bán</th>
                                    <th>Tổng tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($order_by_id as $value_product)
                                <tr>
                                    <td>{{$value_product->product_name}}</td>
                                    <td>{{$value_product->product_qty}}</td>
                                    <td>{{number_format($value_product->product_price)}}</td>
                                    <td>{{number_format($value_product->product_qty*$value_product->product_price)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-center">
                         
                            <a href="{{URL::to('/all-order')}}" class="btn btn-outline-primary">Quay lại</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection