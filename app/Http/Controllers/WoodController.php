<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportsWood;
use App\Models\Wood;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class WoodController extends Controller
{
    public function AuthLogin(){
        $admin_id =  Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }


    public function all_wood_type(){
        $this->AuthLogin();
        // $all_wood_type = DB::table('wood')->orderBy('wood_id','desc')->paginate(15);
        return view('admin.wood_type.all_wood_type');//,compact('all_wood_type')
    }

    public function all_wood(Request $request){
        if ($request->ajax()) {
            $data = Wood::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '
                <a style="padding-left: 20px;" href="'.route('deleteWood',$data->wood_id).'"
                onclick="return confirm('.''.'Xóa?'.''.')">
                
                <i class="far fa-trash-alt text-danger"></i></a>
                <a style="padding-left: 40px;" href="'.route('editWood',$data->wood_id).'">
                    <i class="fas fa-pen-alt text-warning"></i>
                </a>
                
                ';
            })->editColumn('wood_status',function($data){
                return $data->wood_status == 0 ? 'Ẩn' : 'Hiện';
            })
            ->rawColumns(['action','wood_status'])
            ->make(true);
        }
    }
    public function add_wood_type(){
        $this->AuthLogin();
        return view('admin.wood_type.add_wood_type');
    }
    
    public function save_wood_type(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['wood_name'] = $request->wood_name;
        $data['wood_slug'] = $request->wood_slug;
        $data['wood_desc'] = $request->wood_desc;
        $data['wood_status'] = $request->wood_status;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('wood')->insert($data);
        Session::put('message','Thêm loại gỗ thành công!!');
        return Redirect::to('all-wood-type');
    }

    public function edit_wood_type($woodtype_id){
        $this->AuthLogin();
        $edit_wood_type = DB::table('wood')->where('wood_id',$woodtype_id)->get();
        return view('admin.wood_type.edit_wood_type',compact('edit_wood_type'));
    }

    public function update_wood_type($woodtype_id, Request $request){
        $this->AuthLogin();
        $data = array();
        $data['wood_name'] = $request->wood_name;
        $data['wood_slug'] = $request->wood_slug;
        $data['wood_desc'] = $request->wood_desc;
        $data['wood_status'] = $request->wood_status;
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        DB::table('wood')->where('wood_id',$woodtype_id)->update($data);
        Session::put('message','Sửa loại gỗ thành công!!');
        return Redirect::to('all-wood-type');
    }

    public function delete_wood_type($woodtype_id){
        $this->AuthLogin();
        DB::table('wood')->where('wood_id',$woodtype_id)->delete();
        Session::put('message','Xóa loại gỗ thành công!!');
        return Redirect::to('all-wood-type');
    }

    //End ADMIN

    public function show_wood($wood_name,Request $request){
        $get_id = Wood::where('wood_slug',$wood_name)->get();
        foreach($get_id as $key => $value){
            $wood_id = $value->wood_id;
        }
        $all_cate_product = DB::table('cate_product')->where('cate_status',1)
       ->get(); //->orderBy('cate_order','ASC')
        $product = DB::table('product')
        ->join('cate_product','cate_product.cate_id','=','product.cate_product_id')
        ->where('product_status',1)->get();
        $wood = DB::table('wood')->where('wood_status',1)->get();

        // $wood_by_id = DB::table('product')
        // ->join('wood','product.wood_type_id','=','wood.wood_id')
        // ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
        // ->where('product.wood_type_id',$wood_id)
        // ->get();
        if(isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if($sort_by=='giam_dan'){
                $wood_by_id = DB::table('product')
                                ->join('wood','product.wood_type_id','=','wood.wood_id')
                                ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.wood_type_id',$wood_id)
                                ->orderBy('product_price','DESC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='tang_dan'){
                $wood_by_id = DB::table('product')
                                ->join('wood','product.wood_type_id','=','wood.wood_id')
                                ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.wood_type_id',$wood_id)
                                ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='kytu_az'){
                $wood_by_id = DB::table('product')
                                ->join('wood','product.wood_type_id','=','wood.wood_id')
                                ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.wood_type_id',$wood_id)
                                ->orderBy('product_name','ASC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='kytu_za'){
                $wood_by_id = DB::table('product')
                                ->join('wood','product.wood_type_id','=','wood.wood_id')
                                ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.wood_type_id',$wood_id)
                                ->orderBy('product_name','DESC')->paginate(15)->appends(request()->query());
            }    
            elseif($sort_by=='spmn'){
                $wood_by_id = DB::table('product')
                                ->join('wood','product.wood_type_id','=','wood.wood_id')
                                ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                                ->where('product.wood_type_id',$wood_id)
                                ->orderBy('product_id','DESC')->paginate(15)->appends(request()->query());
            }elseif($sort_by=='none'){
                $wood_by_id = DB::table('product')
                ->join('wood','product.wood_type_id','=','wood.wood_id')
                ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                ->where('product.wood_type_id',$wood_id)
                ->inRandomOrder()->paginate(15);
            } 
        }elseif(isset($_GET['start_price']) && isset($_GET['end_price'])){
            $min_price = $_GET['start_price'];
            $max_price = $_GET['end_price'];
            $wood_by_id = DB::table('product')
            ->join('wood','product.wood_type_id','=','wood.wood_id')
            ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
            ->where('product.wood_type_id',$wood_id)  ->where('product_status',1)->whereBetween('product_price',[$min_price,$max_price])
            ->orderBy('product_price','ASC')->paginate(15)->appends(request()->query());
           
        }else{
            $wood_by_id = DB::table('product')
                            ->join('wood','product.wood_type_id','=','wood.wood_id')
                            ->join('cate_product','product.cate_product_id','=','cate_product.cate_id')
                            ->where('product.wood_type_id',$wood_id)
                            ->inRandomOrder()->paginate(15);
        }
        $wood_name = DB::table('wood')->where('wood.wood_id',$wood_id)->limit(1)->get();
        return view('pages.wood.show_wood',compact('product','wood','all_cate_product','wood_by_id','wood_name'));
    }

      //XUẤT EXCEL
      public function excel_wood(){
        return Excel::download(new ExcelExportsWood, 'wood.xlsx');
    }
}
