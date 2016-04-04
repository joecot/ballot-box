/*global angular*/
var ballotboxControllers = angular.module('ballotboxControllers', []);

ballotboxControllers.controller('indexController', ['$scope', '$http', '$location', 'User', 'Ballot', function($scope, $http, $location, User, Ballot) {
    $scope.user = User.query({},
        function successCallback(response) {
                $scope.ballots = Ballot.query();
            },
            function errorCallback(response){
                if(response.status == 401){
                    window.location = '/index.php/login?jspath='+$location.path();
                }
            }
        );
}]);

ballotboxControllers.controller('ballotCreateController', ['$scope', '$http', '$location', 'User', 'Ballot', function($scope, $http, $location, User, Ballot) {
    $scope.ballot= new Ballot();
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
        postballot.$save(
            function successCallback(response) {
                    console.log('saved ballot');
                    console.log(response);
                    console.log("/ballot/"+response.id);
                    $location.path( "/ballot/"+response.id );
            },
            function errorCallback(response){
                if(response.status == 401){
                    window.location = '/index.php/login?jspath='+$location.path();
                }
                console.log(response.data);
            }
        );
        
    };
}]);

ballotboxControllers.controller('ballotViewController', ['$scope', '$http', '$location', '$routeParams', 'User', 'Ballot', 'Question', function($scope, $http, $location, $routeParams, User, Ballot, Question) {
    $scope.ballot = Ballot.get({'ballotId': $routeParams.ballotId},
        function successCallback(response) {
            $scope.questions = Question.query({'ballotId': $routeParams.ballotId});
        },
        function errorCallback(response){
            if(response.status == 401){
                window.location = '/index.php/login?jspath='+$location.path();
            }
            console.log(response.data);
        }
    );
}]);

ballotboxControllers.controller('questionCreateController', ['$scope', '$http', '$location', 'User', '$routeParams', 'Ballot', 'Question', function($scope, $http, $location, User, $routeParams, Ballot, Question) {
    $scope.question= new Question();
    $scope.question.type="office";
    $scope.question.count=1;
    $scope.add = function(question){
        question.ballotId=$routeParams.ballotId;
        question.$save(
            function successCallback(response) {
                    console.log('saved question');
                    console.log(response);
                    console.log(question);
                    if(question.type=='office')
                        var path = "/ballot/"+$routeParams.ballotId+'/question/'+question.id;
                    else
                        var path = "/ballot/"+$routeParams.ballotId;
                    console.log(path);
                    $location.path(path);
            },
            function errorCallback(response){
                if(response.status == 401){
                    window.location = '/index.php/login?jspath='+$location.path();
                }
                console.log(response.data);
            }
        );
        
    };
}]);

ballotboxControllers.controller('questionViewController', ['$scope', '$http', '$location', '$routeParams', 'User', 'Ballot', 'Question', 'Candidate', function($scope, $http, $location, $routeParams, User, Ballot, Question, Candidate) {
    $scope.question = Question.get({'ballotId': $routeParams.ballotId, 'questionId': $routeParams.questionId},
        function successCallback(response) {
            //$scope.questions = Question.query({'ballotId': $routeParams.ballotId});
            $scope.newcandidate= new Candidate();
            $scope.newcandidate.questionId = $scope.question.id;
            $scope.newcandidate.ballotId = $scope.question.ballotId;
            $scope.candidates = Candidate.query({ballotId: $scope.question.ballotId, questionId: $scope.question.id});
        },
        function errorCallback(response){
            if(response.status == 401){
                window.location = '/index.php/login?jspath='+$location.path();
            }
            console.log(response.data);
        }
    );
    
    $scope.addCandidateForm = false;
    $scope.showAddCandidateForm = function(){
        $scope.addCandidateForm=true;
    }
    $scope.addCandidate = function (newcandidate){
        newcandidate.$save(
            function successCallback(response) {
                    console.log('saved question');
                    console.log(response);
                    console.log(newcandidate);
                    $scope.newcandidate = new Candidate();
                    $scope.newcandidate.questionId = $scope.question.id;
                    $scope.newcandidate.ballotId = $scope.question.ballotId;
                    $scope.candidates = Candidate.query({ballotId: $scope.question.ballotId, questionId: $scope.question.id});
            },
            function errorCallback(response){
                if(response.status == 401){
                    window.location = '/index.php/login?jspath='+$location.path();
                }
                console.log(response.data);
            }
        );
    }
}]);
