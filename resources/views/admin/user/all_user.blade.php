@extends('layouts.master')
@section('title','Danh sách Admin')
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
                        Danh sách Admin
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                        <form action="{{URL::to('/excel-admin')}}" method="POST" style="display: inline;">
                            @csrf
                                <button type="submit" class="btn btn-outline-secondary">Xuất excel</button>
                        </form>
                    </div>
                    <div class="col-lg-2 float-right">
                        <a href="{{URL::to('/add-user')}}" class="btn btn-success" style="display: block;"> Thêm
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
                        <table class="table mt-5 table-striped table-bordered table-hover" id="admin-table">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Mật khẩu</th>
                                    <th>Họ và tên</th>
                                    <th>Số điện thoại</th>
                                    <th>Author</th>
                                    <th>Admin</th>
                                    <th>User</th>
                                    <th></th>
                                    <th colspan="2">Chọn</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $value)
                                <form action="{{url('/assign-roles')}}" method="post">
                                @csrf
                                    <tr style="text-align: center;">
                                        <td>{{$value->admin_id}}</td>
                                        <td>{{$value->admin_email}}
                                            <input type="hidden" name="admin_email" value="{{$value->admin_email}}">
                                            <input type="hidden" name="admin_id" value="{{$value->admin_id}}">
                                        </td>
                                        <td>{{$value->admin_password}}</td>
                                        <td>{{$value->admin_name}}</td>
                                        <td>{{$value->admin_phone}}</td>
                                        <td><input type="checkbox" name="author_role" {{$value->hasRole('author') ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="admin_role" {{$value->hasRole('admin') ? 'checked' : ''}}></td>
                                        <td><input type="checkbox" name="user_role" {{$value->hasRole('user') ? 'checked' : ''}}></td>
                                        <td>
                                            <input type="submit" value="Cấp quyền" class="btn btn-primary">
                                        </td>
                                        <td>
                                        <a href="{{URL::to('/delete-user/'.$value->admin_id)}}" style="border: none;background: none; outline: none;"
                                            onclick="return confirm('Bạn có chắc muốn xóa??')"><i
                                                class="far fa-trash-alt text-danger"></i></a>
                                        
                                        </td>
                                        <td>
                                        <a href="{{url('/impersonate/'.$value->admin_id)}}">Chuyển user</a>
                                        </td>
                                    </tr>
                                </form>
                                @endforeach
                            </tbody>
                        </table>
                        {{$admin->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection