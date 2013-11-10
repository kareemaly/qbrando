<div class="main-title">
    <span class="glyphicon glyphicon-bookmark"></span>
    {{ $part->product->title }}
</div>

<div class="full-product" ng-controller="ProductController">
    <div class="img">
        <img class="img-responsive" ng-bind="product.image" data-large="{{ $part->product->getImage('main')->getLargest()->url }}" src="{{ $part->product->getImage('main')->getSmallest()->url }}" />
    </div>

    <input type="hidden" ng-bind="product.id" value="{{ $part->product->id }}"/>

    <div class="product-info">

        <div class="row">
            <div class="key">Model:</div>
            <div class="value">{{ $part->product->model }}</div>
        </div>

        <div class="row">
            <div class="key">Brand:</div>
            <div class="value">{{ $part->product->brand }}</div>
        </div>

        <div class="row">
            <div class="key">Gender:</div>
            <div class="value">{{ $part->product->gender }}</div>
        </div>

        <div class="prices">
            @if($part->product->hasOfferPrice())
            <span class="before-price">{{ $part->product->beforePrice->format() }}</span>
            @endif
            <span class="actual-price" ng-bind="product.price | currency:currency" >{{ $part->product->actualPrice->format() }}</span>
        </div>
    </div>

    <div class="buttons">
        <my-cart-btn product="{{ angular('product') }}"></my-cart-btn>
        <a href="/place-order/{{ $part->product->id }}" class="my-btn details">Place order now</a>
    </div>
</div>
