<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wood extends Model
{
    public $timestamps = false;
    protected $fillable = [
          'wood_id',  'wood_name',  'wood_desc',  'wood_status'
    ];
 
    protected $primaryKey = 'wood_id';
      protected $table = 'wood';
}
