@extends('layouts.master')
@section('title','Danh mục sản phẩm')
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
                        Danh mục sản phẩm
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                        <form action="{{URL::to('/excel-cate-product')}}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary">Xuất excel</button>
                        </form>
                    </div>
                    <div class="col-lg-2 float-right">
                        <a href="{{URL::to('/add-cate-product')}}" class="btn btn-success" style="display: block;"> Thêm
                            mới</a>
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="cate-table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Tên danh mục</th>
                                    <th>Thuộc danh mục</th>
                                    <th>Mô tả</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Chọn</th>
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
    $('#cate-table').DataTable({
        // dom: 'lifrtp',
        processing: true,
        serverSide: true,
        ajax: "{{asset('categories')}}",
        columns: [{
                data: 'cate_id',
                name: 'cate_id'
            },
            {
                data: 'cate_name',
                name: 'cate_name'
            },
            {
                data: 'cate_parent',
                name: 'cate_parent'
            },
            {
                data: 'cate_name',
                name: 'cate_name'
            },
            {
                data: 'cate_status',
                name: 'cate_status'
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