'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('qbrando.services', []).

    factory('ModalProduct', function ($resource, $http) {
        return {
            openModal: function ( productId, productTitle ) {

                var element = $("#productModal");

                element.find('.modal-title').html(productTitle);

                $http.get('partials/product/' + productId).success(function(data)
                {
                    element.find('.modal-body').html(data);
                });

                return $resource('/product/:id').get({id:productId});
            }
        };
    })

    .factory('Cart', function( $resource ) {

        var cart = $resource('cart/:id');

        var products = cart.query();

        var totalProducts = products.length;

        return {
            getProducts: function() {

                return products;
            },

            addProduct: function( productId ) {

                cart.save({productId: productId});
                totalProducts ++;
            },

            totalProducts: function() {

                return totalProducts;
            }
        };
    });