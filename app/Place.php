<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    //
    protected $fillable=['name','logo','cover','open','close','cate_id'];
    public function Ratings(){

        return $this->hasMany(Rating::class);
    }
    public function Category(){

        return $this->belongsTo(category::class,'cate_id','id');
    }
}
