@if($product)

<div class="product" ng-controller="ProductController">
    <div class="product-body" data-toggle="modal" href="#productModal" ng-click="openProduct({{ $product->id }}, '{{ $product->title }}')">
        <img class="img-responsive" src="{{ $product->getImage('main')->getSmallest()->url }}" alt=""/>
        <h2><a href="#">{{ $product->title }}</a></h2>

        @if($product->hasOfferPrice())
        <span class="price-strike">{{ $product->price }}</span>
        <span class="price">{{ $product->offer_price }}</span>
        @else
        <span class="price">{{ $product->price }}</span>
        @endif

    </div>

    <div class="buttons">
        @if($cart->find($product->id))
        <div class="btn btn-purple">In cart</div>
        @else
        <div class="btn btn-black" ng-click="addToCart({{ $product->id }})">Add to cart</div>
        @endif
    </div>
</div>
@endif