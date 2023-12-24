<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
class CustomerController extends Controller
{
    public function edit_info(Request $request){
        if(!Session::get('customer_id')){
            return redirect('dang-nhap')->with('message','Vui lòng đăng nhập để xem thông tin cá nhân!');
        }
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        $data_cus = Customer::where('customer_id',Session::get('customer_id'))->get();
       
        return view ('pages.customer.info',compact('all_cate_product','data_cus'));
    }

    public function update_info(Request $request){
        $data = array();
        $data['customer_name'] = $request->customer_name;
        $data['customer_phone'] = $request->customer_phone;
        $get_image = $request->file('customer_avatar');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/avatar-user',$new_image);
            $data['customer_avatar'] = $new_image;
            DB::table('customer')->where('customer_id',Session::get('customer_id'))->update($data);
            Session::put('message','Sửa thông tin cá nhân thành công!!');
            return Redirect::to('thong-tin-ca-nhan');
        }
        DB::table('customer')->where('customer_id',Session::get('customer_id'))->update($data);
        Session::put('message','Sửa thông tin cá nhân thành công!!');
        return Redirect::to('thong-tin-ca-nhan');
    }

    public function edit_password(){
        if(!Session::get('customer_id')){
            return redirect('dang-nhap')->with('message','Vui lòng đăng nhập để thay đổi mật khẩu!');
        }
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view ('pages.customer.changepassword',compact('all_cate_product'));
    }

    public function update_password(Request $request){
        $all_data = Customer::where('customer_id',Session::get('customer_id'))->get();
        foreach($all_data as $key => $value){
            $password = $value->customer_password;
        }
        $messenger = [
            'new_pass.min' => 'Mật khẩu phải từ 6 kí tự trở lên'
        ];
        $request->validate([
            'new_pass' => 'min:6'
        ], $messenger);
        
        $old_pass = $request->old_pass;
        $new_pass = $request->new_pass;
        $apply_pass = $request->apply_pass;
        if($password == md5($old_pass) && $new_pass == $apply_pass){
            $customer = Customer::find(Session::get('customer_id'));
            $customer->customer_password = md5($new_pass);
            $customer->save();
            Session::put('message','Thay đổi mật khẩu thành công!');
            return redirect()->back();
        }elseif($password != md5($old_pass)){
            Session::put('message','Mật khẩu cũ không chính xác!');
            return redirect()->back();
        }
        elseif($apply_pass != $new_pass){
            Session::put('message','Mật khẩu xác nhận không chính xác!');
            return redirect()->back();
        }
    }

    public function history(Request $request){
        // $cus_id = Session::get('customer_id');
        if(!Session::get('customer_id')){
            return redirect('dang-nhap')->with('message','Vui lòng đăng nhập để xem lịch sử đơn hàng!');
        }else{
            $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
            $all_order_success = Order::where('customer_id',Session::get('customer_id'))
            ->where('order_status','Thành công')->get();
            $all_order_not_success = Order::where('customer_id',Session::get('customer_id'))
            ->where('order_status','<>','Thành công')->get();
            return view ('pages.customer.history',compact('all_cate_product','all_order_success','all_order_not_success'));
        }
    }

    public function viewOrder(Request $req, $id)
    {
        if($req->ajax())
        {
            $orders = OrderDetail::with('products')
                        ->where('order_id',$id)->get();
            // $shippings = OrderDetail::with('shippings')->where('order_id',$id)->get();,'shippings'
            $order_by_id = DB::table('order')
                ->join('customer','order.customer_id','=','customer.customer_id')
                ->join('shipping','order.shipping_id','=','shipping.shipping_id')
                ->join('order_detail','order.order_id','=','order_detail.order_id')
                ->where('order_detail.order_id',$id)
                ->get();
            $html = view('pages.components.order',compact('orders','order_by_id'))->render();

            return \response()->json($html);
        }
    }

    public function cancel_order(Request $request){
       $data = $request->all();
       $order = Order::where('order_id',$data['id'])->first();
       $order->order_reason = $data['lydo'];
       $order->order_status = "Đơn hàng hủy";
       $order->save();
    //    dd($order);
    }
    public function apply_order(Request $request){
        // dd($request->all());
        $data = $request->all();
        $order = Order::where('order_id',$data['id'])->first();
        $order->order_status = "Xác nhận";
        $order_id = $data['id'];
        $order_by_id = DB::table('order')
            ->join('customer','order.customer_id','=','customer.customer_id')
            ->join('shipping','order.shipping_id','=','shipping.shipping_id')
            ->join('order_detail','order.order_id','=','order_detail.order_id')
            ->where('order_detail.order_id',$order_id)
            ->get();
        // dd($order_by_id );
        foreach($order_by_id as $key => $value){
            $cus_name = $value->customer_name;
            $cus_email = $value->customer_email;
            $shipping_name = $value->shipping_name;
            $shipping_email = $value->shipping_email;
            $shipping_phone = $value->shipping_phone;
            $shipping_address = $value->shipping_address;
            $shipping_note = $value->shipping_note;
            $order_total = $value->order_total;
        }
            Mail::send('admin.email.confirm_order', [
                'name' => $cus_name,
                'shipping_name' => $shipping_name,
                'email' => $shipping_email,
                'phone' => $shipping_phone,
                'address' => $shipping_address,
                'note' => $shipping_note,
                'total' => $order_total,
                'order_by_id' =>DB::table('order')
                    ->join('customer','order.customer_id','=','customer.customer_id')
                    ->join('shipping','order.shipping_id','=','shipping.shipping_id')
                    ->join('order_detail','order.order_id','=','order_detail.order_id')
                    ->where('order_detail.order_id',$order_id)
                    ->get(),
            ], function ($mail) use ($request){
                $order_id = $request->id;
                $order_by_id = DB::table('order')
                    ->join('customer','order.customer_id','=','customer.customer_id')
                    ->join('shipping','order.shipping_id','=','shipping.shipping_id')
                    ->join('order_detail','order.order_id','=','order_detail.order_id')
                    ->where('order_detail.order_id',$order_id)
                    ->get();
                foreach($order_by_id as $key => $value){
                    $cus_email = $value->customer_email;
                }
                $mail->to($cus_email);
                $mail->from($cus_email);
                $mail->subject('Đơn đặt hàng');
            });
        $order->save();
    }
}
