@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">
                        <i class="fas fa-home"><a href="">Trang chủ</a></i>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Thống kê doanh thu:</h4>
                    <form action="" method="get" autocomplete="off">
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
                                    <button type="button" id="check_revenue" class="btn btn-primary" style="width: 100%">Kiểm tra</button>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                Lọc theo
                                <div class="input-group">
                                    <select name="" class="dashboard-filter form-control" id="">
                                        <option value="">----CHỌN----</option>
                                        <option value="7ngay">7 ngày qua</option>
                                        <option value="thangtruoc">Tháng trước</option>
                                        <option value="thangnay">Tháng này</option>
                                        <option value="365ngayqua">365 ngày qua</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </form>
                    <div id="myfirstchart" style="height: 400px;"></div>

                    <h4 class="card-title">Thống kê truy cập:</h4>
                    <table class="table table-bordered ">
                        <thead>
                            <tr>
                                <th scope="col">Đang online</th>
                                <th scope="col">Tổng tháng trước</th>
                                <th scope="col">Tổng tháng này</th>
                                <th scope="col">Tổng 1 năm</th>
                                <th scope="col">Tổng truy cập</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$visitor_current_count}}</td>
                                <td>{{$visitor_last_month_count}}</td>
                                <td>{{$visitor_this_month_count}}</td>
                                <td>{{$visitor_of_year_count}}</td>
                                <td>{{$all_visitors}}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h4 class="card-title">Sản phẩm xem nhiều:</h4>
                    <ol style="margin: 10px 0;">
                        @foreach($product_views as $key => $pro)
                        <li>
                            <a style="color: orange; font-weight: 400;" target="_blank" href="{{url('chi-tiet-san-pham/'.Str::slug($pro->product_name))}}">
                                {{$pro->product_name}}  | <span style="color: black;">{{$pro->product_views}}</span>
                            </a>
                        </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-5">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card card-border border-pink">
                        <div class="card-body d-flex">
                            <div class="icon bg-pink">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="info">
                                <h4 class="title">
                                    Tổng doanh thu
                                </h4>
                                <strong class="amount">{{number_format($all_sales)}}đ</strong>
                            </div>
                        </div>
                        <a href="" class="text-muted text-uppercase detail">(Chi tiết)</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-border border-cus">
                        <div class="card-body d-flex">
                            <div class="icon bg-cus">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="info">
                                <h4 class="title">
                                    Tổng số khách hàng
                                </h4>
                                <strong class="amount">{{$count_cus}}</strong>
                            </div>
                        </div>
                        <a href="{{URL::to('/show-customer')}}" class="text-muted text-uppercase detail">(Chi tiết)</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-border border-disease">
                        <div class="card-body d-flex">
                            <div class="icon bg-disease">
                            <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="info">
                                <h4 class="title">
                                    Tổng số đơn hàng
                                </h4>
                                <strong class="amount">{{$count_order}}</strong>
                            </div>
                        </div>
                        <a href="{{URL::to('/all-order')}}" class="text-muted text-uppercase detail">(Chi tiết)</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card card-border border-drug">
                        <div class="card-body d-flex">
                            <div class="icon bg-drug">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="info">
                                <h4 class="title">
                                    Tổng số phản hồi
                                </h4>
                                <strong class="amount">{{$count_contact}}</strong>
                            </div>
                        </div>
                        <a href="{{URL::to('/all-contact')}}" class="text-muted text-uppercase detail">(Chi tiết)</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection