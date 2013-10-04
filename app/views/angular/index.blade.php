<!doctype html>
<html ng-app="qbrando">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <title>My AngularJS App</title>

<!--    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">-->
    <link href="{{ URL::asset('app/css/app.css') }}" rel="stylesheet">

</head>
<body>

<div class="container">
    <div class="header">
        <div class="logo"></div>
        <div class="offers">
            <span class="offer-up">FREE DELIVERY TO YOUR DOOR STEPS</span>
            <span class="offer-middle">DELIVERY WITHIN 24 Hours</span>
            <span class="offer-down">PAY ON DELIVERY</span>
        </div>
        <div class="shopping-cart">
            <div class="cart-icon"></div>
            <div class="cart-info">
                <strong>Shopping cart:</strong><br />
                <p>Now in your cart <span>0 items</span></p>
            </div>
        </div>
    </div>

    <div ng-view></div>

</div>


@if(App::environment() == 'production')
<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.0.7/angular.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js"></script>
@else
<script src="{{ URL::asset('app/lib/angular/angular.js') }}"></script>
<script src="{{ URL::asset('app/lib/ui-bootstrap-tpls-0.6.0.js') }}"></script>
@endif

<script src="{{ URL::asset('app/js/app.js') }}"></script>
<script src="{{ URL::asset('app/js/services.js') }}"></script>
<script src="{{ URL::asset('app/js/controllers.js') }}"></script>
<script src="{{ URL::asset('app/js/filters.js') }}"></script>
<script src="{{ URL::asset('app/js/directives.js') }}"></script>
</body>
</html>