<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    //
    protected $fillable = ['massdrop_id' , 'user_id', 'jumlah', 'status' , 'product_id', 'bought_time'];
}
