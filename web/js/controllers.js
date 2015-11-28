/*global angular*/
var ballotboxControllers = angular.module('ballotboxControllers', []);

ballotboxControllers.controller('indexController', ['$scope', '$http', '$location', function($scope, $http, $location) {
    $http.get("/API/user")
        .then(
            function successCallback(response) {
                $scope.user = response.data;
            },
            function errorCallback(response){
                if(response.status == 401){
                    window.location = '/login?jspath='+$location.path();
                }
            }
        );
}]);