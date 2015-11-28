/*global angular*/
var ballotboxApp = angular.module(
    'ballotboxApp',
    [
        'ngRoute',
        'ballotboxControllers'
    ]
);
ballotboxApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/index', {
        templateUrl: 'template/index.html',
        controller: 'indexController'
      }).
      otherwise({
        redirectTo: '/index'
      });
  }]);