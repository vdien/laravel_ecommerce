<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [ 'name', 'phone', 'city', 'district', 'ward', 'address', 'cart_items','subtotal','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
        'cart_items' => 'json',
    ];
}
