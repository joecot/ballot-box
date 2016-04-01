/*global angular*/
var ballotboxServices = angular.module('ballotboxServices', ['ngResource']);

ballotboxServices.factory('User', ['$resource',
  function($resource){
    return $resource('API/users/:userId', { userId: '@id' }, {
      query: {method:'GET', params:{userId:'current'}, isArray:false}
    });
  }]);

ballotboxServices.factory('Ballot', ['$resource',
  function($resource){
    return $resource('API/ballots/:ballotId', { ballotId: '@id' }, {
      
    });
  }]);
ballotboxServices.factory('BallotQuestion', ['$resource',
  function($resource){
    return $resource('API/ballots/:ballotId/questions/:questionId', { ballotId: '@ballotId', questionId: '@id' }, {
      
    });
  }]);
