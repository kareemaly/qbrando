

<div class="alert alert-success">
    <a href="#" class="close" data-dismiss="alert">&times;</a>
    <p>
        <strong>Nice timing!</strong> We currently giving free luxury item for each two items you buy. Try it, put three items in your cart, one of them will be totally free!!<br />
    </p>
</div>

<div class="main-title"><span class="glyphicon glyphicon-shopping-cart"></span>Your shopping cart</div>
<div class="box">
    <div class="cart" ng-controller="CartController" ng-cloak ng-show="cart.isReady()" ng-switch on="cart.isEmpty()">

        <div ng-switch-when="true" class="text-center" style="padding:40px;">
            Your cart is empty. <a href="<?php echo URL::route('home'); ?>">Continue shopping</a>
        </div>

        <div ng-switch-default><Br/>

            <div class="text-right">
                <a href="<?php echo URL::route('checkout'); ?>" class="btn secondary-btn checkout-btn">Checkout <span class="glyphicon glyphicon-arrow-right"></span></a>

<!--                <div class="or-separator">OR</div>-->
<!---->
<!--                <a href="--><?php //echo URL::route('checkout.paypal') ?><!--">-->
<!--                    <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif">-->
<!--                </a>-->
            </div>


            <div class="table-responsive">

                <table class="table">
                    <tr>
                        <th>Quantity</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                        <th>Remove</th>
                    </tr>

                    <tr ng-repeat="product in cart.get()">
                        <td><input type="number" min="1" max="30" class="quantity-txt" ng-model="product.quantity" ng-change="cart.save()" required/></td>
                        <td ng-click="openProduct(product)">
                            <div class="product-info">
                                <span ng-bind="product.title"></span>
                                <img ng-src="{{ product.image }}" alt=""/>
                            </div>
                        </td>
                        <td><strong>{{ product.price | currency:currency }}</strong></td>
                        <td>
                            <strong>{{ cart.price.subTotal(product) | currency:currency }}</strong>
                        </td>
                        <td><span ng-click="cart.remove(product)" class="glyphicon glyphicon-remove"></span></td>
                    </tr>


                </table>
            </div>

            <div class="total">
                <span>Total: </span>
                <strong class="before-price" ng-show="cart.price.hasOffer()">
                    {{ cart.price.total() | currency:currency }}
                </strong>
                <Br />
                <strong>
                    {{ cart.price.totalAfterOffer() | currency:currency }}
                </strong>
            </div>

            <hr />

            <div class="text-right">
                <a href="<?php echo URL::route('checkout'); ?>" class="btn secondary-btn checkout-btn">Checkout <span class="glyphicon glyphicon-arrow-right"></span></a>

<!--                <div class="or-separator">OR</div>-->
<!---->
<!--                <a href="--><?php //echo URL::route('checkout.paypal') ?><!--">-->
<!--                    <img src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif">-->
<!--                </a>-->
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
</div>