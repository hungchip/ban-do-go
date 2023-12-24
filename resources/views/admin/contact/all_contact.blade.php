@extends('layouts.master')
@section('title','Phản hồi khách hàng')
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
                    Phản hồi khách hàng
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                        <form action="{{URL::to('/excel-contact')}}" method="POST" style="display: inline;">
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="contact-table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Tên khách hàng</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Chủ đề</th>
                                    <th>Nội dung</th>
                                    <th>Ngày gửi</th>
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
    $('#contact-table').DataTable({
        // dom: 'lifrtp',
        processing: true,
        serverSide: true,
        ajax: "{{asset('contacts')}}",
        columns: [{
                data: 'contact_id',
                name: 'contact_id'
            },
            {
                data: 'contact_name',
                name: 'contact_name'
            },
            {
                data: 'contact_email',
                name: 'contact_email'
            },
            {
                data: 'contact_phone',
                name: 'contact_phone'
            },
            {
                data: 'contact_topic',
                name: 'contact_topic'
            },
            {
                data: 'contact_content',
                name: 'contact_content'
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