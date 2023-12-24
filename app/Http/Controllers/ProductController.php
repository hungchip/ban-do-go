<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportsProduct;
use App\Models\CategoryProductModel;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Wood;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
class ProductController extends Controller
{
    public function AuthLogin(){
        $admin_id =  Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function all_product(){
        $this->AuthLogin();
        // $all_product = DB::table('product')
        // ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        // ->join('wood','wood.wood_id','=','product.wood_type_id')
        // ->orderBy('product.product_id','desc')->paginate(15);,compact('all_product')
        return view('admin.product.all_product');
    }

    public function all_data_product(Request $request){
        if ($request->ajax()) {
            $data = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
            ->join('wood','wood.wood_id','=','product.wood_type_id')->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '
                <a style="padding-left: 8px;" href="'.route('deleteProduct',$data->product_id).'"
                onclick="return confirm('.''.'Xóa?'.''.')">
                    <i class="far fa-trash-alt text-danger"></i>
                </a>

                <a style="padding-left: 14px;" href="'.route('editProduct',$data->product_id).'">
                    <i class="fas fa-pen-alt text-warning"></i>
                </a>

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
            ->addColumn('add_gal', function ($data) {
               return '
               <a href="'.route('addGallery',$data->product_id).'">
                   Thêm thư viện ảnh
                </a>
               ';
            })
            ->editColumn('product_price',function($data){
                return number_format($data->product_price);
            })
            ->rawColumns(['action','product_status','product_image','add_gal'])
            ->make(true);
        }
    }

    public function add_product(){
        $this->AuthLogin();
        $cate_product = DB::table('cate_product')->orderBy('cate_id','desc')->get();
        $wood_type = DB::table('wood')->orderBy('wood_id','desc')->get();
        return view('admin.product.add_product',compact('cate_product','wood_type'));
    }
    
    public function save_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $product_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
        $data['product_name'] = $request->product_name;
        $data['product_slug'] = $request->product_slug;
        $data['product_tags'] = $request->product_tags;
        $data['product_qty'] = $request->product_qty;
        $data['product_price'] = $product_price;
        $data['product_cost'] = $product_cost;
        $data['product_content'] = $request->product_content;
        $data['product_desc'] = $request->product_desc;
        $data['cate_product_id'] = $request->product_cate;
        $data['wood_type_id'] = $request->product_wood;
        $data['product_status'] = $request->product_status;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('product')->insert($data);
            Session::put('message','Thêm sản phẩm thành công!!');
            return Redirect::to('all-product');
        }
        $data['product_image'] = ' ';
        DB::table('product')->insert($data);
        Session::put('message','Thêm sản phẩm thành công!!');
        return Redirect::to('all-product');
    }

    public function edit_product($product_id){
        $this->AuthLogin();
        $cate_product = DB::table('cate_product')->orderBy('cate_id','desc')->get();
        $wood_type = DB::table('wood')->orderBy('wood_id','desc')->get();
        $edit_product = DB::table('product')->where('product_id',$product_id)->get();
        return view('admin.product.edit_product',compact('cate_product','wood_type','edit_product'));
    }

    public function update_product($product_id, Request $request){
        $this->AuthLogin();
        $data = array();
        $product_price = filter_var($request->product_price, FILTER_SANITIZE_NUMBER_INT);
        $product_cost = filter_var($request->product_cost, FILTER_SANITIZE_NUMBER_INT);
        $data['product_name'] = $request->product_name;
        $data['product_slug'] = $request->product_slug;
        $data['product_tags'] = $request->product_tags;
        $data['product_qty'] = $request->product_qty;
        $data['product_price'] = $product_price;
        $data['product_cost'] = $product_cost;
        $data['product_content'] = $request->product_content;
        $data['product_desc'] = $request->product_desc;
        $data['cate_product_id'] = $request->product_cate;
        $data['wood_type_id'] = $request->product_wood;
        $data['product_status'] = $request->product_status;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');

        $get_image = $request->file('product_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product',$new_image);
            $data['product_image'] = $new_image;
            DB::table('product')->where('product_id',$product_id)->update($data);
            Session::put('message','Sửa sản phẩm thành công!!');
            return Redirect::to('all-product');
        }
        DB::table('product')->where('product_id',$product_id)->update($data);
        Session::put('message','Sửa sản phẩm thành công!!');
        return Redirect::to('all-product');
    }

    public function delete_product($product_id){
        $this->AuthLogin();
        DB::table('product')->where('product_id',$product_id)->delete();
        Session::put('message','Xóa sản phẩm thành công!!');
        return Redirect::to('all-product');
    }

    public function view_detail_product($product_id, Request $request){
        $model = Product::find($product_id);
        $cate = CategoryProductModel::where('cate_id' ,$model->cate_product_id)->first();
        $wood = Wood::where('wood_id' ,$model->wood_type_id)->first();
        return view('admin.product.detail_product',compact('model','cate','wood'));
    }

    public function all_comment(){
        $comment = Comment::with('product')->where('comment_parent_comment',0)->orderBy('comment_status','ASC')->paginate(15);
        $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->get();
        return view ('admin.comment.all_comment',compact('comment','comment_rep'));
    }

    public function allow_comment(Request $request){
        $data =   $request->all();
        $comment = Comment::find($data['comment_id']);
        $comment->comment_status = $data['comment_status'];
        $comment->save();
    }
    public function reply_comment(Request $request){
        $data =   $request->all();
        $comment = new Comment();
        $comment->comment = $data['comment'];
        $comment->comment_product_id = $data['comment_product_id'];
        $comment->comment_parent_comment = $data['comment_id'];
        $comment->comment_status = 1;
        $comment->comment_name = "Đồ Gỗ Đức Lương";
        $comment->save();
    }
    //END AMIN

    public function product_detailView($product_name, Request $request){
        $get_id = Product::where('product_slug',$product_name)->get();
        foreach($get_id as $key => $value){
            $product_id = $value->product_id;
        }
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();

        $product = DB::table('product')
        ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->where('product_status',1)->get();
        $wood = DB::table('wood')->where('wood_status',1)->get();
        
        $detail_product = DB::table('product')
        ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->join('wood','wood.wood_id','=','product.wood_type_id')
        ->where('product.product_id',$product_id)->get();

        foreach($detail_product as $key => $value){
            $category_id = $value->cate_product_id;
            $image_og = url('public/upload/product/'.$value->product_image);
            $url = $request->url();
        }
        $cate = CategoryProductModel::where('cate_id',$category_id)->get();
        foreach($cate as $key => $value_cate){
            $cate_parent = $value_cate->cate_parent;
        }
        // dd($cate_parent);
        $relative_product = DB::table('product')
        ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->join('wood','wood.wood_id','=','product.wood_type_id')
        // ->where('cate_product.cate_id',$category_id)
        ->orWhere('cate_product.cate_parent',$cate_parent)
        ->whereNotIn('product.product_id',[$product_id])
        ->get();
        
        $gallery = Gallery::where('product_id',$product_id)->orderBy('gallery_id','DESC')->limit(4)->get();
        $comment_count = Comment::where('comment_product_id',$product_id)
        ->where('comment_status',1)
        ->where('comment_parent_comment','=',0)->count();
        $customer_id = Session::get('customer_id');
        $customer_name = Session::get('customer_name');
        $rating = Rating::where('product_id',$product_id)->avg('rating');
        $rating = round($rating);

        //update_views
        $product = Product::where('product_id',$product_id)->first();
        $product->product_views =  $product->product_views + 1;
        $product->save();
        return view('pages.product.product-detail',
        compact('customer_name','customer_id','rating','comment_count'
        ,'all_cate_product','product','wood','detail_product','relative_product','url','gallery'));//,'image_og'
    }

    //RATING
    public function insert_rating(Request $request){
        $data = $request->all();
        $rating = new Rating();
        $rating->product_id = $data['product_id'];
        $rating->rating = $data['index'];
        $rating->save();
        echo('done');
    }
    //XUẤT EXCEL
    public function excel_product(){
        return Excel::download(new ExcelExportsProduct, 'product.xlsx');
    }

    //CKEDITOR
    public function uploads_ckeditor(Request $request){
        if($request->hasFile('upload')){
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;
            $request->file('upload')->move('public/upload/ckeditor',$fileName);
            
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('public/upload/ckeditor/'.$fileName);
            $msg = 'Tải ảnh thành công';
            $reponse = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum,'$url','$msg')</script>";
            @header('Content-type: text-html; charset=utf-8');
            echo $reponse;
        }
    }
    public function file_browser(Request $request){
        $paths = glob(public_path('upload/ckeditor/*'));
        $fileNames = array();
        foreach($paths as $path){
            array_push($fileNames,basename($path));
        }
        $data = array(
            'fileNames' => $fileNames
        );
        return view('admin.images.file_browser',compact('data','fileNames'));
    }

    ///TAGS
    public function tag(Request $request, $product_tag){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)->get();
        $wood = DB::table('wood')->where('wood_status',1)->get();
        $pro_tag = Product::where('product_status',1)
        ->where('product_name','LIKE','%'.$product_tag.'%')
        ->orWhere('product_tags','LIKE','%'.$product_tag.'%')->get();
        return view('pages.product.tag',compact('all_cate_product','wood','product_tag','pro_tag'));
    }

    //COMMENT
    public function send_comment(Request $request){
        $product_id = $request->product_id;
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment = new Comment();
        $comment->comment_product_id = $product_id;
        $comment->product_id = $product_id;
        $comment->comment = $comment_content;
        $comment->comment_name = $comment_name;
        // $comment->comment_customer_id = Session::get('customer_id');
        $data_cus = Customer::where('customer_id',Session::get('customer_id'))->get();
        foreach($data_cus as $key =>$value){
            $avatar = $value->customer_avatar;
        }
        $comment->avatar_user = $avatar;
        $comment->save();
    }

    public function load_comment(Request $request){
        $product_id = $request->product_id;
        $customer_id = Session::get('customer_id');
        $comment = Comment::where('comment_product_id',$product_id)
        ->where('comment_status',1)->where('comment_parent_comment',0)->get();
        $comment_rep = Comment::with('product')->where('comment_parent_comment','>',0)->get();
        foreach($comment as $key => $comm){
            
            $output = '
                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-2">
                        <div style="text-align: center">';
                        if (strpos($comm->avatar_user,"https://") !== false){
                            $output.='<img src="'.$comm->avatar_user.'" alt="">';
                        }
                        if (strpos($comm->avatar_user,"https://") == false){
                            $output.='<img src="/public/upload/avatar-user/'.$comm->avatar_user.'" alt="">';
                        }
                          
                        $output.='</div>
                    </div>
                    <div class="col-md-10">
                        <p style="color: green; margin: 0;">@'.$comm->comment_name.'</p>
                        <p style="color: blue; margin: 0;">@'.$comm->comment_date.'</p>
                        <p>'.$comm->comment.'</p>
                    </div>
                </div>
                ';
                foreach($comment_rep as $key => $rep_comment){
                    if($rep_comment->comment_parent_comment==$comm->comment_id){
                $output.='
                <div class="row" style="margin: 10px 40px;width: 80%;border-top: 1px solid #d5d5d5;border-bottom: 1px solid #d5d5d5;
                padding: 10px;">
                    <div class="col-md-2">
                        <div style="text-align: center">
                            <img src="/public/frontend/images/logo.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-10">
                        <p style="color: red; margin: 0;">@Đồ Gỗ Đức Lương</p>
                        <p>'.$rep_comment->comment.'</p>
                        </div>
                </div>
                ';
                    }
                }
            echo $output;
        }
    }

}