<?php

namespace App\Http\Controllers;

use App\Exports\ExcelExportsCateProduct;
use App\Models\CategoryProductModel;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id =  Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }

    public function all_cate_product(){
        $this->AuthLogin();
        // $category = CategoryProductModel::where('cate_parent',0)->orderBy('cate_id','DESC')->get();
        // $all_cate_product = DB::table('cate_product')->orderBy('cate_order','ASC')->paginate(15);
        return view('admin.category_product.all_cate_product');
    }
    public function all_data_cate_product(Request $request)
    {
        
        // return DataTables::of(CategoryProductModel::query())->make(true);
        if ($request->ajax()) {
            $data = CategoryProductModel::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '
                <a style="padding-left: 20px;" href="'.route('deleteCate',$data->cate_id).'"
                onclick="return confirm('.''.'Xóa?'.''.')">
                
                <i class="far fa-trash-alt text-danger"></i></a>
                <a style="padding-left: 40px;" href="'.route('editCate',$data->cate_id).'">
                    <i class="fas fa-pen-alt text-warning"></i>
                </a>
                
                ';
            })->editColumn('cate_status',function($data){
                return $data->cate_status == 0 ? 'Ẩn' : 'Hiện';
            })
            ->rawColumns(['action','cate_status'])
            ->make(true);
        }
    }
    public function add_cate_product(){
        $this->AuthLogin();
        $category = CategoryProductModel::where('cate_parent',0)->orderBy('cate_id','DESC')->get();
        return view('admin.category_product.add_cate_product',compact('category'));
    }
    
    public function save_cate_product(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['cate_name'] = $request->cate_name;
        $data['cate_slug'] = $request->cate_slug;
        $data['cate_parent'] = $request->cate_parent;
        $data['cate_desc'] = $request->cate_desc;
        $data['cate_status'] = $request->cate_status;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('cate_product')->insert($data);
        Session::put('message','Thêm danh mục thành công!!');
        return Redirect::to('all-cate-product');
    }

    public function edit_cate_product($cate_id){
        $this->AuthLogin();
        $category = CategoryProductModel::orderBy('cate_id','DESC')->get();
        // dd($category);
        $edit_cate_product = DB::table('cate_product')->where('cate_id',$cate_id)->get();
        return view('admin.category_product.edit_cate_product',compact('edit_cate_product','category'));
    }

    public function update_cate_product($cate_pro_id, Request $request){
        $this->AuthLogin();
        $data = array();
        $data['cate_name'] = $request->cate_name;
        $data['cate_slug'] = $request->cate_slug;
        $data['cate_parent'] = $request->cate_parent;
        $data['cate_desc'] = $request->cate_desc;
        $data['cate_status'] = $request->cate_status;
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('cate_product')->where('cate_id',$cate_pro_id)->update($data);
        Session::put('message','Sửa danh mục thành công!!');
        return Redirect::to('all-cate-product');
    }

    public function delete_cate_product($cate_pro_id){
        $this->AuthLogin();
        DB::table('cate_product')->where('cate_id',$cate_pro_id)->delete();
        Session::put('message','Xóa danh mục thành công!!');
        return Redirect::to('all-cate-product');
    }

    // public function arrange_category(Request $request){
    //     $this->AuthLogin();
    //     $data = $request->all();
    //     $cate_id = $data['page_id_array'];
    //     foreach($cate_id as $key => $value){
    //         $category = CategoryProductModel::find($value);
    //         $category->cate_order = $key;
    //         $category->save();
    //     }
    //     echo ('Sắp xếp thành công!');
    // }

    //End ADMIN

    public function show_category($cate_name, Request $request){
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)
        ->get();//->orderBy('cate_order','ASC')
        $wood = DB::table('wood')->where('wood_status',1)->get();

        $cate = CategoryProductModel::where('cate_slug',$cate_name)->get();
       
        foreach($cate as $key => $value){
            $cate_id = $value->cate_id;
        }

        $sub_cate = CategoryProductModel::where('cate_parent',$cate_id)->get();
      
        $sub_array = array();
        foreach($sub_cate as $key => $sub){
            $sub_array[] = $sub->cate_id;
        }
       
   
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by=='giam_dan'){
                $cate_by_id = DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                    ->where('product.cate_product_id',$cate_id)
                                    ->orderBy('product_price','DESC')->paginate(15)->appends(request()->query());
                $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                    ->whereIn('cate_product_id',$sub_array)
                                    ->orderBy('product_price','DESC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='tang_dan'){
                $cate_by_id =DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.cate_product_id',$cate_id)
                                ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
                $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                    ->whereIn('cate_product_id',$sub_array)
                                    ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='kytu_az'){
                $cate_by_id = DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                 ->where('product.cate_product_id',$cate_id)
                                 ->orderBy('product_name','ASC')->paginate(15)->appends(request()->query());
                $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                    ->whereIn('cate_product_id',$sub_array)
                                    ->orderBy('product_name','ASC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='kytu_za'){
                $cate_by_id = DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                    ->where('product.cate_product_id',$cate_id)
                                    ->orderBy('product_name','DESC')->paginate(15)->appends(request()->query());
                $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                    ->whereIn('cate_product_id',$sub_array)
                                    ->orderBy('product_name','DESC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='spmn'){
                $cate_by_id =DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.cate_product_id',$cate_id)
                                ->orderBy('product_id','DESC')->paginate(15)->appends(request()->query());
                $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                    ->whereIn('cate_product_id',$sub_array)
                                    ->orderBy('product_id','DESC')->paginate(15)->appends(request()->query());
            }elseif($sort_by=='none'){
                $cate_by_id = DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                ->where('product.cate_product_id',$cate_id)->inRandomOrder()->paginate(15);
                $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                ->whereIn('cate_product_id',$sub_array)
                                ->inRandomOrder()->paginate(15);
            }  
        }elseif(isset($_GET['start_price']) && isset($_GET['end_price'])){
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];
            $cate_by_id = DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                            ->where('product.cate_product_id',$cate_id)
                            ->where('product_status',1)->whereBetween('product_price',[$min_price,$max_price])
                            ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
            $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                            ->whereIn('cate_product_id',$sub_array) ->where('product_status',1)->whereBetween('product_price',[$min_price,$max_price])
                            ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
        }else{
            $cate_by_id = DB::table('product')->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.cate_product_id',$cate_id)->inRandomOrder()->paginate(15);
            $product = Product::join('cate_product','cate_product.cate_id','=','product.cate_product_id')
                                ->whereIn('cate_product_id',$sub_array)
                                ->inRandomOrder()->paginate(15);
        }
        // $cate_by_id = DB::table('product')
        //  ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
        // ->where('product.cate_product_id',$cate_id)->get();
        
        $cate_name = DB::table('cate_product')->where('cate_product.cate_id',$cate_id)->limit(1)->get();
        return view('pages.category.show_category',compact('product','wood','all_cate_product','cate_by_id','cate_name'));
    }

    //XUẤT EXCEL
    public function excel_cate_product(){
        return Excel::download(new ExcelExportsCateProduct, 'cate_product.xlsx');
    }

}