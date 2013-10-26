<div class="bottom-notifier" ng-controller="BottomNotifierController" ng-cloak onclick="window.location.href='<?php echo URL::route('shopping-cart') ?>'">
    <span class="glyphicon glyphicon-shopping-cart"></span> You have <span ng-bind="cart.total()"></span> items in your cart. Click here to go to your shopping cart.
</div>