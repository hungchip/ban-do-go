<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
      public $timestamps = false;
      protected $fillable = [
            'order_id',  'shipping_id',  'customer_id',  'order_total','order_status','order_date','order_reason'
      ];
      
      protected $primaryKey = 'order_id';
      protected $table = 'order';
}
