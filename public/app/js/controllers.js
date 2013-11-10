'use strict';

/* Controllers */

angular.module('qbrando.controllers', ['qbrando.services']).


    controller('MainController', ['$scope', 'Cart', 'ModalProduct', 'Products', function ($scope, Cart, ModalProduct, Products) {

        $scope.currency = 'QAR ';

        $scope.cart = Cart;

        // We choose how to open the product
        $scope.openProduct = function(product)
        {
            // Initialize partial information
            ModalProduct.setProduct( product );

            // Open modal
            ModalProduct.open();

            // We will use modal service to show our product
            Products.getFullInfo(product.id, function(p)
            {
                ModalProduct.setProduct(p);
            });
        }
    }])


    .controller('ModalController', ['$scope', 'ModalProduct', '$element', function ($scope, ModalProduct, $element) {

        $scope.modal = ModalProduct;

        $scope.$watch('modal.product', function(product)
        {
            $scope.product = product;
        });


    }])



    .controller('ProductController', ['$scope', '$element', 'Products', function ($scope, $element, Products) {

        // Set product scope
        $scope.product = {
            'id'   : $element.find('[ng-bind="product.id"]').val(),
            'title': $element.find('[ng-bind="product.title"]').html(),
            'image': $element.find('[ng-bind="product.image"]').attr('src'),
            'price': $element.find('[ng-bind="product.price | currency:currency"]').html()
        };

        $element.find('[ng-bind="product.title"]').attr('href', 'javascript:void(0)');

        $element.find('img').imagezoomsl({

            zoomrange: [3, 3],
            magnifiersize: [500, 200],
            magnifierborder: "1px solid #CCC",
            disablewheel: false
        });

        if($scope.product.price !== undefined)
        {
            $scope.product.price = $scope.product.price.replace('QAR ', '');
        }

        // Add these information to partial information..
        Products.addPartialInfo($scope.product);
    }])


    .controller('CartController', ['$scope', '$element', function ($scope, $element) {

        var i = 0;
        setInterval(function()
        {
            $element.find(".checkout-btn").each(function()
            {
                if(i%2 == 0) $( this ).animate({backgroundColor: "#AB066A"}, 1000 );

                else $( this ).animate({backgroundColor: "#333"}, 1000 );
            })
            i++

        }, 500);
    }])


    .controller('CheckoutController', ['$scope', function ($scope) {

    }])


    .controller('ProductsController', ['$scope', function ($scope) {

    }])


    .controller('HeaderController', ['$scope', function ($scope) {

    }])


    .controller('BottomNotifierController', ['$scope', '$element', function($scope, $element) {

        $element.hide();

        $(window).scroll(function()
        {
            if($(this).scrollTop() > 400 && ! $scope.cart.isEmpty() && $scope.cart.isReady())
            {
                $element.slideDown('slow');
            }
            else
            {
                $element.slideUp('slow');
            }
        });

    }]);
