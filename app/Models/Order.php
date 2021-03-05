<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public function productos_ordenados(){
        return $this->hasMany(OrderProduct::class);
    }
    public function cliente(){
        return $this->belongsTo(User::class);
    }
}
