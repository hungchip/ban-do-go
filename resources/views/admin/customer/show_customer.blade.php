@extends('layouts.master')
@section('title','Danh sách khách hàng')
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
                        Danh sách khách hàng
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                        <form action="{{URL::to('/excel-customer')}}" method="POST" style="display: inline;">
                            @csrf
                            <label for="" style="opacity: 0;">Xuất Excel</label>
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="customer-table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Ngày đăng kí</th>
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
    $('#customer-table').DataTable({
        // dom: 'lifrtp',
        processing: true,
        serverSide: true,
        ajax: "{{asset('all_customers')}}",
        columns: [{
                data: 'customer_id',
                name: 'customer_id'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'customer_email',
                name: 'customer_email'
            },
            {
                data: 'created_at',
                name: 'created_at'
            }
        ]
    });
});
</script>
@endsection