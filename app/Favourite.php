<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    //
    protected $fillable=['user_id','place_id'];


    public function User(){
        return $this->belongsTo(User::class);
    }
    public function Place(){
        return $this->belongsTo(Place::class);
    }

}
