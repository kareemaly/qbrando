<div class="header" ng-controller="HeaderController">
    <div class="logo"></div>
    <div class="offers">
        <span class="offer-up">FREE DELIVERY TO YOUR DOOR STEPS</span>
        <span class="offer-middle">DELIVERY WITHIN 24 Hours</span>
        <span class="offer-down">PAY ON DELIVERY</span>
    </div>
    <div class="shopping-cart" ng-click="launchCart()">
        <div class="cart-icon"></div>
        <div class="cart-info">
            <strong>Shopping cart:</strong><br />
            <p>Now in your cart <span ng-bind="cart.totalProducts() + ' items'"></span></p>
        </div>
    </div>
</div>