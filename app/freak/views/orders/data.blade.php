@extends('freak::master.layout1')

@section('content')
<div class="row-fluid">
    <div class="span12 widget">
        <div class="widget-header">
            <span class="title">Orders</span>
        </div>
        <div class="widget-content shoppingcart">
            <ul class="thumbnails">
                @foreach($orders as $order)

                @if($userInfo = $order->userInfo)
                <li style="cursor: pointer;" onclick="window.location.href='{{ freakURL('element/order/show/' . $order->id) }}'">
                    <div class="info span12">

                        <span class="name">Products:
                        @foreach($order->products as $product)
                        <a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->title }}</a> ||||
                        @endforeach
                        </span>
                        <span class="name">User name:   <strong>{{ $userInfo->name }}</strong></span>
                        <span class="name">User mobile: <strong>{{ $userInfo->contact_number }}</strong></span>
                    </div>
                    <div class="actions">
                        <ul>
                            <li><a href="{{ freakUrl('element/order/delete/' . $order->id) }}" rel="tooltip" data-original-title="Delete"><i class="icon-remove"></i></a></li>
                        </ul>
                    </div>
                </li>
                @endif

                @endforeach
            </ul>
        </div>
    </div>
</div>
@stop
