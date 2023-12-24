<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\Social;
use App\Models\SocialCustomers;
use App\Models\Customer;
use App\Models\Contact;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExcelExportsAdmin;
use App\Exports\ExcelExportsCustomer;
use App\Exports\ExcelExportsContact;
use App\Exports\ExcelExportsComment;
use Illuminate\Support\Facades\Auth;
use App\Rules\Captcha; 
use Yajra\DataTables\Facades\DataTables;
session_start();

class AdminController extends Controller
{

    public function login_google(){
        return Socialite::driver('google')->redirect();
    }

    public function callback_google(){
        $users = Socialite::driver('google')->stateless()->user(); 
        $authUser = $this->findOrCreateUser($users,'google');
        if($authUser){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('login_normal',true);
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
        }elseif($gg_account){
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('login_normal',true);
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
        }
        return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
    }

    public function findOrCreateUser($users,$provider){
        $authUser = Social::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $gg_account = new Social([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);
    
            $orang = Login::where('admin_email',$users->email)->first();
    
                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $users->name,
                        'admin_email' => $users->email,
                        'admin_password' => '',
                        'admin_phone' => '',
                    ]);
                }
            $gg_account->login()->associate($orang);
            $gg_account->save();
            return $gg_account;
        }
    }


    // LOGIN FACEBOOK ADMIN
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account!=NULL){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        }elseif($account==NULL){

            $fb_account = new Social([
                'provider_user_id' => $provider->getId(),
                'provider_user_email' => $provider->getEmail(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => '',
                ]);
            }
            $fb_account->login()->associate($orang);
            $fb_account->save();

            $account_name = Login::where('admin_id',$fb_account->user)->first();

            Session::put('admin_login',$fb_account->admin_name);
            Session::put('login_normal',true);
            Session::put('admin_id',$fb_account->admin_id);
            return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
        } 
    }

    // --------
    public function AuthLogin(){
        if(Session::get('login_normal')){
            $admin_id = Session::get('admin_id');
        }else{
            $admin_id = Auth::id();
        }
        if($admin_id){
            return Redirect::to('/dashboard');
        }else{
            return Redirect::to('/admin')->send();
        }
    }
    
    public function index(){
        return view('admin.auth.login');
    }

    public function show_dashboard(){
        $this->AuthLogin();
        return view('admin.index');
    }
     //show customer
     public function show_customer(){
        $this->AuthLogin();
        // $show_cus = DB::table('customer')->orderBy('customer_id','desc')->paginate(15);
        return view('admin.customer.show_customer');//,compact('show_cus')
    }

    public function all_customer(){
        // $customer = Customer::select(['customer_id','customer_name','customer_email','created_at']);

        // return DataTables::of($customer)->make();
        return DataTables::of(Customer::query())->make(true);
    }

    //show contact
    public function all_contact(){
        $this->AuthLogin();
        // $all_contact = DB::table('contact')->orderBy('contact_id','desc')->paginate(15);,compact('all_contact')
        return view('admin.contact.all_contact');
    }
    
    public function data_contact(){
        return DataTables::of(Contact::query())->make(true);
    }

     //XUẤT EXCEL
    public function excel_admin(){
        return Excel::download(new ExcelExportsAdmin, 'admin.xlsx');
    }

    public function excel_customer(){
        return Excel::download(new ExcelExportsCustomer, 'customer.xlsx');
    }

    public function excel_contact(){
        return Excel::download(new ExcelExportsContact, 'contact.xlsx');
    }
    public function excel_comment(){
        return Excel::download(new ExcelExportsComment, 'comment.xlsx'); 
    }

    ///LOGIN CUSTOMER GOOGLE
    public function login_customer_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google')->redirect();
    }

    public function callback_customer_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);

        $users = Socialite::driver('google')->stateless()->user(); 
        $authUser = $this->findOrCreateCustomer($users,'google');
        if($authUser){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            // Session::put('login_normal',true);
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_name',$account_name->customer_name);
            Session::put('customer_avatar',$account_name->customer_avatar);
        }elseif($customer_new){
            $account_name = Customer::where('customer_id',$authUser->user)->first();
            Session::put('customer_id',$account_name->customer_id);
            Session::put('customer_name',$account_name->customer_name);
            Session::put('customer_avatar',$account_name->customer_avatar);
        }
        return redirect('/dang-nhap')->with('message', 'Đăng nhập tài khoản google ' .$account_name->customer_email.' thành công');

    }

    public function findOrCreateCustomer($users,$provider){
        $authUser = SocialCustomers::where('provider_user_id', $users->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $customer_new = new SocialCustomers([
                'provider_user_id' => $users->id,
                'provider_user_email' => $users->email,
                'provider' => strtoupper($provider)
            ]);
    
            $customer = Customer::where('customer_email',$users->email)->first();
    
                if(!$customer){
                    $customer = Customer::create([
                        'customer_name' => $users->name,
                        'customer_email' => $users->email,
                        'customer_avatar' => $users->avatar,
                        'customer_password' => '',
                        'customer_phone' => ''
                    ]);
                }
            $customer_new->customer()->associate($customer);
            $customer_new->save();
            return $customer_new;
        }
    }


      ///LOGIN CUSTOMER FACEBOOK
      public function login_customer_facebook(){
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_customer_facebook(){
        config(['services.facebook.redirect' => env('FACEBOOK_CLIENT_REDIRECT')]);

        $provider = Socialite::driver('facebook')->user();
        $account = SocialCustomers::where('provider','facebook')
                        ->where('provider_user_id',$provider->getId())->first();
        if($account!=NULL){
            //login
            $account_name = Customer::where('customer_id',$account->user)->first();
            Session::put('customer_name',$account_name->customer_name);
            Session::put('customer_id',$account_name->customer_id);
            return redirect('/dang-nhap')->with('message', 'Đăng nhập tài khoản facebook ' .$account_name->customer_email.' thành công');
        }elseif($account==NULL){

            $fb_account = new SocialCustomers([
                'provider_user_id' => $provider->getId(),
                'provider_user_email' => $provider->getEmail(),
                'provider' => 'facebook'
            ]);

            $customer = Customer::where('customer_email',$provider->getEmail())->first();

            if(!$customer){
                $customer = Customer::create([
                    'customer_name' => $provider->getName(),
                    'customer_email' => $provider->getEmail(),
                    'customer_password' => '',
                    'customer_phone' => '',
                ]);
            }
            $fb_account->customer()->associate($customer);
            $fb_account->save();

            $account_name = Customer::where('customer_id',$fb_account->user)->first();

            Session::put('customer_id',$fb_account->customer_id);
            Session::put('customer_name',$fb_account->customer_name);

            return redirect('/dang-nhap')->with('message', 'Đăng nhập tài khoản facebook ' .$account_name->customer_email.' thành công');
        } 
    }
}