<div ng-class="{false: 'my-btn add-to-cart', true: 'my-btn in-cart'}[cart.has(product)]" ng-click="cart.addOrGoToCart(product)">
    {{ cart.has(product) && 'Go to Cart' || 'Add To Cart' }}
</div>
