<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'order_detail_id',  'order_id',  'product_id',  'product_name','product_price','product_qty'
    ];
    
    protected $primaryKey = 'order_detail_id';
    protected $table = 'order_detail';

    public function products(){
        return $this->belongsTo(Product::class,'product_id');
    }
}
