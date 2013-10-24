'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('qbrando.services', []).

    factory('ModalProduct', function ($resource, $http) {

        var currentProduct = null;

        return {

            getProduct: function() {
                return currentProduct;
            },

            open: function ( product ) {

                currentProduct = product;

                var element = $("#productModal");

                element.find('.modal-title').html(product.title);

                $http.get('/partials/product/' + product.id).success(function(data)
                {
                    element.find('.modal-body').html(data);
                });
            }
        };
    })

    .factory('Cart', function( $resource ) {

        var cart = $resource('/cart/:id');

        var products = cart.query();

        return {
            getProducts: function() {

                return products;
            },

            addProduct: function( product ) {

                cart.save({productId: product.id});

                products.push(product);
            },


            has: function(product) {

                if(product == null) return false;

                for(var i = 0; i < products.length; i++)
                {
                    if(product.id == products[i].id) return true;
                }

                return false;
            },

            totalProducts: function() {

                return products.length;
            },

            removeProduct: function(product) {

                cart.remove({id: product.id});

                for(var i = 0; i < products.length; i++)
                {
                    if(products[i].id == product.id)
                        products.splice(i, 1);
                }
            }
        };
    });