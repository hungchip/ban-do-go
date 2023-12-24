<?php

namespace App\Http\Controllers;

use App\Models\CategoryProductModel;
use App\Models\Customer;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class HomeController extends Controller
{
    public function index(){
        $all_cate_product = DB::table('cate_product')
        ->where('cate_status',1)->get();//->orderBy('cate_order','ASC')
        $all_banner = DB::table('banner')->where('banner_status',1)->get();

        $spmn = DB::table('product')
        ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->where('product_status',1)
        ->orderBy('product_id','desc')
        ->limit(8)
        ->get();

        // ---BÀN GHẾ---
        $all_bg = CategoryProductModel::where('cate_slug','ban-ghe')->get();
        // dd($all_bg);
        foreach($all_bg as $key => $value){
            $cate_id_bg = $value->cate_id;
        }
        // dd($cate_id_bg);
        $cate_bg = CategoryProductModel::where('cate_parent',$cate_id_bg)->get();
        // dd($cate_bg);
        $bg_array = array();
        foreach($cate_bg as $key => $sub){
            $bg_array[] = $sub->cate_id;
        }
        // print_r($bg_array);
        $bg = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->whereIn('cate_product_id',$bg_array)->orderBy('product_id','DESC')->limit(8)->get();
        // dd($bg);
        // ---KỆ TIVI---
        $all_ke = CategoryProductModel::where('cate_slug','ke-tivi')->get();
        
        foreach($all_ke as $key => $value_ke){
            $cate_id_ke = $value_ke->cate_id;
        }
        
        $cate_ke = CategoryProductModel::where('cate_parent',$cate_id_ke)->get();
        // dd($cate_ke);
        $ke_array = array();
        foreach($cate_ke as $key => $sub_ke){
            $ke_array[] = $sub_ke->cate_id;
        } 
        //  print_r($ke_array);
        $ketivi = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->whereIn('cate_product_id',$ke_array)->orderBy('product_id','DESC')->limit(8)->get();
        // dd($ketivi);
        return view('pages.home',compact('all_cate_product','all_banner','spmn','bg','ketivi'));
    }

    public function cartView(){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.cart.cart',compact('all_cate_product'));
    }

    public function contactView(){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.contact',compact('all_cate_product'));
    }

    public function guaranteeView(){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.guarantee',compact('all_cate_product'));
    }

    public function introView(){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.intro',compact('all_cate_product'));
    }

    public function productView(){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)
        ->get();//->orderBy('cate_order','ASC')

        // $product = DB::table('product')
        // ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        // ->where('product_status',1)->inRandomOrder()->get();
        
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by=='giam_dan'){
                $product = DB::table('product')
                            ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                            ->orderBy('product_price','DESC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='tang_dan'){
                $product = DB::table('product')
                            ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='kytu_az'){
                $product = DB::table('product')
                ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                ->orderBy('product_name','ASC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='kytu_za'){
                $product = DB::table('product')
                            ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                ->orderBy('product_name','DESC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='spmn'){
                $product = DB::table('product')
                ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                ->orderBy('product_id','DESC')->paginate(15)->appends(request()->query());
            }elseif($sort_by=='none'){
                $product = DB::table('product')
                ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                ->where('product_status',1)->inRandomOrder()->paginate(15);
            }   
        }elseif(isset($_GET['start_price']) && isset($_GET['end_price'])){
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];

            $product = DB::table('product')
                ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                ->where('product_status',1)->whereBetween('product_price',[$min_price,$max_price])
                ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
        }else{
            $product = DB::table('product')
                            ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                            ->where('product_status',1)->inRandomOrder()->paginate(15);
        }

        $wood = DB::table('wood')->where('wood_status',1)->get();
        return view('pages.product.product',compact('all_cate_product','product','wood'));
    }

    // ======QUÊN MẬT KHẨU========
    public function res_passwordView(){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.resetpassword',compact('all_cate_product'));
    }

    public function recover_pass(Request $request){
        $data = $request->all();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y');
        $title_mail = "Lấy lại mật khẩu dogoducluong.com".' '.$now; 
        $customer = Customer::where('customer_email','=',$data['email_account'])->get();
        foreach($customer as $key => $value){
            $customer_id = $value->customer_id;
        }
        if($customer){
            $count_customer = $customer->count();
            if($count_customer == 0){
                return redirect()->back()->with('error','Email này chưa được đăng kí!!');
            }else{
                $token_random = Str::random();
                $customer = Customer::find($customer_id);
                $customer->customer_token = $token_random;
                $customer->save();

                $to_email = $data['email_account'];
                $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);
                $data = array("name"=>$title_mail,"body"=>$link_reset_pass,'email'=>$data['email_account']);

                Mail::send('admin.email.reset_pass',['data'=>$data],function($message) use ($title_mail,$data){
                    $message -> to($data['email'])->subject($title_mail);
                    $message -> from($data['email'],$title_mail);
                });
                return redirect()->back()->with('success','Vui lòng kiểm tra lại email của bạn!!');
            }
        }
    }
    public function update_new_pass(Request $request){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        return view('pages.new_pass',compact('all_cate_product'));
    }

    public function reset_new_pass(Request $request){
        $data = $request->all();
        $token_random = Str::random();
        $customer = Customer::where('customer_email','=',$data['email'])
                            ->where('customer_token','=',$data['token'])->get();
        $count = $customer->count();
        if($count>0){
            foreach($customer as $key => $value){
                $customer_id = $value->customer_id;
            }
            $reset = Customer::find($customer_id);
            $reset->customer_password = md5($data['pass_account']);
            $reset->customer_token = $token_random;
            $reset->save();
            return redirect('dang-nhap')->with('success','Mật khẩu của bạn đã được cập nhật!!');
        }else{
            return redirect('tim-mat-khau')->with('error','Vui lòng nhập lại email, phiên đã hết hạn!!');
        }
    }
    
    //TÌM KIẾM
    public function search_product(Request $request){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        $wood = DB::table('wood')->where('wood_status',1)->get();

        $keywords = $request->keywords_submit;

        $search_product = DB::table('product')
        ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
        ->where('product_name','like','%'.$keywords.'%')
        ->orWhere('product_price','like','%'.$keywords.'%')
        ->get();
   
        return view('pages.product.search',compact('all_cate_product','wood','search_product'));
    }

   ///GỢI Ý TÌM KIẾM
    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['query']){
            $product = Product::where('product_status',1)
            ->where('product_name','LIKE','%'.$data['query'].'%')->get();

            $output = '<ul class="dropdown-menu" style="display:block; position:relative; width: 100%;">';
            foreach($product as $key => $value){
                $output .= '
                    <li class="li_search_ajax"> <a href="#">'.$value->product_name.'</a></li>
                ';
            }
            $output .= '</ul>';
            echo $output;
        }
   }

   //GỬI LIÊN HỆ
   public function mail_contact(Request $request){
        $data = array();
        $data['contact_name'] = $request->contact_name;
        $data['contact_email'] = $request->contact_email;
        $data['contact_phone'] = $request->contact_phone;
        $data['contact_topic'] = $request->contact_topic;
        $data['contact_content'] = $request->contact_content;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');

        Mail::send('admin.email.contact', [
            'name' => $request->contact_name,
            'content' => $request->contact_content,
        ], function ($mail) use ($request) {
            $mail->to($request->contact_email);
            $mail->from($request->contact_email);
            $mail->subject('Phản hồi');
        });

        DB::table('contact')->insert($data);
        return Redirect('/trang-chu')->with('contact_success','Cảm ơn bạn phản hồi ý kiến! Vui lòng kiểm tra lại trong Email!');
   }
}
