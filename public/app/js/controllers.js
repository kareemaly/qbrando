'use strict';

/* Controllers */

angular.module('qbrando.controllers', ['qbrando.services']).

    controller('HomeController', ['$scope', function ($scope) {

    }])


    .controller('ProductController', ['$scope', '$element', 'ModalProduct', 'Cart', function ($scope, $element, ModalProduct, Cart) {

        $scope.Cart = Cart;

        $scope.openProduct = function()
        {
            ModalProduct.open($scope.product);
        };

        // Watch cart total products
        $scope.$watch('Cart.totalProducts()', function()
        {
            $scope.cartBtn = Cart.has($scope.product) ?
            {'text': "In cart", 'class': "my-btn in-cart"} :
            {'text':"Add to cart", 'class': "my-btn add-to-cart"};
        });

        $scope.addToCart = function()
        {
            if(! Cart.has($scope.product))
            {
                $element.fadeTo(200, '0.2').delay(500).fadeTo(200, 1);

                Cart.addProduct($scope.product);
            }
        };
    }])

    .controller('ModalController', ['$scope', 'ModalProduct', 'Cart', '$element', function ($scope, ModalProduct, Cart) {

        $scope.ModalProduct = ModalProduct;

        $scope.$watch('ModalProduct.getProduct()', function(product)
        {
            if(product !== null)
            {
                $scope.product = product;

                $scope.cartBtn = Cart.has($scope.product) ?
                {'text': "In cart", 'class': "my-btn in-cart"} :
                {'text':"Add to cart", 'class': "my-btn add-to-cart"};
            }
        });


        $scope.addToCart = function()
        {
            if(! Cart.has($scope.product))
            {
                Cart.addProduct($scope.product);

                $scope.cartBtn = {'text': "In cart", 'class': "my-btn in-cart"};
            }
        };

    }])


    .controller('CartController', ['$scope', 'Cart', 'ModalProduct', function ($scope, Cart, ModalProduct) {

        $scope.products = Cart.getProducts();

        $scope.getSubTotal = function(product)
        {
            return product.price * product.quantity;
        };

        $scope.getTotal = function()
        {
            var total = 0;

            for(var i = 0; i < $scope.products.length; i++)
            {
                total += $scope.getSubTotal($scope.products[i]);
            }

            return total;
        }

        $scope.openProduct = function(product)
        {
            ModalProduct.open(product);
        };

        $scope.removeProduct = function(product)
        {
            Cart.removeProduct(product);
        };
    }])

    .controller('CheckoutController', ['$scope', function ($scope) {

    }])
    .controller('ProductsController', ['$scope', function ($scope) {

    }])
    .controller('HeaderController', ['$scope', 'Cart', function ($scope, Cart) {
        $scope.cart = Cart;

        $scope.launchCart = function()
        {
            window.location.href = '/cart';
        }

    }]);
