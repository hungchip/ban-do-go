<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//GIAO DIỆN TRANG MUA HÀNG
Route::get('/', 'HomeController@index');
Route::post('/tim-kiem', 'HomeController@search_product');
Route::post('/autocomplete-ajax','HomeController@autocomplete_ajax');
Route::get('/trang-chu', 'HomeController@index');
Route::get('/gio-hang', 'HomeController@cartView');
Route::get('/bao-hanh', 'HomeController@guaranteeView');
Route::get('/gioi-thieu', 'HomeController@introView');
Route::get('/lien-he', 'HomeController@contactView');
Route::get('/san-pham', 'HomeController@productView');

// ===TÌM MẬT KHẨU===
Route::get('/tim-mat-khau', 'HomeController@res_passwordView');
Route::get('/update-new-pass', 'HomeController@update_new_pass');
Route::post('/recover-pass', 'HomeController@recover_pass');
Route::post('/reset-new-pass', 'HomeController@reset_new_pass');

// ====DANH MỤC
Route::get('/add-cate-product','CategoryProduct@add_cate_product');
Route::get('/edit-cate-product/{cate_id}','CategoryProduct@edit_cate_product')->name('editCate');
Route::get('/delete-cate-product/{cate_pro_id}','CategoryProduct@delete_cate_product')->name('deleteCate');
Route::get('/all-cate-product','CategoryProduct@all_cate_product');
Route::get('/categories','CategoryProduct@all_data_cate_product');
Route::post('/save-cate-product','CategoryProduct@save_cate_product');
Route::post('/update-cate-product/{cate_pro_id}','CategoryProduct@update_cate_product');
//XUẤT EXCEL
Route::post('/excel-cate-product','CategoryProduct@excel_cate_product');

// ====LOẠI GỖ
Route::get('/add-wood-type','WoodController@add_wood_type');
Route::get('/edit-wood-type/{woodtype_id}','WoodController@edit_wood_type')->name('editWood');
Route::get('/delete-wood-type/{woodtype_id}','WoodController@delete_wood_type')->name('deleteWood');
Route::get('/all-wood-type','WoodController@all_wood_type');
Route::post('/save-wood-type','WoodController@save_wood_type');
Route::post('/update-wood-type/{woodtype_id}','WoodController@update_wood_type');
Route::post('/excel-wood','WoodController@excel_wood');
Route::get('/woods','WoodController@all_wood');

// ====SẢN PHẨM
Route::get('/view-detail-product/{product_id}','ProductController@view_detail_product')->name('viewProduct');
Route::get('/add-product','ProductController@add_product');
Route::get('/edit-product/{product_id}','ProductController@edit_product')->name('editProduct');
Route::get('/delete-product/{product_id}','ProductController@delete_product')->name('deleteProduct');
Route::get('/all-product','ProductController@all_product');
Route::post('/save-product','ProductController@save_product');
Route::post('/update-product/{product_id}','ProductController@update_product');
Route::post('/excel-product','ProductController@excel_product');
Route::get('/tag/{product_tag}','ProductController@tag');
Route::get('/products','ProductController@all_data_product');

//THƯ VIỆN HÌNH ẢNH
Route::get('add-gallery/{product_id}','GalleryController@add_gallery')->name('addGallery');
Route::post('select-gallery','GalleryController@select_gallery');
Route::post('insert-gallery/{pro_id}','GalleryController@insert_gallery');
Route::post('update-gallery-name','GalleryController@update_gallery_name');
Route::post('delete-gallery','GalleryController@delete_gallery');
Route::post('update-gallery','GalleryController@update_gallery');

//CKEDITOR
Route::get('/file-browser','ProductController@file_browser');
Route::post('/uploads-ckeditor','ProductController@uploads_ckeditor');

///COMMENT
Route::post('/load-comment','ProductController@load_comment');
Route::post('/send-comment','ProductController@send_comment');
Route::get('/all-comment','ProductController@all_comment');
Route::post('/allow-comment','ProductController@allow_comment');
Route::post('/reply-comment','ProductController@reply_comment');
Route::post('/insert-rating','ProductController@insert_rating');
Route::post('/excel-comment','AdminController@excel_comment');

Route::group(['middleware' => 'auth.roles'],function(){
    //QUẢN LÍ ĐƠN HÀNG
    Route::get('/all-order','OrderController@all_order');
    Route::get('/orders','OrderController@all_data_order');
    Route::get('/filter-order','OrderController@filter_order');
    Route::get('/view-filter-order','OrderController@view_filter_order');
    Route::get('/view-order/{order_id}','OrderController@view_order')->name('viewOrder');
    Route::get('/edit-status/{order_id}','OrderController@edit_status')->name('editStatus');
    Route::post('/excel-order','OrderController@excel_order');
    Route::post('/update-status/{order_id}','OrderController@update_status');
    //IN PDF ĐƠN HÀNG
    Route::get('/print-pdf/{order_id}','OrderController@print_pdf');

    //SHOW CUSTOMER
    Route::get('/show-customer','AdminController@show_customer');
    Route::post('/excel-customer','AdminController@excel_customer');
    Route::get('/all_customers','AdminController@all_customer');

    //LIÊN HỆ
    Route::get('/all-contact','AdminController@all_contact');
    Route::post('/excel-contact','AdminController@excel_contact');
    Route::get('/contacts','AdminController@data_contact');

    //THỐNG KÊ
    Route::get('/hang-co-san','StatisticalController@hang_co_san');
    Route::get('/available','StatisticalController@data_hang_co_san');
    Route::post('/excel-hang-co-san','StatisticalController@excel_hang_co_san');

    //ADMIN
    Route::get('/all-user','UserController@index');
    Route::get('/admins','UserController@all_admin');
    Route::get('/add-user','UserController@add_user');
    Route::post('/save-user','UserController@save_user');
    Route::get('/delete-user/{admin_id}','UserController@delete_user');
    Route::post('/assign-roles','UserController@assign_roles');
    Route::get('/impersonate/{admin_id}','UserController@impersonate');
    Route::post('/excel-admin','AdminController@excel_admin');

});
//DỪNG CHUYỂN QUYỀN
Route::get('/impersonate-destroy','UserController@impersonate_destroy');

//ĐỔI MẬT KHẨU ADMIN
Route::get('/doi-mat-khau','UserController@change_password');
Route::get('/update-admin-password','UserController@update_admin_password');

//DANH MỤC SẢN PHẨM
Route::get('/danh-muc-san-pham/{cate_name}', 'CategoryProduct@show_category');

//CHI TIẾT SẢN PHẢM
Route::get('/chi-tiet-san-pham/{product_name}', 'ProductController@product_detailView');

//LOẠI GỖ
Route::get('/loai-san-pham/{wood_name}', 'WoodController@show_wood');

//GIAO DIỆN TRANG ADMIN
Route::get('/admin', 'AdminController@index');
Route::get('/dashboard','AdminController@show_dashboard');

//LOGIN FACEBOOK ADMIN      
Route::get('/login-facebook','AdminController@login_facebook');
Route::get('/callback/facebook','AdminController@callback_facebook');
//LOGIN FACEBOOK CUSTOMER
Route::get('/login-customer-facebook','AdminController@login_customer_facebook');
Route::get('/customer/callback/facebook','AdminController@callback_customer_facebook');

//LOGIN GOOGLE ADMIN
Route::get('/login-google','AdminController@login_google');
Route::get('/callback/google','AdminController@callback_google');
//LOGIN GOOGLE CUSTOMER
Route::get('/login-customer-google','AdminController@login_customer_google');
Route::get('/customer/callback/google','AdminController@callback_customer_google');

//THỐNG KÊ
Route::get('/statistical','StatisticalController@statistical');
Route::post('/filter-by-date','StatisticalController@filter_by_date');
Route::post('/dashboard-filter','StatisticalController@dashboard_filter');
Route::post('/days-order','StatisticalController@days_order');

//CART
Route::get('/save-cart','CartController@save_cart');
Route::post('/save-cart','CartController@save_cart');
Route::post('/update-cart','CartController@update_cart');
Route::get('/delete-cart/{rowId}','CartController@delete_cart');

//THANH TOÁN
Route::get('/dang-nhap','CheckoutController@login_checkout');
Route::get('/logout-checkout','CheckoutController@logout_checkout');
Route::post('/add-customer','CheckoutController@add_customer');
Route::get('/thanh-toan','CheckoutController@checkout');
Route::post('/save-checkout','CheckoutController@save_checkout');
Route::post('/login-customer','CheckoutController@login_customer');
//THANH TOÁN ONLINE
Route::post('/payment-online','CheckoutController@payment_online')->name('payment.online');
Route::get('/vnpay/return','CheckoutController@vnpay_return')->name('vnpay.return');

//BANNER
Route::get('/add-banner','BannerController@add_banner');
Route::get('/edit-banner/{banner_id}','BannerController@edit_banner')->name('editBanner');
Route::get('/delete-banner/{banner_id}','BannerController@delete_banner')->name('deleteBanner');
Route::post('/save-banner','BannerController@save_banner');
Route::post('/update-banner/{banner_id}','BannerController@update_banner');
Route::get('/all-banner','BannerController@all_banner');
Route::get('/banners','BannerController@all_data_banner');

//MAIL LIÊN HỆ
Route::post('/mail-contact','HomeController@mail_contact');

//Đăng nhập
Route::get('/register-auth','AuthController@register_auth');
Route::post('/register','AuthController@register');
Route::get('/login-auth','AuthController@login_auth');
Route::post('/login','AuthController@login');
Route::get('/logout-auth','AuthController@logout_auth');

//CUSTOMER
    //Thông tin cá nhân
    Route::get('/thong-tin-ca-nhan','CustomerController@edit_info');
    Route::post('/update-info','CustomerController@update_info');
    //Thay đổi mật khẩu
    Route::get('/thay-doi-mat-khau','CustomerController@edit_password');
    Route::post('/update-password','CustomerController@update_password');
    //Lịch sử mua hàng
    Route::get('/lich-su-mua-hang','CustomerController@history');
    Route::get('/view/{id}', 'CustomerController@viewOrder')->name('viewOrderCustomer');
    //Hủy đơn hàng
    Route::POST('/huy-don-hang', 'CustomerController@cancel_order');
    //Xác nhận đơn hàng
    Route::POST('/xac-nhan-don', 'CustomerController@apply_order');
  
