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
      when('/ballot/:ballotId/edit', {
        templateUrl: '/templates/ballotEdit.html',
        controller: 'ballotEditController'
      }).
      when('/ballot/:ballotId', {
        templateUrl: '/templates/ballotView.html',
        controller: 'ballotViewController'
      }).
      when('/ballot/:ballotId/question/create', {
        templateUrl: '/templates/questionCreate.html',
        controller: 'questionCreateController'
      }).
      when('/ballot/:ballotId/question/:questionId', {
        templateUrl: '/templates/questionView.html',
        controller: 'questionViewController'
      }).
      when('/ballot/:ballotId/question/:questionId/edit', {
        templateUrl: '/templates/questionEdit.html',
        controller: 'questionEditController'
      }).
      otherwise({
        redirectTo: '/index'
      });
  }]);