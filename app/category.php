<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    //
    protected $fillable=['name'];


    public function Places(){

        return $this->hasMany(Place::class);
    }
}
