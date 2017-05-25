<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Massdrop extends Model
{
    //
    protected $fillable = ['product_id' , 'lower_bound', 'lower_price', 'quantity', 'deadline'];
}
