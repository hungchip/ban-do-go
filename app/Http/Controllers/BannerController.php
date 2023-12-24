<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
class BannerController extends Controller
{
    public function AuthLogin(){
        $admin_id =  Auth::id();
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }


    public function all_banner(){
        $this->AuthLogin();
        // $all_banner = DB::table('banner')->orderBy('banner_id','desc')->paginate(15);,compact('all_banner')
        return view('admin.banner.all_banner');
    }

    public function all_data_banner(Request $request){
        if ($request->ajax()) {
            $data = DB::table('banner')->get();
            return DataTables::of($data)
            ->addColumn('action', function ($data) {
                return '
                <a style="padding-left: 20px;" href="'.route('deleteBanner',$data->banner_id).'"
                onclick="return confirm('.''.'Xóa?'.''.')">
                
                <i class="far fa-trash-alt text-danger"></i></a>
                <a style="padding-left: 40px;" href="'.route('editBanner',$data->banner_id).'">
                    <i class="fas fa-pen-alt text-warning"></i>
                </a>
                ';
            })
            ->editColumn('banner_status',function($data){
                return $data->banner_status == 0 ? 'Ẩn' : 'Hiện';
            })
            ->editColumn('banner_image',function($data){
                return '<img src="public/upload/banner/'.$data->banner_image.'" style="width: 100px;" >';
                
            })
            ->rawColumns(['action','banner_status','banner_image'])
            ->make(true);
        }
    }
    public function add_banner(){
        $this->AuthLogin();
        return view('admin.banner.add_banner');
    }
    
    public function save_banner(Request $request){
        $this->AuthLogin();
        $data = array();
        $data['banner_status'] = $request->banner_status;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');

        $get_image = $request->file('banner_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/banner',$new_image);
            $data['banner_image'] = $new_image;
            DB::table('banner')->insert($data);
            Session::put('message','Thêm banner thành công!!');
            return Redirect::to('all-banner');
        }
        $data['banner_image'] = ' ';
        DB::table('banner')->insert($data);
        Session::put('message','Thêm banner thành công!!');
        return Redirect::to('all-banner');
    }

    public function edit_banner($banner_id){
        $this->AuthLogin();
        $edit_banner = DB::table('banner')->where('banner_id',$banner_id)->get();
        return view('admin.banner.edit_banner',compact('edit_banner'));
    }

    public function update_banner($banner_id, Request $request){
        $this->AuthLogin();
        $data = array();
        $data['banner_status'] = $request->banner_status;
        $data['created_at'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['updated_at'] = Carbon::now('Asia/Ho_Chi_Minh');

        $get_image = $request->file('banner_image');
        if($get_image){
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/upload/banner',$new_image);
            $data['banner_image'] = $new_image;
            DB::table('banner')->where('banner_id',$banner_id)->update($data);
            Session::put('message','Sửa banner thành công!!');
            return Redirect::to('all-banner');
        }
        DB::table('banner')->where('banner_id',$banner_id)->update($data);
        Session::put('message','Sửa banner thành công!!');
        return Redirect::to('all-banner');
    }

    public function delete_banner($banner_id){
        $this->AuthLogin();
        DB::table('banner')->where('banner_id',$banner_id)->delete();
        Session::put('message','Xóa banner thành công!!');
        return Redirect::to('all-banner');
    }
}
