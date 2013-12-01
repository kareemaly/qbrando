@if($product)
<div class="product" ng-controller="ProductController">

    <div class="product-body" ng-click="openProduct(product)">

        <input type="hidden" ng-bind="product.id" value="{{ $product->id }}"/>

        <div class="img">
            <img class="img-responsive" ng-bind="product.image" data-large="{{ $product->getImage('main')->getLargest() }}" src="{{ $product->getImage('main')->getSmallest() }}" alt=""/>
        </div>

        <div class="prices">
            @if($product->hasOfferPrice() and isset($showOfferPrice))
            <span class="before-price">{{ $product->beforePrice->format() }}</span>
            @endif
            <span ng-bind="product.price | currency:currency" class="actual-price">{{ $product->actualPrice->format() }}</span>
        </div>

        <h2 class="product-title"><a href="{{ URL::product($product) }}" ng-bind="product.title">{{ $product->title }}</a></h2>
    </div>

    <div class="buttons">
        <my-cart-btn product="{{ angular('product') }}"></my-cart-btn>
        <a class="my-btn details" href="{{ URL::product($product) }}">Details</a>
    </div>
</div>
@endif