<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class brands extends Model
{

    protected $fillable = [
        'name', 'photo', 'user_id'
    ];

    use HasFactory;
    

    public function products()
    {
        return $this->hasMany(Products::class);
    }

    public function productsOrders()
    {
        return $this->hasManyThrough(orders::class, products::class);
    }
}
