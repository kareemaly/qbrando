<div ng-class="{false: 'my-btn add-to-cart', true: 'my-btn in-cart'}[cart.has(product)]" ng-click="cart.add(product)">
    {{ cart.has(product) && 'In Cart' || 'Add To Cart' }}
</div>
