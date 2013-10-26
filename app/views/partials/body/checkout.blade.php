<div class="main-title">Checkout form</div>
<div class="box">
    <div class="box-body">

        <br />

        @if(! $errors->isEmpty())
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            {{ implode($errors->all(':message'), '<br/>') }}
        </div>
        @endif

        @if(! $success->isEmpty())
        <div class="alert alert-success fade in">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Success</strong><br>
            {{ implode($success->all(':message'), '<br/>') }}
        </div>
        @endif

        <div class="alert alert-warning" style="margin-top:10px;">
            <p>
                <strong>Heads up!</strong>
                We currently deliver orders only in <strong>Qatar</strong>.<br />
                And we will use the <strong>contact number</strong> you will provide below to confirm the order. Thanks.
            </p>
        </div>


        <form role="form" action="{{ URL::route('place-order') }}" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Name*</label>
                <input type="text" class="form-control" name="UserInfo[name]" placeholder="Your name" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Contact number*</label>
                <input type="text" class="form-control" name="UserInfo[contact_number]" placeholder="Valid number for contact" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Delivery location*</label>
                <input type="text" class="form-control" name="UserInfo[delivery_location]" placeholder="Delivery location in details" required>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Email address <small>[Not required]</small></label>
                <input type="text" class="form-control" name="UserInfo[contact_email]" placeholder="">
            </div>


            <div>
            </div>

            <p class="text-left text-danger">
                You are about to create an order with <strong ng-bind="cart.total() + ' items'"></strong> and total cost: <strong ng-bind="cart.price.total() | currency:currency"></strong>
            </p>
            <button type="submit" class="btn secondary-btn">Submit</button>
        </form>
    </div>
</div>
