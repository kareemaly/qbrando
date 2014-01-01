@if($paypal = $part->paypal)
<!--<div class="alert alert-danger">-->
<!--    <p>-->
<!--        <strong>We only deliver orders in Qatar</strong>-->
<!--        Your paypal shipping address is {{ $paypal['location']['street'] . ' ' . $paypal['location']['countryName'] }}.-->
<!--        Which is not located in Qatar.<Br />-->
<!--        If the shipping address is not the same as paypal please specify one located in <strong>Qatar</strong> bellow.-->
<!--    </p>-->
<!--</div>-->

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

    <form role="form" action="{{ URL::route('checkout.fill_and_confirm_paypal') }}" method="POST" ng-controller="CheckoutController">

        <a href="#step1" id="step1" class="main-extra-bright-title"><b>Step 1:</b> Contact information</a>
        <div class="box">
            <div class="box-body">

                <div class="form-group">
                    <label for="exampleInputEmail1">Name*</label>
                    <input type="text" class="form-control" name="UserInfo[name]" value="{{ $paypal['contact']['fullName'] }}" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Contact number*</label>
                    <input type="text" class="form-control" name="UserInfo[contact_number]" value="{{ $paypal['contact']['phone'] }}" placeholder="Valid number for contact" required>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Email address <small>[Not required]</small></label>
                    <input type="text" class="form-control" name="UserInfo[contact_email]" value="{{ $paypal['contact']['email'] }}" placeholder="">
                </div>
            </div>
        </div>

        <div>
            <a href="#step2" id="step2" class="main-extra-bright-title"><b>Step 2:</b> Shipping address</a>
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
                        <textarea class="form-control" name="DeliveryLocation[extra_information]" cols="30" rows="3" placeholder="Extra information about the delivery location">{{ $paypal['location']['street'] }}</textarea>
                    </div>

                    <input type="hidden" name="DeliveryLocation[latitude]" id="delivery-location-latitude"/>
                    <input type="hidden" name="DeliveryLocation[longitude]" id="delivery-location-longitude"/>
                </div>
            </div>
        </div>

        <div class="submit-box">
            <p class="text-left text-danger">
                You are about to pay for an order with <strong>{{ $order->getTotalItems() }}</strong> items and total cost:
                <strong>{{ $paypal['order']['currency'].' '.$paypal['order']['total'] }}</strong>
            </p>

            <input type="hidden" name="payerID" value="{{ $paypal['payer']['id'] }}" />
            <input type="hidden" name="token" value="{{ $part->token }}"/>

            <button type="submit" class="btn paypal-btn">Confirm order <span class="glyphicon glyphicon-arrow-right"></span></button>
        </div>
    </form>
</div>
@endif