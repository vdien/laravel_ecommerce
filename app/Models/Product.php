<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_short_des',
        'product_long_des',
        'tags',
        'price',
        'discount_price',
        'stock',
        'sku',
        'product_subcategory_id',
        'product_img',
        'product_img_child',
        'quantity',
        'stock',
        'status',
        'slug',
    ];
    protected $appends = ['total_quantity'];

    public function sizes()
    {
        return $this->hasMany(Size::class, 'product_id');
    }
    public function getTotalQuantityAttribute()
    {
        return $this->sizes->sum('quantity');
    }
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'product_subcategory_id');
    }
}
