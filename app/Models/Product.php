<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'slug', 'price'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function assets()
    {
        return $this->hasMany(ProductAsset::class);
    }
}
