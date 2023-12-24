@extends('layouts.master')
@section('title','Loại gỗ')
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
                        Loại gỗ
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                    <form action="{{URL::to('/excel-wood')}}" method="POST" style="display: inline;">
                        @csrf
                            <button type="submit" class="btn btn-outline-secondary">Xuất excel</button>
                    </form>
                    </div>
                    <div class="col-lg-2 float-right">
                        <a href="{{URL::to('/add-wood-type')}}" class="btn btn-success" style="display: block;"> Thêm
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="wood-table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Tên loại gỗ</th>
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
    $('#wood-table').DataTable({
        // dom: 'lifrtp',
        processing: true,
        serverSide: true,
        ajax: "{{asset('woods')}}",
        columns: [{
                data: 'wood_id',
                name: 'wood_id'
            },
            {
                data: 'wood_name',
                name: 'wood_name'
            },
            {
                data: 'wood_desc',
                name: 'wood_desc'
            },
            {
                data: 'wood_status',
                name: 'wood_status'
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