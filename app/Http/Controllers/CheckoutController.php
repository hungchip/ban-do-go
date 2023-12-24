<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Rules\Captcha;
class CheckoutController extends Controller
{
    public function login_checkout()
    {
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.checkout.login_checkout',compact('all_cate_product'));
    }

    public function checkout()
    {
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        $id_product_cart = array();
        $id_product = array();
        $qty_product_cart = array();
        $product_qty = array();
        $value1 = array();
        foreach(Cart::content() as $key => $value){
            $id_product_cart[] = $value->id;
            $qty_product_cart[] = $value->qty;
            // dd($product);    
        }
        sort($id_product_cart);
        // dd($id_product_cart); 
        $product = Product::whereIn('product_id', $id_product_cart)->get();
   
        // foreach(Cart::content() as $key => $value){
        // foreach($product as $key => $value_pro){
        //     // $product_qty[] = $value_pro->product_qty; 
        //     // $id_product[] = $value_pro->product_id; 
        //         // dd($product);   
        //         if($value_pro->product_id == $value->id && $value_pro->product_qty<$value->qty){
        //             return redirect()->back()->with('danger',' Có vẻ số lượng mặt hàng nào đó không đủ, vui lòng kiểm tra hoặc liên hệ để đặt hàng. Trân trọng!');
        //             // echo('ko thể mua');
        //         }elseif($value_pro->product_id == $value->id && $value_pro->product_qty>=$value->qty){
        //             return view('pages.checkout.show_checkout',compact('all_cate_product'));
        //             // echo('ok');
        //         } 
        //     }
        
        // }
        

        // foreach(Cart::content() as $key => $value){
            // $id_product_cart[] = $value->id;
            // $qty_product_cart[] = $value->qty;
            foreach($product as $key => $value_pro){
                $id_product[] = $value_pro->product_id;
                $product_qty[] = $value_pro->product_qty;  
                if($id_product == $id_product_cart){
                    if($product_qty<$qty_product_cart){
                        return redirect()->back()->with('danger',' Có vẻ số lượng mặt hàng nào đó không đủ, vui lòng kiểm tra hoặc liên hệ để đặt hàng. Trân trọng!');
                    }elseif($product_qty>=$qty_product_cart){
                        return view('pages.checkout.show_checkout',compact('all_cate_product'));
                    }  
                }
            }
        // }
        // dd($id_product); 

        // dd($product);
      
        // dd(Cart::content());
        // if($qty_product_cart > $product_qty){
            // return redirect()->back()->with('danger',' Có vẻ số lượng mặt hàng nào đó không đủ, vui lòng kiểm tra hoặc liên hệ để đặt hàng. Trân trọng!');
        // }else{
            // return view('pages.checkout.show_checkout',compact('all_cate_product'));
        // }
    }

    public function save_checkout(Request $request){
        // dd($request->all());
        
        if($request->payment == 2){
            $total_order = Cart::subtotalFloat();
            $all_ = array();
            $data_shipping['shipping_name'] = $request->shipping_name;
            $data_shipping['shipping_email'] = $request->shipping_email;
            $data_shipping['shipping_note'] = $request->shipping_note;
            $data_shipping['shipping_address'] = $request->shipping_address;
            $data_shipping['shipping_phone'] = $request->shipping_phone;
            $data_shipping['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data_shipping['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $shipping_id = DB::table('shipping')->insertGetId($data_shipping);
            Session::put('shipping_id',$shipping_id);
            return view('pages.vnpay.index',compact('total_order'));
        }else{
            $data_shipping = array();
            $data_shipping['shipping_name'] = $request->shipping_name;
            $data_shipping['shipping_email'] = $request->shipping_email;
            $data_shipping['shipping_note'] = $request->shipping_note;
            $data_shipping['shipping_address'] = $request->shipping_address;
            $data_shipping['shipping_phone'] = $request->shipping_phone;
            $data_shipping['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data_shipping['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $shipping_id = DB::table('shipping')->insertGetId($data_shipping);
            Session::put('shipping_id',$shipping_id);
        
            //INSERT ORDER
            $data_order = array();
            $data_order['customer_id'] = Session::get('customer_id');
            $data_order['shipping_id'] = Session::get('shipping_id');
            $data_order['order_total'] = Cart::subtotalFloat();
            $data_order['order_status'] = 'Đơn hàng mới';
            $data_order['order_date'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $data_order['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data_order['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $order_id = DB::table('order')->insertGetId($data_order);

            //INSERT ORDER DETAIL
            $content = Cart::content();
            foreach($content as $v_content){
                $data_order_det['order_id'] = $order_id;
                $data_order_det['product_id'] = $v_content->id;
                $data_order_det['product_name'] = $v_content->name;
                $data_order_det['product_price'] = $v_content->price;
                $data_order_det['product_qty'] = $v_content->qty;
                $data_order_det['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
                $data_order_det['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
                DB::table('order_detail')->insert($data_order_det);
            }
            
            //GỬI MAIL
            $cus_id = Session::get('customer_id');
            $all_data_cus = Customer::where('customer_id',$cus_id)->get();
            foreach($all_data_cus as $key => $value){
                $cus_name = $value->customer_name;
                $cus_email = $value->customer_email;
            }
            $order = DB::table('order')->where('created_at', Carbon::now('Asia/Ho_Chi_Minh'))->get();
            foreach($order as $key => $value_order){
                $order_total = $value_order->order_total;
            }
            // dd($cus_email);
            // if (!empty($request->shipping_email)) {
                Mail::send('admin.email.order', [
                    'name' => $cus_name,
                    'shipping_name' => $request->shipping_name,
                    'email' => $request->shipping_email,
                    'phone' => $request->shipping_phone,
                    'address' => $request->shipping_address,
                    'note' => $request->shipping_note,
                    // 'items' => Cart::content(),
                    'total' => $order_total,
                    'orders' => DB::table('order_detail')->where('created_at', Carbon::now('Asia/Ho_Chi_Minh'))->get(),
                ], function ($mail) {
                    $cus_id = Session::get('customer_id');
                    $all_data_cus = Customer::where('customer_id',$cus_id)->get();
                    foreach($all_data_cus as $key => $value){
                        $cus_name = $value->customer_name;
                        $cus_email = $value->customer_email;
                    }
                    $mail->to($cus_email);
                    $mail->from($cus_email);
                    $mail->subject('Đơn đặt hàng');
                });
            // }
            Cart::destroy();
            return Redirect('/trang-chu')->with('order_success','Cảm ơn bạn đã đặt hàng! Vui lòng xác nhận lại trong Email hoặc phần lịch sử mua hàng trên trang web!');
        }
    }

    public function add_customer(Request $request){
        $messenger = [
            'customer_email.unique' => 'Email này đã được đăng kí!!',
            'customer_password.min' => 'Mật khẩu phải từ 6 kí tự!!',
        ];
        $request->validate([
            'customer_email' => 'unique:customer',
            'customer_password' => 'min:6',
            'g-recaptcha-response' => new Captcha(), 	
        ], $messenger);

        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_email'] = $request->customer_email;
        $data['customer_password'] = md5($request->customer_password);
        $data['customer_phone'] = $request->customer_phone;
        $data['customer_avatar'] = "avatar-user.png";
        $data['created_at'] = Carbon::now('ASIA/Ho_Chi_Minh');

        $customer_id = DB::table('customer')->insertGetId($data);
        Session::put('customer_id',$customer_id);
        Session::put('customer_name',$request->customer_name);

       return redirect()->back();
    }

    public function logout_checkout(){
        Session::flush();
        return redirect()->back();
    }

    public function login_customer(Request $request){
        $email = $request->email_account;
        $password = md5($request->password_account);
        $result = DB::table('customer')
        ->where('customer_email',$email)
        ->where('customer_password',$password)
        ->first();
        // dd($result);
       if($result){
        Session::put('customer_id',$result->customer_id);
        Session::put('customer_name',$result->customer_name);
        return redirect()->back()->with('message','Đăng nhập thành công');
       }else{
        return Redirect('/dang-nhap')->with('message','Email hoặc mật khẩu không chính xác');
       }

    }
   
    //TT ONLINE 
    public function payment_online(Request $request){
        // dd($request->all());
        $vnp_TxnRef = str_random(15); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = $request->order_desc;
        $vnp_OrderType = $request->order_type;
        $vnp_Amount = str_replace(',', '',  $request->amount)* 100;
        $vnp_Locale = $request->language;
        $vnp_BankCode = $request->bank_code;
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = array(
            "vnp_Version" => "2.0.0",
            "vnp_TmnCode" => env('VNP_TMN_CODE'),
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => route('vnpay.return'),
            "vnp_TxnRef" => $vnp_TxnRef,
            
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . $key . "=" . $value;
            } else {
                $hashdata .= $key . "=" . $value;
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = env('VNP_URL') . "?" . $query;
        if (env('VNP_HASH_SECRET')) {
        // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
            $vnpSecureHash = hash('sha256', env('VNP_HASH_SECRET') . $hashdata);
            $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function vnpay_return(Request $request){
        // dd($request->all());
        if( Session::get('customer_id') && $request->vnp_ResponseCode == '00'){
            $vnpData = $request->all();
            $data_order = array();
            $data_order['customer_id'] = Session::get('customer_id');
            $data_order['shipping_id'] = Session::get('shipping_id');
            $data_order['order_total'] = Cart::subtotalFloat();
            $data_order['order_status'] = 'Đã thanh toán online';
            $data_order['order_date'] = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
            $data_order['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $data_order['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
            $order_id = DB::table('order')->insertGetId($data_order);

            //INSERT ORDER
            $content = Cart::content();
            foreach($content as $v_content){
                $data_order_det['order_id'] = $order_id;
                $data_order_det['product_id'] = $v_content->id;
                $data_order_det['product_name'] = $v_content->name;
                $data_order_det['product_price'] = $v_content->price;
                $data_order_det['product_qty'] = $v_content->qty;
                $data_order_det['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
                $data_order_det['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
                DB::table('order_detail')->insert($data_order_det);
            }

            //INSERT PAYMENT
            $dataPayment =[
                'order_id' => $order_id,
                'order_code' => $vnpData['vnp_TxnRef'],
                'user_id' => Session::get('customer_id'),
                'total_order' => $vnpData['vnp_Amount'],
                'note' => $vnpData['vnp_OrderInfo'],
                'vnp_response_code' => $vnpData['vnp_ResponseCode'],
                'code_vnpay' => $vnpData['vnp_TransactionNo'],
                'code_bank' => $vnpData['vnp_BankCode'],
                'time' => date('Y-m-d H:i', strtotime($vnpData['vnp_PayDate'])),
            ]; 
            Payment::insert($dataPayment);

            // Gửi mail
            $cus_id = Session::get('customer_id');
            $shipping_id = Session::get('shipping_id');
            $all_data_cus = Customer::where('customer_id',$cus_id)->get();
            foreach($all_data_cus as $key => $value){
                $cus_name = $value->customer_name;
                $cus_email = $value->customer_email;
            }

            $order = DB::table('order')->where('created_at', Carbon::now('Asia/Ho_Chi_Minh'))->get();
            foreach($order as $key => $value_order){
                $order_total = $value_order->order_total;
            }

            $all_data_shipping = Shipping::where('shipping_id',$shipping_id)->get();
            foreach($all_data_shipping as $key => $value_shipping){
                $shipping_name = $value_shipping->shipping_name;
                $shipping_email = $value_shipping->shipping_email;
                $shipping_phone = $value_shipping->shipping_phone;
                $shipping_address = $value_shipping->shipping_address;
                $shipping_note = $value_shipping->shipping_note;
            }

            Mail::send('admin.email.order', [
                'name' => $cus_name,
                'shipping_name' => $shipping_name,
                'email' => $shipping_email,
                'phone' => $shipping_phone,
                'address' => $shipping_address,
                'note' => $shipping_note,
                // 'items' => Cart::content(),
                'total' => $order_total,
                'orders' => DB::table('order_detail')->where('created_at', Carbon::now('Asia/Ho_Chi_Minh'))->get(),
            ], function ($mail) {
                $cus_id = Session::get('customer_id');
                $all_data_cus = Customer::where('customer_id',$cus_id)->get();
                foreach($all_data_cus as $key => $value){
                    $cus_name = $value->customer_name;
                    $cus_email = $value->customer_email;
                }
                    $mail->to($cus_email);
                    $mail->from($cus_email);
                    $mail->subject('Đơn đặt hàng');
                });

            Cart::destroy();
            return view('pages.vnpay.vnpay_return',compact('vnpData'));
        }else{
            return redirect('gio-hang')->with('message','Thanh toán không thành công, vui lòng thử lại!');
        }
        
    }
}