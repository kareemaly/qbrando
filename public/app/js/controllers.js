'use strict';

/* Controllers */

angular.module('qbrando.controllers', ['qbrando.services']).

    controller('HomeController', ['$scope', function ($scope) {
        $scope.slider = {show: true};

    }])


    .controller('SliderController', ['$scope', 'Slider', function ($scope, Slider) {
        console.log(Slider);

    }])


    .controller('CartController', ['$scope', function ($scope) {

    }])

    .controller('CheckoutController', ['$scope', function ($scope) {

    }])


    .controller('ProductController', [function () {
    }]);