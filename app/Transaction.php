<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = ['massdrop_id' , 'user_id', 'jumlah'];
}
