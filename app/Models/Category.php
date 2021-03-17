<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $guard=[];
    protected $table='categories';
    public function productos(){
        // return $this->belongsToMany(Product::class)->withTimestamps();
        return $this->belongsToMany(Product::class,'category_product','category_id','product_id');
        // ->withTimestamps();
    }
}
