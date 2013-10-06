'use strict';


// Declare app level module which depends on filters, and services
angular.module('qbrando', ['qbrando.filters', 'qbrando.services', 'qbrando.directives', 'qbrando.controllers', 'ngRoute', 'ngResource']).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/home', {templateUrl: 'partials/home.html', controller: 'HomeController'});
    $routeProvider.when('/product', {templateUrl: 'partials/product.html', controller: 'ProductController'});
    $routeProvider.when('/cart', {templateUrl: 'partials/cart.html', controller: 'CartController'});
    $routeProvider.when('/checkout', {templateUrl: 'partials/checkout.html', controller: 'CheckoutController'});
    $routeProvider.otherwise({redirectTo: '/home'});
  }]);
