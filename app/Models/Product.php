<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guard=[];
    protected $table='products';
    public function photos(){
        return $this->hasMany(ProductPhotos::class);
    }
    public function categorias(){
        // return $this->belongsToMany(Category::class)->withTimestamps();
        return $this->belongsToMany(Category::class,'category_product','product_id','category_id');
        // ->withTimestamps();
    }

    public function categorias_produtos(){
        // return $this->belongsToMany(Category::class)->withTimestamps();
        return $this->hasMany(CategoryProduct::class,'product_id');
        // ->withTimestamps();
    }
    // public function producto(){
    //     return $this->belongsTo(OrderProduct::class,'product_id');
    // }
}
