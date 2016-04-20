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
      available: {method:'GET', params:{ballotId:'available'}, isArray:true},
      voteinfo: {method:'GET', url: 'index.php/API/ballots/:ballotId/voteinfo', isArray:false}
    });
  }]);
ballotboxServices.factory('Question', ['$resource',
  function($resource){
    return $resource('index.php/API/ballots/:ballotId/question/:questionId', { ballotId: '@ballotId', questionId: '@id' }, {
      reorder: {method:'POST', params:{ballotId:'@ballotId', questionId: 'reorder'}, isArray:true},
      restore: {method:'POST', url: 'index.php/API/ballots/:ballotId/question/:questionId/restore', params:{ballotId:'@ballotId', questionId: '@id'}, isArray:false},
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

ballotboxServices.factory('Vote', ['$resource',
  function($resource){
    return $resource('index.php/API/ballots/:ballotId/vote/:voteId', { ballotId: '@ballotId', voteId: '@id' }, {
      
    });
  }]);
  

ballotboxServices.factory('Affiliate', ['$resource',
  function($resource){
    return $resource('index.php/API/affiliate', {}, {
    });
  }]);