<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
class UserController extends Controller
{
    public function index(){
        $admin = Admin::with('roles')->orderBy('admin_id','ASC')->paginate(15);
        return view('admin.user.all_user',compact('admin'));
    }

    // public function all_admin(Request $request){
    //     if ($request->ajax()) {
    //         $data = Admin::get();
    //         return DataTables::of($data)
    //         ->addColumn('action', function ($data) {
    //             return '
    //             <a style="padding-left: 20px;" href="'.route('deleteAdmin',$data->admin_id).'"
    //                 onclick="return confirm('.''.'Xóa?'.''.')">
    //                 <i class="far fa-trash-alt text-danger"></i>
    //             </a>
    //             <a  style="padding-left: 40px;"  href="'.route('impersonate',$data->admin_id).'">
    //                 Chuyển user
    //             </a>
                
    //             ';
    //         })
    //         ->editColumn('Author',function($data){
    //             // return '<input type="checkbox" name="author_role"
    //             //     {{$data->hasRole('.'author'.') ? '.'checked'.' : '.' '.'}}>
    //             // ';
    //             return $data->hasRole('author') ? '<input type="checkbox" name="author_role" checked>' : '<input type="checkbox" name="author_role">';
    //         })
    //         ->editColumn('Admin',function($data){
    //             return $data->hasRole('admin') ? '<input type="checkbox" name="admin_role" checked>' : '<input type="checkbox" name="admin_role">';
    //         })
    //         ->editColumn('User',function($data){
    //             return $data->hasRole('user') ? '<input type="checkbox" name="user_role" checked>' : '<input type="checkbox" name="user_role">';
    //         })
    //         ->rawColumns(['action','Author','Admin','User'])
    //         ->make(true);
    //     }
    // }

    public function add_user(){
        return view('admin.user.add_user');
    }

    public function save_user(Request $request){
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->admin_phone = $data['admin_phone'];
        $admin->save();
        $admin->roles()->attach(Roles::where('name','user')->first());
        Session::put('message','Thêm thành công!!');
        return Redirect::to('all-user');
    }

    public function delete_user($admin_id){
        if(Auth::id() == $admin_id){
            return redirect()->back()->with('message','Bạn không thể xóa chính mình!');
        }
        $admin = Admin::find($admin_id);

        if($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Xóa thành công!');
    }
    public function assign_roles(Request $request){
        $admin_id = $request->admin_id;
        if(Auth::id() == $admin_id){
            return redirect()->back()->with('message','Bạn không thể phần quyền chính mình!');
        }

        $user = Admin::where('admin_email',$request->admin_email)->first();
        $user->roles()->detach();
        
        if($request->author_role){
            $user->roles()->attach(Roles::where('name','author')->first());
        }
        if($request->user_role){
            $user->roles()->attach(Roles::where('name','user')->first());
        }
        if($request->admin_role){
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        return redirect()->back()->with('message','Cấp quyền thành công');
    }

    public function impersonate($admin_id){
        $user = Admin::where('admin_id',$admin_id)->first();
        if($user){
            session()->put('impersonate',$user->admin_id);
        }
        return Redirect::to('all-user');
    }
    public function impersonate_destroy(){
        session()->forget('impersonate');
        return redirect('all-user');
    }

    public function change_password(){
        return view('admin.auth.changePassword');
    }

    public function update_admin_password(Request $request){
        if(Session::get('login_normal')){
            $admin_id = Session::get('admin_id');
        }else{
            $admin_id = Auth::user()->admin_id;
        }
        // print_r($admin_id);
        $all_data = Admin::where('admin_id',$admin_id)->get();
        foreach($all_data as $key => $value){
            $password = $value->admin_password;
        }
        // dd($password);
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
            $admin = Admin::find($admin_id);
            $admin->admin_password = md5($new_pass);
            $admin->save();
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
}
