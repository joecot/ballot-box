/*global angular*/
var ballotboxServices = angular.module('ballotboxServices', ['ngResource']);

ballotboxServices.factory('User', ['$resource',
  function($resource){
    return $resource('index.php/API/users/:userId', { userId: '@id' }, {
      query: {method:'GET', params:{userId:'current'}, isArray:false}
    });
  }]);

ballotboxServices.factory('Ballot', ['$resource',
  function($resource){
    return $resource('index.php/API/ballots/:ballotId', { ballotId: '@id' }, {
      available: {method:'GET', params:{ballotId:'available'}, isArray:true}
    });
  }]);
ballotboxServices.factory('Question', ['$resource',
  function($resource){
    return $resource('index.php/API/ballots/:ballotId/question/:questionId', { ballotId: '@ballotId', questionId: '@id' }, {
      
    });
  }]);

ballotboxServices.factory('Candidate', ['$resource',
  function($resource){
    return $resource('index.php/API/ballots/:ballotId/question/:questionId/candidate/:candidateId', { ballotId: '@ballotId', questionId: '@questionId', candidateid: '@id' }, {
      
    });
  }]);

ballotboxServices.factory('Voter', ['$resource',
  function($resource){
    return $resource('index.php/API/ballots/:ballotId/voter/:voterId', { ballotId: '@ballotId', voterid: '@id' }, {
      
    });
  }]);

ballotboxServices.factory('Affiliate', ['$resource',
  function($resource){
    return $resource('index.php/API/affiliate', {}, {
    });
  }]);