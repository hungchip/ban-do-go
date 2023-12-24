<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
      public $timestamps = false;
      protected $fillable = [
            'customer_id',  'customer_email',  'customer_password',  'customer_name'
            ,'customer_phone','customer_avatar'
      ];
 
      protected $primaryKey = 'customer_id';
      protected $table = 'customer';
}
