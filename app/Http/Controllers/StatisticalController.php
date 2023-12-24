<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportsHangCoSan;
use App\Models\Product;
use App\Models\Statistical;
use App\Models\Visitors;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class StatisticalController extends Controller
{
    public function AuthLogin(){
        $admin_id =  Auth::id();
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }

    public function hang_co_san(){
        $this->AuthLogin();
            // $hang_co_san = DB::table('product')
            // ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
            // ->join('wood','wood.wood_id','=','product.wood_type_id')
            // ->where('product_qty','>',0)
            // ->orderBy('product.product_id','desc')->paginate(15);,compact('hang_co_san')
        return view('admin.statistical.hang_co_san');
    }
    public function data_hang_co_san(Request $request){
        if ($request->ajax()) {
            $data = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
            ->join('wood','wood.wood_id','=','product.wood_type_id')
            ->where('product_qty','>',0)
            ->orderBy('product.product_id','desc')->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '
                <a style="padding-left: 10px;" href="'.route('viewProduct',$data->product_id).'">
                    <i class="fas fa-eye    "></i>
                </a>
                ';
            })
            ->editColumn('product_status',function($data){
                return $data->product_status == 0 ? 'Ẩn' : 'Hiện';
            })
            ->editColumn('product_image',function($data){
                return '<img src="public/upload/product/'.$data->product_image.'" style="width: 100px;" >';
                
            })
            ->editColumn('product_price',function($data){
                return number_format($data->product_price);
            })
            ->rawColumns(['action','product_status','product_image'])
            ->make(true);
        }
    }
    
    public function statistical(Request $request){
        $this->AuthLogin();
        $count_cus = DB::table('customer')->count();
        $count_order = DB::table('order')->count();
        $count_contact = DB::table('contact')->count();

        // ====TRUY CẬP====
        $user_ip_address = $request->ip();
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $one_year = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        // ====TỔNG THÁNG TRƯỚC===
        $visitor_last_month = Visitors::whereBetween('date_visitor',[$early_last_month,$end_of_last_month])->get();
        $visitor_last_month_count = $visitor_last_month->count();

        // ====TỔNG THÁNG NÀY===
        $visitor_this_month = Visitors::whereBetween('date_visitor',[$early_this_month,$now])->get();
        $visitor_this_month_count = $visitor_this_month->count();

        // ====TỔNG NĂM===
        $visitor_of_year = Visitors::whereBetween('date_visitor',[$one_year,$now])->get();
        $visitor_of_year_count = $visitor_of_year->count();

        // ====TỔNG TRUY CẬP====
        $visitors = Visitors::all();
        $all_visitors = $visitors->count();

        // ===ĐANG ONL====
        $visitor_current = Visitors::where('ip_address',$user_ip_address)->get();
        $visitor_current_count = $visitor_current->count();
        if($visitor_current_count<1){
            $visitor = new Visitors();
            $visitor->ip_address = $user_ip_address;
            $visitor->date_visitor = Carbon::now('ASIA/Ho_Chi_Minh')->toDateString();
            $visitor->save();
        }

        // ===TỔNG DOANH THU===
        $all_statis = Statistical::select('sales')->get();
        $all_sales = 0;
        foreach($all_statis as $key => $value_sales){
            $sales = $value_sales->sales;
            $all_sales += $sales;
        }
        // dd($all_sales);
        $product_views = Product::orderBy('product_views','DESC')->take(20)->get();
        return view('admin.statistical.statistical',compact('product_views','visitor_current_count','all_visitors','visitor_last_month_count','visitor_this_month_count','visitor_of_year_count','count_cus','count_order','count_contact','all_sales'));
    }

    public function filter_by_date(Request $request){
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = Statistical::whereBetween('order_date',[$from_date,$to_date])->orderBy('order_date','ASC')->get();
        foreach($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function dashboard_filter(Request $request){
        $data = $request->all();
        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        
        if($data['dashboard_value'] == '7ngay'){
            $get = Statistical::whereBetween('order_date',[$sub7days,$now])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value'] == 'thangtruoc'){
            $get = Statistical::whereBetween('order_date',[$dauthangtruoc,$cuoithangtruoc])->orderBy('order_date','ASC')->get();
        }elseif($data['dashboard_value'] == 'thangnay'){
            $get = Statistical::whereBetween('order_date',[$dauthangnay,$now])->orderBy('order_date','ASC')->get();
        }else{
            $get = Statistical::whereBetween('order_date',[$sub365days,$now])->orderBy('order_date','ASC')->get();
        }
        foreach($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    public function days_order(Request $request){
        $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get = Statistical::whereBetween('order_date',[$sub30days,$now])->orderBy('order_date','ASC')->get();
        foreach($get as $key => $val){
            $chart_data[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity,
            );
        }
        echo $data = json_encode($chart_data);
    }

    //XUẤT EXCEL
     public function excel_hang_co_san(){
        return Excel::download(new ExcelExportsHangCoSan, 'hang_co_san.xlsx');
    }
}