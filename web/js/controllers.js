/*global angular*/
var ballotboxControllers = angular.module('ballotboxControllers', []);

ballotboxControllers.controller('indexController', ['$scope', '$http', '$location', function($scope, $http, $location) {
    $http.get("/API/user")
        .then(
            function successCallback(response) {
                console.log(response.data);
                $scope.user = response.data;
            },
            function errorCallback(response){
                if(response.status == 401){
                    window.location = '/login?jspath='+$location.path();
                }
            }
        );
}]);

ballotboxControllers.controller('ballotCreateController', ['$scope', '$http', '$location', function($scope, $http, $location) {
    $scope.ballot={};
    $scope.ballot.start = new Date();
    $scope.ballot.start.setDate($scope.ballot.start.getDate()+1);
    $scope.ballot.start.setHours(0);
    $scope.ballot.start.setMinutes(0);
    $scope.ballot.start.setSeconds(0);
    $scope.ballot.end = new Date();
    $scope.ballot.end.setDate($scope.ballot.start.getDate()+6);
    $scope.ballot.end.setHours(23);
    $scope.ballot.end.setMinutes(59);
    $scope.ballot.end.setMinutes(59);
    $scope.ballot.timezone='1';
    $scope.add = function(ballot){
        console.log(ballot);
        var postballot = angular.copy(ballot);
        var start = postballot.start;
        var end = postballot.end;
        postballot.start = start.getFullYear()+'-'+start.getMonth()+'-'+start.getDate()+' '+start.getHours()+':'+start.getMinutes()+':0';
        postballot.end = end.getFullYear()+'-'+end.getMonth()+'-'+end.getDate()+' '+end.getHours()+':'+end.getMinutes()+':59';
        console.log(postballot);
        $http.post("/API/ballot/new",postballot)
            .then(
                function successCallback(response) {
                    $location.path( "/ballot/"+response.data.id );
                },
                function errorCallback(response){
                    if(response.status == 401){
                        window.location = '/login?jspath='+$location.path();
                    }
                    console.log(response.data);
                }
            );
    };
}]);

ballotboxControllers.controller('ballotEditController', ['$scope', '$http', '$location', '$routeParams', function($scope, $http, $location, $routeParams) {
    $http.get("/API/ballot/"+$routeParams.ballotId)
    .then(
        function successCallback(response) {
            console.log(response.data);
            $scope.ballot = response.data;
        },
        function errorCallback(response){
            if(response.status == 401){
                window.location = '/login?jspath='+$location.path();
            }
            console.log(response.data);
        }
    );
}]);