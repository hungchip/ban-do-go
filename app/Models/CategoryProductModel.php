<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProductModel extends Model
{
      public $timestamps = false;
      protected $fillable = [
            'cate_id',  'cate_name',  'cate_desc',  'cate_status','cate_parent','cate_slug'
      ];
 
      protected $primaryKey = 'cate_id';
      protected $table = 'cate_product';
      public function product(){
            return $this->hasMany('App\Models\Product');
      }
}
