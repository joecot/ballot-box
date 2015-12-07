/*global angular*/
var ballotboxApp = angular.module(
    'ballotboxApp',
    [
        'ngRoute',
        'ballotboxControllers',
        'ui.bootstrap',
        'ui.bootstrap.datetimepicker'
    ]
);
ballotboxApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/index', {
        templateUrl: 'template/index.html',
        controller: 'indexController'
      }).
      when('/ballot/create', {
        templateUrl: 'template/ballotCreate.html',
        controller: 'ballotCreateController'
      }).
      when('/ballot/:ballotId', {
        templateUrl: 'template/ballotEdit.html',
        controller: 'ballotEditController'
      }).
      otherwise({
        redirectTo: '/index'
      });
  }]);