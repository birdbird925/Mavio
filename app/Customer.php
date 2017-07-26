<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];
    protected $table = 'customers';

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function lastOrder()
    {
        return $this->order()->orderBy('created_at', 'DESC')->first();
    }

    public function totalSpent()
    {
        $total = 0;
        foreach($this->order as $order)
            $total += $order->subTotal() + $order->shipping_cost;

        return number_format($total, 2);
    }

    public function totalItem()
    {
        $total = 0;
        foreach($this->order as $order)
            $total += $order->items->count();

        return $total;
    }

    public function successOrder()
    {
        return $this->order()->where('order_status', '1')->get();
    }

    public function successTotalSpent()
    {
        $total = 0;
        foreach($this->successOrder() as $order)
            $total += $order->subTotal() + $order->shipping_cost;

        return $total;
    }

    public function successTotalItem()
    {
        $total = 0;
        foreach($this->successOrder() as $order)
            $total += $order->items->count();

        return $total;
    }
}
