<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Rules\Captcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register_auth(){
        return view('admin.auth.register');
    }

    public function register(Request $request){
        // $this->validation($request);
        $messenger = [
            'admin_email.unique' => 'Email này đã được đăng kí!!',
            'admin_password.min' => 'Mật khẩu phải lớn hơn 6 kí tự!!',
        ];
        $request->validate([
            'admin_email' => 'unique:admin',
            'admin_password' => 'min:6',
            'g-recaptcha-response' => new Captcha(), 	
        ], $messenger);

        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_password = md5($data['admin_password']);
        $admin->save();
        return redirect('/register-auth')->with('message','Đăng kí thành công!');
    }

    public function login_auth(){
        return view('admin.auth.login');
    }

    public function login(Request $request){
        // $this->validate($request,[
        //     'admin_email' => 'required|email|max:255',
        //     'admin_password' => 'required|max:255',
        // ]);

        if(Auth::attempt(['admin_email'=>$request->admin_email,'admin_password'=>$request->admin_password])){
           return redirect('/dashboard');
        }else{
            return redirect('/login-auth')->with('message','Email hoặc mật khẩu không đúng');
        }
    }
    
    public function logout_auth(){
        Auth::logout();
        return redirect('/login-auth');
    }

    // public function validation($request){
    //     return $this->validate($request,[
    //         'admin_name' => 'required|max:255',
    //         'admin_email' => 'required|max:255',
    //         'admin_phone' => 'required|max:255',
    //         'admin_password' => 'required|max:255',
    //     ]);
    // }
}
