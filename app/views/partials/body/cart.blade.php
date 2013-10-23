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

                <tr>
                    <td><input type="text" class="txt" ng-model="quantity"></td>
                    <td>
                        <div class="product-info">
                            <a href="#">Model 24</a>
                            <img src="http://www.qbrando.loc/albums/sunglasses/thumbnails/Rayban-4.jpg" alt=""/>
                        </div>
                    </td>
                    <td><strong>200 Q.R</strong></td>
                    <td><strong>500 Q.R</strong></td>
                    <td><span class="glyphicon glyphicon-remove"></span></td>
                </tr>


            </table>
        </div>

        <div class="text-right">
            <a href="{{ URL::route('home') }}" class="btn secondary-btn">Continue shopping</a>
            <a href="{{ URL::route('checkout') }}" class="btn secondary-btn">Checkout <span class="glyphicon glyphicon-arrow-right"></span></a>
        </div>
    </div>
</div>
