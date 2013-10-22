'use strict';

/* Controllers */

angular.module('qbrando.controllers', ['qbrando.services']).

    controller('HomeController', ['$scope', function ($scope) {

    }])


    .controller('ProductController', ['$scope', '$element', 'ModalProduct', 'Cart', function ($scope, $element, ModalProduct, Cart) {

        $scope.openProduct = function( productId, productTitle )
        {
            ModalProduct.openModal(productId, productTitle);
        };

        $scope.addToCart = function( productId )
        {
            $element.fadeTo(200, '0.2').delay(500).fadeTo(200, 1);
            Cart.addProduct( productId);

            // Change add cart button to in cart button
            var btn = $element.find('.buttons > div');
            btn.html('In cart');
            btn.removeClass('btn-black');
            btn.addClass('btn-purple');
        };
    }])

    .controller('ModalController', ['$scope', function ($scope) {

    }])


    .controller('CartController', ['$scope', function ($scope) {

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
