<div class="main-title">
    <span class="glyphicon glyphicon-bookmark"></span>
    {{ $part->product->title }}
</div>

<div class="alert alert-warning">
    <p>
        We currently deliver orders only in <strong>Qatar</strong>.<br />
        And delivery takes between 24 and 36 hours.
    </p>
</div>


<div class="full-product" ng-controller="ProductController">

    <div class="img-div">

        <img class="img-responsive" ng-bind="product.image" data-large="{{ $part->product->getImage('main')->getLargest()->url }}" src="{{ $part->product->getImage('main')->getSmallest()->url }}" />
        <div class="clearfix"></div>

        @if($part->product->isAvailable())

        @if($cbItem = $part->product->cbItem)
        <div class="clickbank">
            <a href="{{ $cbItem->paymentUrl }}">
                <img src="{{ URL::asset('/app/img/clickbank-buynow.jpg') }}" title="Buy {{ $part->product->title }} and get a free perfume" style="max-width:240px;" />
            </a>
        </div>
        @else
        <div class="buttons">
            <my-cart-btn product="{{ angular('product') }}"></my-cart-btn>
            <a href="/place-order/{{ $part->product->id }}" class="my-btn details">Place order now</a>
        </div>
        @endif

        @endif
    </div>

    <input type="hidden" ng-bind="product.id" value="{{ $part->product->id }}"/>

    <div class="product-info">

        <div class="row">
            <div class="key">Model:</div>
            <div class="value">{{ $part->product->model }}</div>
        </div>

        <div class="row">
            <div class="key">Brand:</div>
            <div class="value"><a href="{{ URL::category($part->product->category) }}">{{ $part->product->brand }}</a></div>
        </div>

        <div class="row">
            <div class="key">Gender:</div>
            <div class="value">{{ $part->product->gender }}</div>
        </div>

        @if($part->product->description)
        <div class="row">
            <div class="key">Description:</div>
            <div class="value">
                {{ $part->product->description }}
            </div>
        </div>
        @endif


        @if($part->product->notAvailable())
        <div class="row">
            <div class="key" style="color:#F00; font-weight:bold; font-size:16px">NOT AVAILABLE FOR NOW</div>
        </div>
        @endif

        <div class="prices row">
            <div class="key">Price:</div>
            @if($part->product->hasOfferPrice())
            <span class="before-price">{{ $part->product->beforePrice->format() }}</span>
            @endif
            <span class="actual-price" ng-bind="product.price | currency:currency" >{{ $part->product->actualPrice->format() }}</span>
        </div>
    </div>
</div>

<div class="main-bright-title">
    <span class="glyphicon glyphicon-comment"></span>
    Contact information
</div>

<div class="contact-us">
    <div class="row">
        <div class="key">Mobile number:</div>
        <div class="value">{{ $contactUs->getMobileNumber() }}</div>
    </div>
    <div class="row">
        <div class="key">Email:</div>
        <div class="value">{{ $contactUs->getEmailAddress() }}</div>
    </div>
</div>
