@extends('layouts.master')
@section('title','Danh sách hàng có sẵn')
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
                        Danh sách hàng có sẵn
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                    <form action="{{URL::to('/excel-hang-co-san')}}" method="POST" style="display: inline;">
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="hang-co-san">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Danh mục</th>
                                    <th>Loại gỗ</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Giá</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
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
    $('#hang-co-san').DataTable({
        // dom: 'lifrtp',
        processing: true,
        serverSide: true,
        ajax: "{{asset('available')}}",
        columns: [{
                data: 'product_id',
                name: 'product_id'
            },
           
            {
                data: 'cate_name',
                name: 'cate_name'
            },
            {
                data: 'wood_name',
                name: 'wood_name'
            },
            {
                data: 'product_name',
                name: 'product_name'
            },
            {
                data: 'product_qty',
                name: 'product_qty'
            },
            {
                data: 'product_image',
                name: 'product_image',
                
            },
            {
                data: 'product_price',
                name: 'product_price'
            },
            {
                data: 'product_status',
                name: 'product_status'
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
            {
                data: 'action',
                name: 'action'
            }
        ]
    });
});
</script>
@endsection