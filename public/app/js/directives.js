'use strict';

/* Directives */


angular.module('qbrando.directives', [])
    .directive('myCartBtn', [function () {
        return {
            'restrict': 'E',
            'product': '=product',
            'templateUrl': '/partials/add_to_cart_btn.html'
        }
    }]);
