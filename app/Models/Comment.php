<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
      public $timestamps = false;
      protected $fillable = [
            'comment_id',  'comment_name',  'comment_date',  'comment_product_id','comment','comment_parent_comment',
      ];
 
      protected $primaryKey = 'comment_id';
      protected $table = 'comment';

      public function product(){
            return $this->belongsTo('App\Models\Product','comment_product_id');
      }
}
