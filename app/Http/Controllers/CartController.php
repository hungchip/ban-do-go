<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{
    public function save_cart(Request $request){
        $productId = $request->productid_hidden;
        $qty = $request->qty;
        $product_info = DB::table('product')->where('product_id',$productId)->first();
        // foreach($product_info as $key => $value_pro){
            $pro_qty = $product_info->product_qty;
        // }
        // dd($pro);   
        if($pro_qty < $qty){
            return redirect()->back()->with('danger',' Số lượng hàng có sẵn không đủ, vui lòng liên hệ cửa hàng');
        }else{
            Cart::add([
                'id' => $product_info->product_id,
                'name' => $product_info->product_name,
                'qty' => $qty,
                'weight' => '12',
                'price' => $product_info->product_price,
                'options' => ['image' => $product_info->product_image]
            ]);
    
            return redirect()->back()->with('success', ' Đã thêm vào giỏ hàng!');
        }
        
    }

    public function delete_cart($rowId){
        Cart::update($rowId,0);
        return Redirect::to('gio-hang')->with('success', ' Đã xóa sản phẩm!');
    }

    public function update_cart(Request $request)
    {
        $data = $request->qty_update;

        foreach ($data as $rowId => $qty) {
            Cart::update($rowId, $qty);
        }
        return Redirect::to('gio-hang')->with('success', ' Đã cập nhật giỏ hàng!');
    }
}
