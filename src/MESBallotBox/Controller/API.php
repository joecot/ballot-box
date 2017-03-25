<?php namespace MESBallotBox\Controller;

class API{
    function route($slim){
        $slim->group('users/', function(){
            $this->get('current', function ($request, $response) {
                echo json_encode($_ENV['ballot_user']);
            });
            $this->get('me', function ($request, $response) {
                echo json_encode(\MESBallotBox\Controller\Hub::getUser('me'));
            });
            $this->get('orgUnitIds', function ($request, $response,$args) {
                $ids = \MESBallotBox\Controller\Hub::getUserOrgIds();
                
                return $response->write(json_encode($ids));
            });
            $this->get('{membershipNumber}', function ($request, $response,$args) {
                $q = new \MESBallotBox\Propel\UserQuery();
                $user = $q->filterByMembershipNumber($args['membershipNumber'])->findOne();
                if(!$user){
                    $userInfo = \MESBallotBox\Controller\Hub::getUser($args['membershipNumber']);
                    //$userInfo = \MESBallotBox\Controller\Oauth::LookupByMembershipNumber($args['membershipNumber']);
                    if(!$userInfo['membershipNumber']){
                        return $response->withStatus(400)->write('User not found');
                    }
                    $user = new \MESBallotBox\Propel\User();
                    $user->fromArray($userInfo);
                    $user->save();
                }
                return $response->write($user->toJSON());
            });
            $this->get('fresh/{membershipNumber}', function ($request, $response,$args) {
                $userInfo = \MESBallotBox\Controller\Hub::getUser($args['membershipNumber']);
                return $response->write(json_encode($userInfo));
            });
            
        });
        $slim->group('ballots', function(){
            \MESBallotBox\Controller\Ballot::route($this);
        });
        $slim->group('votes', function(){
            \MESBallotBox\Controller\Vote::route($this);
        });
        $slim->get('affiliate', function($request, $response){
            $q = new \MESBallotBox\Propel\AffiliateQuery();
            $affiliates = $q->orderById()->find();
            $results = Array();
            foreach($affiliates as $affiliate){
                $results[] = $affiliate->toArray();
            }
            
            return $response->write(json_encode($results)); 
        });
        $slim->get('orgUnit',function($request,$response){
            $query = $request->getQueryParams();
            $orgUnits = \MESBallotBox\Controller\Hub::getOrgUnits($query);
            return json_encode($orgUnits);
        });
        $slim->get('orgUnit/{unitId}',function($request,$response,$args){
            $query = $request->getQueryParams();
            $orgUnit = \MESBallotBox\Controller\Hub::getOrgUnit($args['unitId'],$query);
            return json_encode($orgUnit);
        });
    }
}