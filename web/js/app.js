/*global angular*/
var ballotboxApp = angular.module(
    'ballotboxApp',
    [
        'ngRoute',
        'ballotboxControllers',
        'ui.bootstrap',
        'ui.bootstrap.datetimepicker',
        'ngResource',
        'ballotboxServices'
    ]
);
ballotboxApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/index', {
        templateUrl: '/templates/index.html',
        controller: 'indexController'
      }).
      when('/ballot/create', {
        templateUrl: '/templates/ballotCreate.html',
        controller: 'ballotCreateController'
      }).
      when('/ballot/:ballotId', {
        templateUrl: '/templates/ballotView.html',
        controller: 'ballotViewController'
      }).
      when('/ballot/:ballotId/question/create', {
        templateUrl: '/templates/ballotQuestionCreate.html',
        controller: 'ballotQuestionCreateController'
      }).
      otherwise({
        redirectTo: '/index'
      });
  }]);