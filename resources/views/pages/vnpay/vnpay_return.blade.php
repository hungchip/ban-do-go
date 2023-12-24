<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Thông tin thanh toán</title>
    <!-- Bootstrap core CSS -->
    <link href="{{ url('/frontend') }}/vnpay/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ url('/frontend') }}/vnpay/jumbotron-narrow.css" rel="stylesheet">
    <script src="{{ url('/frontend') }}/vnpay/jquery-1.11.3.min.js"></script>
</head>

<body>
    <!--Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">Thông tin đơn hàng</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>

                <label><?php echo $_GET['vnp_TxnRef']; ?></label>
            </div>
            <div class="form-group">

                <label>Số tiền:</label>
                <label><?= number_format($_GET['vnp_Amount'] / 100) ?> VNĐ</label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo $_GET['vnp_OrderInfo']; ?></label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo $_GET['vnp_ResponseCode']; ?></label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label><?php echo $_GET['vnp_TransactionNo']; ?></label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo $_GET['vnp_BankCode']; ?></label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo $_GET['vnp_PayDate']; ?></label>
            </div>
            <div class="form-group">
                <label>Kết quả: Thành công</label>
                <br>
                <p style="font-weight: bold; font-style: italic; color: red;">Cảm ơn bạn đã đặt hàng tại <a
                        href="{{ url('/') }}">Đồ Gỗ Đức Lương</a>, bạn vui lòng kiểm tra lại Email hoặc <a
                        href="{{ url('/lich-su-mua-hang') }}">Lịch sử đơn hàng</a> để xem thông tin đơn hàng!</p>
                <a href="{{ url('/trang-chu') }}">
                    <button>Quay lại</button>
                </a>
            </div>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; Đồ gỗ Đức Lương</p>
        </footer>
    </div>
</body>

</html>
