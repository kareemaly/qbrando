@if($product)
<div class="product" ng-controller="ProductController">

    <div class="product-body" data-toggle="modal" href="#productModal" ng-click="openProduct({{ $product->id }}, '{{ $product->title }}')">
        <div class="img">
            <img class="img-responsive" src="{{ $product->getImage('main')->getSmallest()->url }}" alt=""/>
        </div>

        <div class="prices">
            @if($product->hasOfferPrice() and isset($showOfferPrice))
            <span class="before-price">{{ $product->getBeforePrice()->format() }}</span>
            @endif
            <span class="actual-price">{{ $product->getActualPrice()->format() }}</span>
        </div>

        <h2 class="product-title"><a href="{{ URL::product($product) }}">{{ $product->title }}</a></h2>
    </div>

    <div class="buttons">
        <div class="my-btn add-to-cart">Add to Cart</div>
        <div class="my-btn details">Details</div>
    </div>
</div>
@endif