@if($product)
<div class="product" ng-controller="ProductController" ng-init="product={id: {{ $product->id }}, title:'{{ $product->title }}'}" >

    <div class="product-body" data-toggle="modal" href="#productModal" ng-click="openProduct()">

        <div class="img">
            <img class="img-responsive" src="{{ $product->getImage('main')->getSmallest()->url }}" alt=""/>
        </div>

        <div class="prices">
            @if($product->hasOfferPrice() and isset($showOfferPrice))
            <span class="before-price">{{ $product->getBeforePrice()->format() }}</span>
            @endif
            <span class="actual-price">{{ $product->getActualPrice()->format() }}</span>
        </div>

        <h2 class="product-title"><a ng-bind="product.title" href="{{ URL::product($product) }}">{{ $product->title }}</a></h2>
    </div>

    <div class="buttons">
        <div ng-class="cartBtn.class" ng-click="addToCart()" ng-bind="cartBtn.text">Add to Cart</div>
        <div class="my-btn details" data-toggle="modal" href="#productModal" ng-click="openProduct()">Details</div>
    </div>
</div>
@endif