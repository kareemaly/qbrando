@if(isset($product))
<div class="main-product">
    <div class="img-div">
        <img class="img-responsive" src="{{ $product->getImage('main')->getLargest()->url }}" alt=""/>
    </div>
    <div class="product-body">
        @if($category = $product->category)
        <div class="info-row">
            <span class="info-key">Brand</span>
            <span class="info-value">{{ $category->name }}</span>
        </div>
        @endif

        @if($model = $product->model)
        <div class="info-row">
            <span class="info-key">Model</span>
            <span class="info-value">{{ $product->model }}</span>
        </div>
        @endif

        @if($gender = $product->gender)
        <div class="info-row">
            <span class="info-key">Gender</span>
            <span class="info-value">{{ $gender }}</span>
        </div>
        @endif

        <div class="info-row">
            <span class="info-key">Price</span>

            @if($product->hasOfferPrice())
            <span class="price-strike">{{ $product->price }}</span>
            <span class="price">{{ $product->offer_price }}</span>
            @else
            <span class="price">{{ $product->price }}</span>
            @endif

        </div>
    </div>
</div>
@endif