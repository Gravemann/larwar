<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class products extends Model
{
    use HasFactory;

    public function brands()
    {
        return $this->belongsTo(brands::class);
    }

    public function orders()
    {
        return $this->hasMany(orders::class);
    }

}
