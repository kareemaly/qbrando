@if(($paypal = $part->paypal) && ($order = $part->order))
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

<div class="main-title"><span class="glyphicon glyphicon-shopping-cart"></span>Order confirmation <small>Last step</small></div>
<div class="checkout">

    <form action="{{ URL::route('checkout.confirm_paypal') }}" method="POST">

        <div class="key-value-pair">

            <p class="alert alert-info">
                Please review the following information carefully. Then confirm order to complete the transaction.
            </p>

            <div class="title">
                <a href="#">Order Information</a>
            </div>

            <div class="row">
                <div class="key">Ordered products: </div>
                <div class="value">
                    <ul>
                        @foreach($order->products()->get() as $product)
                        <li>{{ "{$product->pivot->qty} of <a href='".URL::product($product)."'>{$product->title}</a>" }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="key">Total: </div>
                <div class="value">{{ $paypal['order']['currency'].' '.$paypal['order']['total'] }}</div>
            </div>



            <div class="title">
                <a href="#">Contact Information</a>
            </div>

            <div class="row">
                <div class="key">Name: </div>
                <div class="value">{{ $order->userInfo->name }}</div>
            </div>

            <div class="row">
                <div class="key">Contact number: </div>
                <div class="value">{{ $order->userInfo->contact_number }}</div>
            </div>

            @if(($email = $order->userInfo->contact_email) || ($email = $paypal['contact']['email']))
            <div class="row">
                <div class="key">Email: </div>
                <div class="value">{{ $email }}</div>
            </div>
            @endif

            <div class="title">
                <a href="#">Shippping address</a>
            </div>
            <div class="row">
                <div class="key">Map address: </div>
                <div class="value">
                    {{ $order->deliveryLocation->google_address }}<br/>
                </div>
            </div>
            @if($order->deliveryLocation->extra_information)
            <div class="row">
                <div class="key">Extra information: </div>
                <div class="value">
                    {{ $order->deliveryLocation->extra_information }}<br/>
                </div>
            </div>
            @endif

            <div class="clearfix"></div>
        </div>

        <input type="hidden" name="payerID" value="{{ $paypal['payer']['id'] }}" />
        <input type="hidden" name="token" value="{{ $part->token }}"/>

        <button type="submit" class="confirm-btn"><img src="{{ URL::asset('app/img/security-icon.png'); }}"/> Confirm & Pay</button>
    </form>
</div>
@endif