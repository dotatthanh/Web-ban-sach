<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name',
        'img',
    	'price',
        'sale',
        'content',
        'amount',
        // 'total_export'
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

    // public function orders(){
    //     return $this->hasMany(Order::class);
    // }

    public function importOrderDetails(){
        return $this->hasMany(ImportOrderDetail::class);
    }

    // public function getTotalExportAttribute()
    // {
    //     return $this->orders->sum('amount');
    // }

    // public function getAmountAttribute()
    // {
    //     return $this->importOrderDetails->sum('amount');
    // }
}
