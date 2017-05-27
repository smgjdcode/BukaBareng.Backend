<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Massdrop extends Model
{
    //
    protected $fillable = ['product_id' , 'lower_bound', 'lower_price', 'quantity', 'deadline', 'product_name', 'product_img'];

//    public function transactions(){
//        return $this->belongsToMany('App\Transaction', 'id');
//    }
}
