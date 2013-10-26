<!-- Modal -->
<div class="modal fade" ng-controller="ModalController" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ng-bind="product.title"></h4>
            </div>
            <div class="modal-body" ng-switch on="product">

                <div ng-switch-when="null">

                </div>

                <div class="main-product" ng-switch-default>
                    <div class="img">
                        <img ng-src="{{ product.image }}" />
                    </div>

                    <div class="product-info">

                        <div class="row">
                            <div class="key">Model:</div>
                            <div class="value" ng-bind="product.model"></div>
                        </div>

                        <div class="row">
                            <div class="key">Brand:</div>
                            <div class="value" ng-bind="product.brand"></div>
                        </div>

                        <div class="row">
                            <div class="key">Gender:</div>
                            <div class="value" ng-bind="product.gender"></div>
                        </div>

                        <div class="prices">
                            <span ng-show="product.beforePrice > 0" class="before-price" ng-bind="product.beforePrice | currency:currency"></span>
                            <span class="actual-price" ng-bind="product.price | currency:currency"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn btn-link" data-dismiss="modal" aria-hidden="true">Close</div>
                <my-cart-btn product="{{ product }}"></my-cart-btn>
                <a ng-href="/place-order/{{ product.id }}" class="my-btn details">Place order now</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
