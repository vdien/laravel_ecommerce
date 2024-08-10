<?php

// app/Models/Order.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'name', 'phone','address','payment_status','shipping_activity','shipping_brand','code_shipping','payment_method', 'cart_items','subtotal','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'cart_items' => 'json',
    ];
}
