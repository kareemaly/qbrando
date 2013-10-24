<!-- Modal -->
<div class="modal fade" ng-controller="ModalController" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <div class="btn btn-link" data-dismiss="modal" aria-hidden="true">Close</div>
                <button ng-class="cartBtn.class" ng-click="addToCart()" ng-bind="cartBtn.text">Add to Cart</button>
                <a ng-href="/place-order/{{ product.id }}" class="my-btn details">Place order now</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
