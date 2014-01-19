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

<div class="main-title">
    <span class="glyphicon glyphicon-shopping-cart"></span>
    Checkout form
</div>

<div style="height:20px;"></div>

<div class="checkout">
    <form name="checkoutForm" id="checkoutForm" role="form" action="{{ URL::route('checkout.post') }}" method="POST" ng-controller="CheckoutController">

        <div ng-hide="order" style="text-align: center; color:#666;">Please wait...</div>
        <div ng-cloak>
            <div class="step-titles">
                <div class="step-title" ng-class="{'active': isCurrentStep($index)}" ng-click="scrollTo($index)" ng-repeat="step in steps">
                    <h4>Step{{ angular('$index + 1') }}</h4>
                    <span>{{ angular('step') }}</span>
                </div>
            </div>
            
            <div class="clearfix"></div>
            <div class="step">
                <p class="info">
                    <span class="glyphicon glyphicon-warning-sign"></span>
                    We will use the contact number you provide to confirm order and delivery location.</p>

                <div class="form-group" ng-init="countries={{ $part->jsObject }}">
                    <label for="contact-name">Name*</label>
                    <input type="text" ng-model="order.contact.name" id="contact-name" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label for="contact-number">Contact number*</label>
                    <input type="text" ng-model="order.contact.number" id="contact-number" class="form-control" name="UserInfo[contact_number]" placeholder="Valid number for contact" required>
                </div>
                <div class="form-group">
                    <label for="contact-email">Email address <small>[Not required]</small></label>
                    <input type="text" ng-model="order.contact.email" id="contact-email" class="form-control" name="UserInfo[contact_email]">
                </div>

            </div>
            <div class="step">
                <div class="form-group">
                    <p class="info">
                        <span class="glyphicon glyphicon-warning-sign"></span>
                        We currently only ship orders to the cities specified below in the drop down list.</p>
                    <label for="location-country">Country*</label>

                    <select class="form-control" id="location-country"
                            ng-model="country"
                            ng-options="country for (country, cities) in countries"
                            name="country_name"
                            ng-change="defaultCity()"
                            required>
                        <option value="">Please select country</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="location-city">City*</label>

                    <select class="form-control" id="location-city"
                            ng-model="city"
                            ng-disabled="!country"
                            ng-options="city as city.name for city in country">
                    </select>

                    <input type="hidden" name="DeliveryLocation[municipality_id]" value="{{ angular('city.id') }}"/>
                </div>

                <div class="form-group">
                    <label for="location-address">Address*</label>
                    <textarea id="location-address" class="form-control" name="DeliveryLocation[address1]" ng-model="order.location.address" required cols="30" rows="2"></textarea>
                </div>
            </div>
            <div class="step">
                <div class="form-group">
                    <div class="radio-group">
                        <input type="radio" id="payment-paypal" name="Payment[method]" ng-model="order.payment.method" value="paypal"/>
                        <label for="payment-paypal"><img src="https://www.paypal.com/en_US/i/logo/PayPal_mark_37x23.gif" align="left" style="margin-right:7px;"><span>The safer, easier way to pay.</span><br/></label>

                        <div class="clearfix"></div>

                        <div class="paypal-advantages" ng-show="order.payment.method == 'paypal'">
                            <ul>
                                <li>Get a <strong>FREE</strong> gift costs QAR 100 for 1 item and costs QAR 200 or above for more.</li>
                            </ul>
                        </div>

                        <div class="clearfix"></div>

                        <input type="radio" id="payment-delivery" name="Payment[method]" ng-model="order.payment.method" value="delivery"/>
                        <label for="payment-delivery"><span>Pay on delivery</span></label>
                    </div>

                    <div class="clearfix"></div>
                </div>

                <p class="text-left text-danger">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    &nbsp
                    You are about to create an order with <strong ng-bind="cart.total() + ' items'"></strong> &nbspand total cost:
                    <strong class="price" ng-bind="cart.price.totalAfterOffer() | currency:currency"></strong>
                <span ng-show="cart.price.hasOffer()">instead of
                    <span class="before-price" ng-bind="cart.price.total() | currency:currency"></span>
                </span>
                </p>

                <p class="text-left text-danger" ng-show="order.payment.method == 'paypal'">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    &nbsp
                    You will be redirected to Paypal to pay an equivalent amount: <strong>USD <span ng-bind="cart.price.totalInUSD({{ $part->conversionRate }})"></span></strong>
                </p>
            </div>
            <div class="navigation">
                <button type="submit" class="btn submit-btn" ng-show="isLastStep()">
                    Submit
                    <span class="glyphicon glyphicon-arrow-right"></span></button>
                <button type="button" ng-click="stepNext()" class="btn" ng-hide="isLastStep()">Next</button>
                <button type="button" ng-click="stepBack()" class="btn" ng-class="{disabled: isFirstStep()}">Back</button>
            </div>
        </div>
    </form>

    <div class="clearfix"></div>
</div>