<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const ORDER_NEW = 0;
    const ORDER_CONFIRMED = 10;
    const ORDER_COMPLETED = 20;

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function order_products()
    {
        return $this->hasMany('App\OrderProduct');
    }
}
