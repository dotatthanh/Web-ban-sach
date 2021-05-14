<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookSupplier extends Model
{
    protected $table = 'book_supplier';
	
    protected $fillable = [
    	'supplier_id',
    	'book_id',
    	'amount',
    	'price',
    	'book_id',
    ];
}
