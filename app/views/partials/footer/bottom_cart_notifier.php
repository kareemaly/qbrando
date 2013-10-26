<div class="bottom-notifier" ng-controller="BottomNotifierController" ng-cloak>
    <span class="glyphicon glyphicon-shopping-cart"></span> You have <span ng-bind="cart.total()"></span> items in your cart.
    <a href="<?php echo URL::route('checkout') ?>">Checkout <span class="glyphicon glyphicon-arrow-right"></span></a>
</div>