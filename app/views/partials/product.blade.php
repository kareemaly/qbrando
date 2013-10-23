@if($product)
<div class="product">
    <div class="img">
        <img class="img-responsive" src="{{ $product->getImage('main')->getSmallest()->url }}" alt=""/>
    </div>

    <div class="prices">
        <span class="actual-price">{{ $product->getActualPrice()->format() }}</span>
    </div>

    <h2 class="product-title"><a href="{{ URL::product($product) }}">{{ $product->title }}</a></h2>

    <div class="buttons">
        <div class="add-to-cart">Add to Cart</div>
        <div class="details">Details</div>
    </div>
</div>
@endif