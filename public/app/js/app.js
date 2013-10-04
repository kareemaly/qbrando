'use strict';


// Declare app level module which depends on filters, and services
angular.module('qbrando', ['qbrando.filters', 'qbrando.services', 'qbrando.directives', 'qbrando.controllers']).
  config(['$routeProvider', function($routeProvider) {
    $routeProvider.when('/home', {templateUrl: 'partials/home.html', controller: 'HomeController'});
    $routeProvider.when('/product', {templateUrl: 'partials/product.html', controller: 'ProductController'});
    $routeProvider.otherwise({redirectTo: '/home'});
  }]);
