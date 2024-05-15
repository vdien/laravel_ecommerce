<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name',
        'slug',
        'description',
        'category_image',
        'category_status',
    ];
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }
}
