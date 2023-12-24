@extends('layouts.master')

@section('title', 'Sửa trạng thái đơn hàng')
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
                        Đơn hàng
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
                   <?php 
                    foreach($order_by_id as $key => $edit_value){

                    }
                   ?>
                    <form action="{{URL::to('/update-status/'.$edit_value->order_id)}}" method="POST" role="form"
                        enctype="multipart/form-data">
                        {{csrf_field()}}

                        <div class="col-lg-12 form-group">
                            <div class="row">
                                <label for="" class="col-sm-3 control-label">Trạng thái đơn hàng
                                    <span class="required">*</span>:
                                </label>

                                <div class="col-sm-9">
                                    <select name="order_status" class="form-control">
                                        <option selected value="{{$edit_value->order_status}}">
                                            {{$edit_value->order_status}}</option>
                                            @if($edit_value->order_status == "Đơn hàng mới")
                                                <option value="Xác nhận">Xác nhận</option>
                                                <option value="Đang giao hàng">Đang giao hàng</option>
                                                <option value="Thành công">Thành công</option>
                                                <option value="Đơn hàng hủy">Đơn hàng hủy</option>
                                            @elseif($edit_value->order_status == "Xác nhận")
                                                <option value="Đang giao hàng">Đang giao hàng</option>
                                                <option value="Thành công">Thành công</option>
                                                <option value="Đơn hàng hủy">Đơn hàng hủy</option>
                                            @elseif($edit_value->order_status == "Đã thanh toán online")
                                                <option value="Đang giao hàng">Đang giao hàng</option>
                                                <option value="Thành công">Thành công</option>
                                                <option value="Đơn hàng hủy">Đơn hàng hủy</option>
                                            @elseif($edit_value->order_status == "Đang giao hàng")
                                                <option value="Thành công">Thành công</option>
                                                <option value="Đơn hàng hủy">Đơn hàng hủy</option>  
                                            @elseif($edit_value->order_status == "Thành công")
                                                <option value="Đơn hàng hủy">Đơn hàng hủy</option>            
                                            @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                 

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" style="width: unset;">Lưu</button>
                            <a href="{{URL::to('/all-order')}}" class="btn btn-outline-primary">Quay lại</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection()