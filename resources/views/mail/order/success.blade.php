@component('mail::message')
# Thank you for your purchase!

Hi {{$order->name}}, we're getting your product ready to be shipped. We will notify you when it has been sent.


Order {{$order->orderCode()}} summary:

@component('mail::table')
|Product                            |Price                           |Quantity   |
|:----------------------------------|--------------------------------|----------:|
@foreach($order->items as $item)
|**{{$item->product->title}}**|RM{{$item->price}}           |{{$item->quantity}}|
@endforeach
@endcomponent

@if($order->shipping_cost != 0)
**Shipping Charge: RM{{number_format($order->shipping_cost, 2)}}**
@endif

#Total: RM{{number_format($order->shipping_cost+$order->subTotal(), 2)}}
@endcomponent
