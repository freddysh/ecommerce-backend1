<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table='products';
    public function photos(){
        return $this->hasMany(ProductPhotos::class);
    }
    public function categorias(){
        return $this->belongsToMany(Category::class);
    }
}
