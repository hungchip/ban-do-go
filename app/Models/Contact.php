<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
      public $timestamps = false;
      protected $fillable = [
            'contact_id',  'contact_name',  'contact_email',  'contact_phone','contact_topic','contact_content'
      ];
      
      protected $primaryKey = 'contact_id';
      protected $table = 'contact';
}
