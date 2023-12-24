@section('title')
Lịch sử mua hàng
@stop

@extends('pages.master')
@section('content')
<nav class="breadcrumb">
    <div class="container-fluid">

        <a class="breadcrumb-item" href="{{URL::to('/trang-chu')}}">Trang chủ</a>
        <span class="breadcrumb-item active">Lịch sử mua hàng</span>
    </div>
</nav>

<section id="info_customer">
    <div class="container-fluid">
        <?php

use Illuminate\Support\Facades\Session;

$message = Session::get('message');

if($message){
    echo('<span class="text-alert">'.$message.'</span>');
    Session::put('message',NULL);
}
?>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="waitting-tab" data-toggle="tab" href="#waitting" role="tab"
                            aria-controls="waitting" aria-selected="true">Đơn hàng đang chờ
                            <b>({{$all_order_not_success->count()}})</b></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="success-tab" data-toggle="tab" href="#success" role="tab"
                            aria-controls="success" aria-selected="false">Đơn hàng đã giao
                            <b>({{$all_order_success->count()}})</b></a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="waitting" role="tabpanel" aria-labelledby="waitting-tab">
                        <table class="table ">
                            <thead>
                                <tr style="text-align: center;">
                                    <td>STT</td>
                                    <td>Ngày đặt hàng</td>
                                    <td>Tổng tiền </td>
                                    <td>Trạng thái</td>
                                    <td>Xem chi tiết</td>
                                    <td colspan="2">Hành động</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($all_order_not_success as $key => $value)
                                <tr style="text-align: center;">
                                    <?php $i++; ?>
                                    <td>#{{$i}}</td>
                                    <td>{{$value->order_date}}</td>
                                    <td>{{number_format($value->order_total)}}</td>
                                    <td>{{$value->order_status}}</td>
                                    <td>
                                        <a class="js_order_item" href="{{route('viewOrderCustomer',$value->order_id)}}"
                                            data-id="{{$value->order_id}}" style="display: block;text-align: center;">
                                            <i class="fas fa-eye text-warning"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @if($value->order_status == "Đơn hàng mới")
                                        <button class="btn btn-danger" data-toggle="modal"
                                            data-target="#huydon{{$value->order_id}}">Hủy đơn
                                            hàng</button>
                                        @endif
                                        <div id="huydon{{$value->order_id}}" class="modal fade" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <form>
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Hủy đơn hàng</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea
                                                                class="form-control lydohuydon{{$value->order_id}}"
                                                                placeholder="Lý do hủy đơn hàng (bắt buộc)"
                                                                rows="5"></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" id="{{$value->order_id}}"
                                                                class="btn btn-primary"
                                                                onclick="Huydonhang(this.id)">Gửi</button>
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Đóng</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        @if($value->order_status == "Đơn hàng mới")
                                        <form style="    display: inline-block; margin-bottom: 0">
                                            @csrf
                                            <button type="button" id="{{$value->order_id}}" class="btn btn-success"
                                                onclick="Xacnhan(this.id)">Xác nhận</button>
                                        </form>
                                        @endif
                                        @if($value->order_status == "Đơn hàng hủy")
                                        <p class="text-danger" style="font-style: italic;font-weight: bold;">Đơn hàng đã hủy</p>
                                        @endif
                                        @if($value->order_status == "Xác nhận")
                                        <p class="text-success" style="font-style: italic;font-weight: bold;">Đơn hàng đã được xác nhận</p>
                                        @endif
                                        @if($value->order_status == "Đang giao hàng")
                                        <p class="text-warning" style="font-style: italic;font-weight: bold;">Đơn hàng đang được vận chuyển</p>
                                        @endif
                                        @if($value->order_status == "Đã thanh toán online")
                                        <p class="text-info" style="font-style: italic;font-weight: bold;">Đơn hàng đã được thanh toán</p>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="success" role="tabpanel" aria-labelledby="success-tab">
                        <table class="table ">
                            <thead>
                                <tr style="text-align: center;">
                                    <td>STT</td>
                                    <td>Ngày đặt hàng</td>
                                    <td>Tổng tiền </td>
                                    <td>Trạng thái</td>
                                    <td>Xem chi tiết</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($all_order_success as $key => $value_success)
                                <tr style="text-align: center;">
                                    <?php $i++; ?>
                                    <td>#{{$i}}</td>
                                    <td>{{$value_success->order_date}}</td>
                                    <td>{{number_format($value_success->order_total)}}</td>
                                    <td>{{$value_success->order_status}}</td>
                                    <td>
                                        <a class="js_order_item" href="{{route('viewOrderCustomer',$value_success->order_id)}}"
                                            data-id="{{$value_success->order_id}}"
                                            style="display: block;text-align: center;">
                                            <i class="fas fa-eye text-warning"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="modelOrder" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"
        style="margin-top: 50px;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header f_text ui-draggable-handle">
                    <h5 class="modal-title">Chi tiết đơn hàng </h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="md_content">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
$(function() {
    $(".js_order_item").click(function(event) {
        event.preventDefault();
        let $this = $(this);
        let url = $this.attr('href');
        $("#modelOrder").modal('show');
        $.ajax({
            url: url,
        }).done(function(result) {
            console.log(result);
            if (result) {
                $("#md_content").html('').append(result);
            }
        });
    });
});
</script>
@stop