@if($product)
<div class="product" ng-controller="ProductController">

    <div class="product-body" ng-click="openProduct(product)">

        <input type="hidden" ng-bind="product.id" value="{{ $product->id }}"/>

        <div class="img">
            <img class="img-responsive" ng-bind="product.image" data-large="{{ $product->getImage('main')->getLargest()->url }}" src="{{ $product->getImage('main')->getSmallest()->url }}" alt=""/>
        </div>

        <div class="prices">
            @if($product->hasOfferPrice() and isset($showOfferPrice))
            <span class="before-price">{{ $product->beforePrice->format() }}</span>
            @endif
            <span ng-bind="product.price | currency:currency" class="actual-price">{{ $product->actualPrice->format() }}</span>
        </div>

        <h2 class="product-title"><a ng-bind="product.title" href="{{ URL::product($product) }}">{{ $product->title }}</a></h2>
    </div>

    <div class="buttons">
        <my-cart-btn product="{{ angular('product') }}"></my-cart-btn>
        <div class="my-btn details" ng-click="openProduct(product)">Details</div>
    </div>
</div>
@endif