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

                @if(($product = $order->products->first()) && ($userInfo = $order->userInfo))
                <li style="cursor: pointer;" onclick="window.location.href='{{ freakURL('element/order/show/' . $order->id) }}'">
                    <div class="thumbnail">
                        {{ $product->getImage('main')->html() }}
                    </div>
                    <div class="info">

                        <span class="name">Product:
                            <strong>
                                <a href="{{ freakUrl('element/product/show/' . $product->id) }}">{{ $product->en('title') }}</a>
                            </strong>
                        </span>
                        <span class="name">User email: <strong>{{ $userInfo->contact_email }}</strong></span>
                    </div>
                    <div class="actions">
                        <ul>
                            <li><a href="{{ freakUrl('element/order/delete/' . $product->id) }}" rel="tooltip" data-original-title="Delete"><i class="icon-remove"></i></a></li>
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
