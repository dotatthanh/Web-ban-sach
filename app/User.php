<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function orders () {
        return $this->hasMany(Order::class);
    }

    public function returnOrders () {
        return $this->hasMany(ReturnOrder::class);
    }

    public function getTotalSalesOrderAmountAttribute()
    {
        return $this->orders->where('status', 4)->sum('total_money');
    }

    public function getTotalSalesOrderAttribute()
    {
        return $this->orders->where('status', 4)->count();
    }

    public function getTotalReturnOrderAttribute()
    {
        return $this->returnOrders->count();
    }

    public function getTotalReturnOrderAmountAttribute()
    {
        return $this->returnOrders->sum('total_money');
    }
}
