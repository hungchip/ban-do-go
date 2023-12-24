@extends('layouts.master')
@section('title','Danh sách Đơn hàng')
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
                        Danh sách Đơn hàng
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <form action="{{URL::to('/filter-order')}}" method="get" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-3">
                                Từ ngày
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="dateStart" id="dateStart">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                Đến ngày
                                <div class="input-group">
                                    <input type="text" class="form-control datepicker" name="dateEnd" id="dateEnd">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <h6 class="text-muted" style="opacity: 0; margin-bottom: 0">Check</h6>
                                <div class="input-group">
                                    <button type="submit" id="check_order" class="btn btn-primary"
                                        style="width: 100%">Kiểm tra</button>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div class="col-lg-2 float-right">
                        <form action="{{URL::to('/excel-order')}}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">Xuất excel</button>
                        </form>
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
                    <div class="table-responsive-md">
                        <table class="table mt-5 table-striped table-bordered table-hover" id="admin-table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Tên khách hàng</th>
                                    <th>Tổng giá tiền</th>
                                    <th>Tình trạng</th>
                                    <th>Lý do hủy đơn</th>
                                    <th>Ngày đặt</th>
                                    <th>Xem chi tiết</th>
                                </tr>
                            </thead>
                            @foreach($data as $key => $value_order)
                            <tbody style="text-align: center;">
                                <td>{{$value_order->order_id}}</td>
                                <td>{{$value_order->customer_name}}</td>
                                <td>{{number_format($value_order->order_total)}}</td>
                                <td>{{$value_order->order_status}}</td>
                                <td>{{$value_order->order_reason}}</td>
                                <td>{{$value_order->created_at}}</td>
                                <td><a href="'.route('viewOrder',$data->order_id).'" style="text-align: center;
                display: block;">
                                        <i class="fas fa-eye text-warning"></i>
                                    </a></td>
                            </tbody>
                            @endforeach
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection