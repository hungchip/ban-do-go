<!doctype html>
<html lang="en">
  <head>
    <title>Xác nhận đơn hàng</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>
  <body>
        <div class="container" style="background: #222; border-radius: 12px; padding: 15px;">
            <div class="col-md-12">
                <p style="text-align: center; color: #fff;">Đây là email tự động. Quý khách vui lòng không trả lời email này!</p>
    
                <div class="row" style="background: cadetblue; padding: 15px;">

                    <div class="col-md-6" style="text-align: center; color: #fff; font-weight: bold; font-size: 30px; ">
                        <h4 style="margin: 0;">ĐỒ GỖ ĐỨC LƯƠNG</h4>
                        <h6 style="margin: 0;">UY TÍN TẠO NIỀM TIN</h6>
                    </div>

                    <div class="col-md-6" style="color: #fff;">
                        <p>Chào bạn <strong style="color: #000; text-decoration: underline;">{{$name}}</strong></p>
                    </div>

                    <div class="col-md-12">
                        <p style="color: #fff; font-size: 17px;">Bạn hoặc một ai đó đã đăng kí dịch vụ tại cửa hàng với thông tin như sau:</p>
                        <h4 style="color: #000; text-transform: uppercase;">Thông tin đơn hàng</h4>
                        <p>Email: 
                            @if($email == '')
                                Không có
                            @else
                                <span style="color: #fff;">{{$email}}</span>
                            @endif
                        </p>

                        <p>Họ và tên người nhận hàng: 
                            @if($shipping_name == '')
                                Không có
                            @else
                                <span style="color: #fff;">{{$shipping_name}}</span>
                            @endif
                        </p>

                        <p>Số điện thoại người nhận: 
                            @if($phone == '')
                                Không có
                            @else
                                <span style="color: #fff;">{{$phone}}</span>
                            @endif
                        </p>

                        <p>Địa chỉ nhận hàng: 
                            @if($address == '')
                                Không có
                            @else
                                <span style="color: #fff;">{{$address}}</span>
                            @endif
                        </p>

                        <p>Ghi chú: 
                            @if($note == '')
                                Không có
                            @else
                                <span style="color: #fff;">{{$note}}</span>
                            @endif
                        </p>
                        <p style="color: #fff;">Nếu thông tin người nhận hàng không có chúng tôi sẽ liên hệ với người đặt hàng để trao đổi thông tin về đơn hàng đã đặt.</p>
                        <h4 style="color: #000; text-transform: uppercase;">Sản phẩm đã đặt</h4>
                        <table class="table table-striped" border="1" cellspacing = "0" cellpadding="10" width="900px">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 0; ?>
                                @foreach($orders as $key => $order)
                                <tr>
                                <?php $i++; ?>
                                <td>#{{$i}}</td>
                                <td>{{$order->product_name}} </td>
                                <td>{{$order->product_qty}}</td>
                                <td>{{number_format($order->product_price)}}</td>
                                <td>{{number_format($order->product_price * $order->product_qty)}}</td>
                                </tr>
                                @endforeach

                                <tr>
                                    <td colspan="5" align="right">Tổng tiền thanh toán {{number_format($total)}} vnđ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p style="color: #fff;">Mọi chi tiết xin liên hệ website tại : 
                        <a href="http://dogoducluong.com/" target="_blank">
                            Đồ gỗ Đức Lương
                        </a>, hoặc liên hệ qua số điện thoại: 033 556 2246. Cảm ơn quý khách!
                    </p>
                </div>
            </div>
        </div>
    
  </body>
</html>