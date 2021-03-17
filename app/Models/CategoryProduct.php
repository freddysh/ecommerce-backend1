<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    protected $table='category_product';

    public function categorias_produtos_(){
        // return $this->belongsToMany(Category::class)->withTimestamps();
        return $this->belongsTo(Product::class,'product_id');
        // ->withTimestamps();
    }
}
