<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
      public $timestamps = false;
      protected $fillable = [
            'product_id',  'cate_product_id',  'wood_type_id',  'product_name','product_group',
            'product_desc','product_content','product_price','product_cost','product_image',
            'product_status','product_tags','product_view'
      ];
 
      protected $primaryKey = 'product_id';
      protected $table = 'product';
      public function product(){
            return $this->hasMany('App\Models\Product');
      }
      public function comment(){
            return $this->hasMany('App\Models\Comment');
      }

      public function category(){
            return $this->belongsTo('App\Models\CategoryProductModel','cate_id');
      }
}