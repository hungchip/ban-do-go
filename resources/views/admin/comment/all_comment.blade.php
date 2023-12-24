@extends('layouts.master')
@section('title','Bình luận')
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
                        Bình luận
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="display:inline">@yield('title')</h2>
                    <div class="col-lg-2 float-right">
                        <form action="{{URL::to('/excel-comment')}}" method="POST" style="display: inline;">
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
                    <div id="notify_comment"></div>
                    <div class="table-responsive-md">
                        <table class="table mt-5 table-striped table-bordered table-hover" id="myTable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>ID</th>
                                    <th>Duyệt</th>
                                    <th>Tên người gửi</th>
                                    <th>Bình luận</th>
                                    <th>Sản phẩm</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($comment as $value)
                                <tr style="text-align: center;">
                                <td>{{$value->comment_id}}</td>
                                <td>
                                    @if($value->comment_status == 0)
                                        <input type="button"  data-comment_status="1" data-comment_id="{{$value->comment_id}}" id="{{$value->comment_product_id}}" 
                                            class="btn btn-primary btn-sm comment_duyet_btn" value="Duyệt">
                                    @else
                                        <input type="button" data-comment_status="0" data-comment_id="{{$value->comment_id}}" id="{{$value->comment_product_id}}" 
                                            class="btn btn-danger btn-sm comment_duyet_btn" value="Bỏ duyệt">
                                    @endif
                                </td>
                                <td>{{$value->comment_name}}</td>
                                <td style="text-align: left;">{{$value->comment}}
                                    <ul style="margin: 0; padding: 0;">
                                    Trả lời:
                                        @foreach($comment_rep as $key => $comment_reply)
                                            @if($comment_reply->comment_parent_comment == $value->comment_id)
                                            <li style="text-align: left; list-style-type: decimal; color: blue;margin: 5px 40px;"> {{$comment_reply->comment}}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    @if($value->comment_status == 1)
                                        <br> <textarea style="width: 100%;" class="form-control reply_comment_{{$value->comment_id}}" rows="3"></textarea>
                                        <br> <button data-product_id="{{$value->comment_product_id}}"  class="btn btn-primary btn-reply-comment" data-comment_id="{{$value->comment_id}}">Trả lời</button>
                                    @endif
                                    </td>
                                    <td><a href="{{url('chi-tiet-san-pham/'.Str::slug($value->product->product_name))}}" target="_blank">{{$value->product->product_name}}</a></td>
                                    <td>{{$value->comment_date}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$comment->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection