<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Customer;
use App\Product;
use App\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $customers = Customer::all();
        $products = Product::all();
        $orders = Order::where('order_status', 1);
        $amount = 0;
        foreach($orders->get() as $order)
            $amount += $order->amount();

        $productStatistic = $this->productSale($products->first()->id);
        return view('admin.dashboard', compact(
            'productStatistic',
            'customers',
            'products',
            'orders',
            'amount'
        ));
    }

    protected function saleStatistic()
    {
        $statistic = [
            'labels' => [],
            'data' => [],
        ];
        for ($day = 6; $day >= 0; $day--) {
            if($day != 0)
                $orders = Order::where('created_at', '>=', Carbon::today()->subDays($day))->where('created_at', '<', Carbon::today()->subDays($day-1))->get();
            else
                $orders = Order::where('created_at', '>=', Carbon::today())->get();

            $sale = 0;
            foreach($orders as $order)
                $sale += $order->amount();

            array_push($statistic['labels'], Carbon::today()->subDays($day)->format('M d'));
            array_push($statistic['data'], $sale);
        }

        return $statistic;
    }

    protected function productSale($id)
    {
        $product = Product::findOrFail($id);
        $statistic = [
            'image' => $product->mainImage()->getSrc(),
            'today' => 0,
            'week' => 0,
            'month' => 0,
            'total' => 0,
            'sale' => 0
        ];
        foreach($product->orderItems as $item) {
            $orderDate = $item->order->created_at;
            // today
            if($orderDate->gte(Carbon::today()))
                $statistic['today'] += $item->quantity;
            // week
            if($orderDate->gte(Carbon::today()->startOfWeek()))
                $statistic['week'] += $item->quantity;
            // month
            if($orderDate->gte(Carbon::today()->startOfMonth()))
                $statistic['month'] += $item->quantity;

            $statistic['total'] += $item->quantity;
            $statistic['sale'] += $item->total();
        }
        return $statistic;
    }
}
