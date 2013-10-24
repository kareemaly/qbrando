<div class="main-title"><span class="glyphicon glyphicon-shopping-cart"></span>Your shopping cart</div>
<div class="box">
    <div class="cart" ng-controller="CartController">

        <p>Feel free to update your cart and checkout.</p>

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Quantity</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                    <th>Remove</th>
                </tr>

                <tr ng-repeat="product in products" >
                    <td><input type="number" min="1" max="30" class="quantity-txt" ng-model="product.quantity" required/></td>
                    <td data-toggle="modal" href="#productModal" ng-click="openProduct(product)">
                        <div class="product-info">
                            <span>{{ product.name }}</span>
                            <img ng-src="{{ product.image }}" alt=""/>
                        </div>
                    </td>
                    <td><strong>{{ product.price }} Q.R</strong></td>
                    <td><strong>{{ getSubTotal(product) }} Q.R</strong></td>
                    <td><span ng-click="removeProduct(product)" class="glyphicon glyphicon-remove"></span></td>
                </tr>


            </table>
        </div>

        <div class="total">
            <span>Total: </span>
            <strong>
                {{ getTotal() }} Q.R
            </strong>
        </div>

        <hr />

        <div class="text-right">
            <a href="<?php echo URL::route('home'); ?>" class="btn secondary-btn">Continue shopping</a>
            <a href="<?php echo URL::route('checkout'); ?>" class="btn secondary-btn">Checkout <span class="glyphicon glyphicon-arrow-right"></span></a>
        </div>
    </div>
</div>
