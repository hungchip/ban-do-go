<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportsOrder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Statistical;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{
    public function AuthLogin(){
        $admin_id =  Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }

     ///ĐƠN HÀNG
     public function all_order(){
        $this->AuthLogin();
        // $all_order = DB::table('order')
        // ->join('customer','order.customer_id','=','customer.customer_id')
        // ->select('order.*','customer.customer_name')
        // ->orderBy('order.order_id','desc')->paginate(15);compact('all_order')
        return view('admin.order.all_order');
    }
    
    public function view_filter_order(Request $request){
        $this->AuthLogin();
        $data = DB::table('order')
        ->join('customer','order.customer_id','=','customer.customer_id')
        ->select('order.*','customer.customer_name')
        ->orderBy('order.order_id','desc')->get();
        return view('admin.order.filter_order',compact('data'));
    }

    public function filter_order(Request $request){
        // dd($request->dateStart);
        $data = $request->all();
        $from_date = $data['dateStart'];
        $to_date = $data['dateEnd'];
        $data = DB::table('order')
        ->join('customer','order.customer_id','=','customer.customer_id')
        ->select('order.*','customer.customer_name')
        ->whereBetween('order_date',[$from_date,$to_date])
        ->orderBy('order_date','DESC')->get();
        // dd($data);
        return view('admin.order.filter_order',compact('data'));
    }

    public function all_data_order(Request $request){
        if ($request->ajax()) {
            $data = DB::table('order')
                        ->join('customer','order.customer_id','=','customer.customer_id')
                        ->select('order.*','customer.customer_name')
                        ->orderBy('order.order_id','desc')->get();
            return DataTables::of($data)
            ->addColumn('detail', function ($data) {
                return '
                <a href="'.route('viewOrder',$data->order_id).'" style="    text-align: center;
                display: block;">
                    <i class="fas fa-eye text-warning"></i>
                </a>
                ';
            })
            ->editColumn('order_status',function($data){
                return  $data->order_status . '
                <a href="'.route('editStatus',$data->order_id).'" style="float: right;"> 
                    <i class="fas fa-pen-alt text-warning"></i>
                </a> 
                 ';
            })
            ->editColumn('order_total',function($data){
                return number_format($data->order_total);
            })
            ->rawColumns(['detail','order_status'])
            ->make(true);
        }
    }
    public function view_order($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('order')
        ->join('customer','order.customer_id','=','customer.customer_id')
        ->join('shipping','order.shipping_id','=','shipping.shipping_id')
        ->join('order_detail','order.order_id','=','order_detail.order_id')
        ->where('order_detail.order_id',$order_id)
        // ->select('order_detail.*')
        ->get();
        return view('admin.order.view_order',compact('order_by_id'));
    }

      //IN PDF

    public function print_pdf($order_id){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_convert($order_id));
        return $pdf->stream();
    }
    public function print_convert($order_id){
        $order_by_id = DB::table('order')
        ->join('customer','order.customer_id','=','customer.customer_id')
        ->join('shipping','order.shipping_id','=','shipping.shipping_id')
        ->join('order_detail','order.order_id','=','order_detail.order_id')
        ->where('order_detail.order_id',$order_id)
        ->get();  
        foreach($order_by_id as $key => $value_product){}
        
        $output = '';
        $output.='
            <style>
                body{
                    font-family: Dejavu Sans;
                }
                table,td,tr,th{
                    border: 2px solid black;
                }
            </style>
            <h1 style="text-align: center;">Đồ gỗ Đức Lương</h1>
            <h1 style="text-align: center;">Đơn đặt hàng </h1>
            <p>Cảm ơn đã mua hàng tại cơ sở Đồ gỗ Đức Lương! Mọi thắc mắc, phản ánh vui lòng liên hệ sđt: 0335562246 hoặc email dogoducluong@gmail.com</p>
            <h2 style="text-align: center;">Thông tin vận chuyển</h2>
        ';
        $output.='
        <table >
            <thead>
                <tr style="text-align: center;">
                    <th>Tên</th>
                    <th>Địa chỉ Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Ghi chú</th>
                </tr>
            </thead>
            <tbody>
        ';


        foreach($order_by_id as $value_shipping){
            $s_name = $value_shipping->shipping_name;
            $s_email = $value_shipping->shipping_email;
            $s_phone = $value_shipping->shipping_phone;
            $s_address = $value_shipping->shipping_address;
            $s_note = $value_shipping->shipping_note;
        }
        $output.='
            <tr style="text-align: center;">
                <td>'.$s_name.'</td>
                <td>'.$s_email.'</td>
                <td>'.$s_phone.'</td>
                <td>'.$s_address.'</td>
                <td>'.$s_note.'</td>
            </tr>
        </tbody>
        </table>
        ';
        $output.='
        <h2 style="text-align: center;">Thông tin đơn hàng</h2>
        <table>
        <thead>
            <tr style="text-align: center;">
                <th style="width: 200px;">Tên sản phẩm</th>
                <th>Số lượng</th>
                <th style="width: 150px;">Giá</th>
                <th style="width: 150px;">Tổng tiền</th>
            </tr>
        </thead>
        <tbody>';
        foreach($order_by_id as $key => $value_product){
        
        $output.='
            <tr style="text-align: center;">
                <td>'.$value_product->product_name.'</td>
                <td>'.$value_product->product_qty.'</td>
                <td>'.number_format($value_product->product_price).'</td>
                <td>'.number_format($value_product->product_qty*$value_product->product_price).'</td>
            </tr>';
        }  
        $output.='
        </tbody>
    </table>
    ';
    $output.='
        <h5>Tổng giá trị đơn hàng: '.$value_product->order_total.' VNĐ</h5>
    ';

    $output.='
    <br>
    <table style="border: none;">
    <thead>
        <tr>
            <th style="border: none; width: 200px;"">Người lập phiếu</th>
            <th style="border: none; width: 800px;">Người nhận</th>
        </tr>
    </thead>
    <tbody>
    ';
    return $output;
    }

    //XUẤT EXCEL
    public function excel_order(){
        return Excel::download(new ExcelExportsOrder, 'order.xlsx');
    }

    public function edit_status($order_id){
        $this->AuthLogin();
        $order_by_id = DB::table('order')
        ->join('customer','order.customer_id','=','customer.customer_id')
        ->join('shipping','order.shipping_id','=','shipping.shipping_id')
        ->join('order_detail','order.order_id','=','order_detail.order_id')
        ->where('order_detail.order_id',$order_id)
        ->get();
        return view('admin.order.edit_status',compact('order_by_id'));
    }

    public function update_status($order_id, Request $request){
        $this->AuthLogin();
        $data = array();
        $order = Order::find($order_id);
        $order->order_status = $request->order_status;
        $order->save();
        $order_date = $order->order_date;
        $order_details = DB::table('order_detail')->where('order_id',$order_id)->get(); 
        $statistic = Statistical::where('order_date',$order_date)->get();
        if($statistic){
            $statistic_count = $statistic->count();
        }else{
            $statistic_count = 0;
        }
        if($order->order_status == "Thành công"){
            $total_order = 0;
            $sales = 0;
            $profit = 0;
            $quantity = 0;
            $all_cost = 0;
            foreach($order_details as $key => $order_detail){
                $product = Product::find($order_detail->product_id);
                if($product->product_qty > 0){
                    $product->product_qty =  $product->product_qty - $order_detail->product_qty;
                }
                $product_cost = $product->product_cost;
                $product->save();
                $all_cost+=$product_cost;
                $quantity+=$order_detail->product_qty;
                $sales+=$order_detail->product_price * $order_detail->product_qty;
                    
                echo $profit = $sales- ($all_cost*$order_detail->product_qty);
                }
            $total_order+=1;
            if($statistic_count>0){
                $statistic_update = Statistical::where('order_date',$order_date)->first();
                $statistic_update->sales =  $statistic_update->sales + $sales;
                $statistic_update->profit =  $statistic_update->profit + $profit;
                $statistic_update->quantity =  $statistic_update->quantity + $quantity;
                $statistic_update->total_order =  $statistic_update->total_order + $total_order;
                $statistic_update->save();
            }else{
                $statistic_new = new Statistical();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();
            }
        }

        // ---GỬI MAIL KHI XÁC NHẬN ĐƠN---
        $order_by_id = DB::table('order')
            ->join('customer','order.customer_id','=','customer.customer_id')
            ->join('shipping','order.shipping_id','=','shipping.shipping_id')
            ->join('order_detail','order.order_id','=','order_detail.order_id')
            ->where('order_detail.order_id',$order_id)
            ->get();
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
        if($order->order_status == "Xác nhận"){
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
                    $order_id = $request->order_id;
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
        }
        Session::put('message','Sửa trạng thái đơn hàng thành công!!');
        return Redirect::to('all-order');
    }
}