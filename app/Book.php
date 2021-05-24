<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'code',
        'img',
    	'price',
        'sale',
        'content',
        'amount',
        'amount_return',
        'size',
        'is_highlight',
        'page_number',
    ];

    public function authors(){
    	return $this->belongsToMany(Author::class);
    }

    public function types(){
        return $this->belongsToMany(Type::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function bookCategorys(){
        return $this->hasMany(Book_Category::class);
    }

    public function bookTypes(){
        return $this->hasMany(Book_Type::class);
    }

    public function authorBooks(){
        return $this->hasMany(Author_Book::class);
    }

    public function orderDetails(){
        return $this->hasMany(OrderDetail::class);
    }

    public function returnOrderDetails(){
        return $this->hasMany(ReturnOrderDetail::class);
    }

    public function importOrderDetails(){
        return $this->hasMany(ImportOrderDetail::class);
    }

    public function getQuantitySoldAttribute()
    {
        return $this->orderDetails->sum('amount');
    }

    public function getTotalMoneySoldAttribute()
    {
        return $this->orderDetails->sum('total_money');
    }

    public function getDiscountAttribute()
    {
        return $this->orderDetails->sum('discount');
    }

    public function getTotalReturnAttribute()
    {
        return $this->returnOrderDetails->sum('total_money') - $this->returnOrderDetails->sum('discount');
    }

    public function getInventoryValueAttribute()
    {
        return $this->amount * $this->price;
    }

    public function getBookSellingAttribute()
    {
        return $this->orderDetails->sum('amount');
    }
}
