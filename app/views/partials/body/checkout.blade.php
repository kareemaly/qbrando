<div ng-cloak>
    <p class="alert alert-success" ng-show="cart.isReady() && cart.total() < cart.price.offerItems()">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>LIMITED OFFER!</strong> For every two items you put in your <a href="#">cart</a> you get to choose one for total free!!<Br />
        You already have <strong ng-bind="cart.total() + ' items'"></strong> in your cart<br /><br/>

        <a class="btn btn-success" href="{{ URL::route('shopping-cart') }}">Go to your shopping cart</a>
        <a class="btn btn-success" href="{{ URL::route('home') }}">Continue shopping</a>
    </p>


    <p class="alert alert-success" ng-show="cart.isReady() && cart.total() == cart.price.offerItems()">
        <a href="#" class="close" data-dismiss="alert">&times;</a>
        <strong>FREE!</strong> You already have two items in your cart so you get to choose one for total free.<Br /><Br/>
        Try it and put one more item in your cart!

        <a class="btn btn-success" href="{{ URL::route('home') }}">Continue shopping</a>
    </p>

</div>

<div class="alert alert-warning" style="margin-top:10px;">
    <p>
        <strong>Heads up!</strong>
        We currently deliver orders only in <strong>Qatar</strong>.<br />
        And we will use the <strong>contact number</strong> you will provide below to confirm the order and time of delivery. Thanks.
    </p>
</div>


@if(! $errors->isEmpty())
<div class="alert alert-danger fade in">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    {{ implode($errors->all(':message'), '<br/>') }}
</div>
@endif

@if(! $success->isEmpty())
<div class="alert alert-success fade in">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <strong>Success</strong><br>
    {{ implode($success->all(':message'), '<br/>') }}
</div>
@endif

<div class="checkout">

    <div class="clearfix"></div>

    <form role="form" action="{{ URL::route('checkout.post') }}" method="POST" ng-controller="CheckoutController">

        <a href="#step1" id="step1" class="main-extra-bright-title"><b>Step 1:</b> Payment method</a>
        <div class="box">
            <div class="form-group">
                <div class="radio-group">
                    <input type="radio" id="payment-paypal" name="Payment[method]" ng-model="payment.method" value="paypal"/>
                    <label for="payment-paypal"><img src="https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif" align="left" style="margin-right:7px;"><span>The safer, easier way to pay.</span><br/></label>

                    <div class="clearfix"></div>

                    <div class="paypal-advantages" ng-show="payment.method == 'paypal'">
                        <ol>
                            <li>Get a free gift costs QAR 100 for 1 item and costs QAR 200 or above for more.</li>
                            <li>Faster delivery.</li>
                        </ol>
                    </div>

                    <div class="clearfix"></div>

                    <input type="radio" id="payment-delivery" name="Payment[method]" ng-model="payment.method" value="delivery"/>
                    <label for="payment-delivery"><span>Pay on delivery</span></label>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>


        <a href="#step2" id="step2" class="main-extra-bright-title"><b>Step 2:</b> Contact information</a>
        <div class="box">
            <div class="box-body">

                <div class="form-group">
                    <label for="exampleInputEmail1">Name*</label>
                    <input type="text" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Contact number*</label>
                    <input type="text" class="form-control" name="UserInfo[contact_number]" placeholder="Valid number for contact" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email address <small>[Not required]</small></label>
                    <input type="text" class="form-control" name="UserInfo[contact_email]" placeholder="">
                </div>
            </div>
        </div>

        <div>
            <a href="#step3" id="step3" class="main-extra-bright-title"><b>Step 3:</b> Shipping address <small>select from the following drop down then drag the marker to your exact location</small></a>
            <div class="box">
                <div class="box-body">
                    <div class="form-group">
                        <select class="form-control" id="municipality-select" name="DeliveryLocation[municipality_id]">
                            @foreach($part->municipalities as $municipality)
                            <option value="{{ $municipality->id }}">{{ $municipality }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="map-canvas" style="height:400px; width:100%;"></div>

                    <div class="form-group" style="margin-top:20px;">
                        <label for="exampleInputPassword1">Extra information</label>
                        <textarea class="form-control" name="DeliveryLocation[extra_information]" cols="30" rows="3" placeholder="Extra information about the delivery location"></textarea>
                    </div>

                    <input type="hidden" name="DeliveryLocation[latitude]" id="delivery-location-latitude"/>
                    <input type="hidden" name="DeliveryLocation[longitude]" id="delivery-location-longitude"/>
                    <input type="hidden" name="DeliveryLocation[google_address]" id="delivery-location-google-address"/>
                </div>
            </div>
        </div>

        <div class="submit-box">
            <p class="text-left text-danger">
                You are about to create an order with <strong ng-bind="cart.total() + ' items'"></strong> and total cost:
                <strong class="price" ng-bind="cart.price.totalAfterOffer() | currency:currency"></strong>
                <span ng-show="cart.price.hasOffer()">instead of
                    <span class="before-price" ng-bind="cart.price.total() | currency:currency"></span>
                </span>
            </p>

            <p class="text-left text-danger" ng-show="payment.method == 'paypal'">
                You will be redirected to Paypal to pay an equivalent amount: <strong>USD <span ng-bind="cart.price.totalInUSD({{ $part->conversionRate }})"></span></strong>
            </p>
            <button type="submit" ng-show="payment.method == 'paypal'" class="btn paypal-btn">Submit and go to <span>Paypal</span> <span class="glyphicon glyphicon-arrow-right"></span></button>
            <button type="submit" ng-show="payment.method == 'delivery'" ng-cloak class="btn secondary-btn">Send order</button>
        </div>
    </form>
</div>