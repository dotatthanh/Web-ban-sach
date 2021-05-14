<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    	'user_id',
        'book_id',
    	'customer_id',
    	'price',
        'status',
        'payment_method',
    	'amount'
    ];

    public function customer(){
    	return $this->belongsTo(Customer::class);
    }
    public function book(){
    	return $this->belongsTo(Book::class);
    }
    
}
