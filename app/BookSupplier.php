<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookSupplier extends Model
{
    protected $table = 'book_supplier';
	
    protected $fillable = [
    	'user_id',
        'supplier_id',
    	'book_id',
    	'amount',
    	'price',
    	'book_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
