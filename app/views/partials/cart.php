<div class="box cart" ng-controller="CartController">
    <div class="table-responsive">
        <table class="table table-condensed">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Remove</th>
            </tr>
            <tr ng-repeat="product in products">
                <td style="max-width:20px;"><img class="img-responsive" src="{{product.image}}"/></td>
                <td ng-bind="product.title"></td>
                <td ng-bind="product.actualPrice"></td>
                <td><input type="number" class="form-control" ng-model="quantity" min="1" max="5"></td>
                <td nd-bind="product.subTotal"></td>
                <td><span ng-click="remoteProduct($index)" class="glyphicon glyphicon-remove"></span></td>
            </tr>
            <tr>
                <td class='total' colspan="6">Total = <span>$534.00</span></td>
            </tr>
        </table>
    </div>
</div>

<div class="btn-lg pull-right btn-purple">Checkout <span class="glyphicon glyphicon-arrow-right"></span></div>

<div class="clearfix"></div>