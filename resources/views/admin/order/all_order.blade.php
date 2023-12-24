@extends('layouts.master')
@section('title','Danh sách đơn hàng')
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
                        Danh sách đơn hàng
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <!-- {{URL::to('/filter-order')}} -->
                   
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="order-table">
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
                            
                        </table>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#order-table').DataTable({
        // dom: 'lifrtp',
        processing: true,
        serverSide: true,
        ajax: "{{asset('orders')}}",
        columns: [{
                data: 'order_id',
                name: 'order_id'
            },
           
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'order_total',
                name: 'order_total'
            },
            {
                data: 'order_status',
                name: 'order_status',
            },
            {
                data: 'order_reason',
                name: 'order_reason',
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'detail',
                name: 'detail'
            }
        ]
    });
});
</script>
@endsection