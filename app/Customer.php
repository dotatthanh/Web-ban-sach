<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    	'name',
    	'email',
    	'phone',
    	'address'
    ];

    public function orders(){
    	return $this->hasMany(Order::class);
    }

    public function type(){
    	return $this->belongTo(Type::class);
    }
}
