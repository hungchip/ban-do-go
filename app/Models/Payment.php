<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;
    protected $fillable = [
            'payment_id',  'order_id',  'user_id',  'total_order','order_code','note','vnp_response_code','code_vnpay','code_bank','time'
    ];
 
    protected $primaryKey = 'payment_id';
    protected $table = 'payments';
}
