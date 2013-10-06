'use strict';

/* Services */


// Demonstrate how to register services
// In this case it is a simple value service.
angular.module('qbrando.services', []).factory('Slider',

    ['$resource', function ($resource) {
        return $resource('/slider/').query();
    }]);