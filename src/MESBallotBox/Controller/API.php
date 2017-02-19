<?php namespace MESBallotBox\Controller;

class API{
    function route($slim){
        $slim->group('users/', function(){
            $this->get('current', function ($request, $response) {
                echo json_encode($_ENV['ballot_user']);
            });
            $this->get('{membershipNumber}', function ($request, $response,$args) {
                $q = new \MESBallotBox\Propel\UserQuery();
                $user = $q->filterByMembershipNumber($args['membershipNumber'])->findOne();
                if(!$user){
                    $userInfo = \MESBallotBox\Controller\Oauth::LookupByMembershipNumber($args['membershipNumber']);
                    if(!$userInfo['membershipNumber']){
                        return $response->withStatus(400)->write('User not found');
                    }
                    $user = new \MESBallotBox\Propel\User();
                    $user->fromArray($userInfo);
                    $user->save();
                }
                return $response->write($user->toJSON());
            });
        });
        $slim->group('ballots', function(){
            \MESBallotBox\Controller\Ballot::route($this);
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
    }
}