@if ($orders)
    <table class="table">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            @foreach ($orders as $key => $order)
                <?php $i++; ?>
                <tr>
                    <td>#{{ $i }}</td>
                    <td> <a style="color: #111;"
                            href="{{ URL::to('chi-tiet-san-pham/' . Str::slug($order->product_name)) }}"
                            target="blank">{{ $order->product_name }}</a> </td>
                    <td>
                        <img style="width: 100px;" src="upload/product/{{ $order->products->product_image }}"
                            alt="">
                    </td>
                    <td>{{ $order->product_qty }}</td>
                    <td>{{ number_format($order->product_price) }}</td>
                    <td>{{ number_format($order->product_price * $order->product_qty) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3 style="padding: 15px 0px;">THÔNG TIN VẬN CHUYỂN</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Địa chỉ Email</th>
                <th>Số điện thoại</th>
                <th>Địa chỉ giao hàng</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($order_by_id as $value_shipping) {
                $s_name = $value_shipping->shipping_name;
                $s_email = $value_shipping->shipping_email;
                $s_phone = $value_shipping->shipping_phone;
                $s_address = $value_shipping->shipping_address;
                $s_note = $value_shipping->shipping_note;
            }
            ?>
            <tr>
                <td>{{ $s_name }}</td>
                <td>{{ $s_email }}</td>
                <td>{{ $s_phone }}</td>
                <td>{{ $s_address }}</td>
                <td>{{ $s_note }}</td>
            </tr>
        </tbody>
    </table>
@endif
