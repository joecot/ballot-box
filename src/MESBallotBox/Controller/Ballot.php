<?php namespace MESBallotBox\Controller;

class Ballot{
    function route($slim){
        $slim->post('', function($request, $response){
            $vars = $request->getParsedBody();

            $ballot = new \MESBallotBox\Propel\Ballot();
            $ballot->setName($vars['name']);
            $ballot->setTimezone($vars['timezone']);
            $ballot->setStartDate($vars['start']);
            $ballot->setEndDate($vars['end']);
            $ballot->setUserId($_SESSION['user']['id']);
            $ballot->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$ballot->validate()){
                return $response->withStatus(400)->write($ballot->getValidationFailures()->__toString());
            }
            try{
                $ballot->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write($ballot->toJSON());
        });
        $slim->get('', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\BallotQuery();
            $ballots = $q->filterByUserId($_SESSION['user']['id'])->find();
            $results = Array();
            foreach($ballots as $ballot){
                $result = Array();
                $result['id'] = $ballot->getId();
                $result['name'] = $ballot->getName();
                $result['start'] = $ballot->getStartDate();
                $result['end'] = $ballot->getEndDate();
                $result['timezone'] = $ballot->getTimezoneNice();
                $results[] = $result;
            }
            
            return $response->write(json_encode($results));
        });
        $slim->get('/available', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\BallotQuery();
            $time = time();
            $ballots = $q::create()
                        ->join('Ballot.Voter')
                        ->condition('byUser', 'Voter.userId = ?', $_SESSION['user']['id'])
                        ->condition('byAffiliate', 'Voter.affiliateId = ?', $_SESSION['user']['affiliateId'])
                        ->where(Array('byUser', 'byAffiliate'), 'or')
                        ->where('Ballot.startTime < ?', $time)
                        ->where('Ballot.endTime > ?', $time)
                        ->groupBy('Ballot.id')
                        ->find();
            $results = Array();
            foreach($ballots as $ballot){
                $result = Array();
                $result['id'] = $ballot->getId();
                $result['name'] = $ballot->getName();
                $result['start'] = $ballot->getStartDate();
                $result['end'] = $ballot->getEndDate();
                $result['timezone'] = $ballot->getTimezoneNice();
                $results[] = $result;
            }
            
            return $response->write(json_encode($results));
        });
        $slim->get('/{ballotId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\BallotQuery();
            $ballot = $q->findPK($args['ballotId']);
            $result = Array();
            $result['id'] = $ballot->getId();
            $result['name'] = $ballot->getName();
            $result['start'] = $ballot->getStartDate();
            $result['startArray'] = $ballot->getStartArray();
            $result['end'] = $ballot->getEndDate();
            $result['endArray'] = $ballot->getEndArray();
            $result['timezone'] = $ballot->getTimezone();
            $result['timezoneNice'] = $ballot->getTimezoneNice();
            return $response->write(json_encode($result));
        });
        $slim->post('/{ballotId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\BallotQuery();
            $ballot = $q->findPK($args['ballotId']);
            $vars = $request->getParsedBody();
            $ballot->setName($vars['name']);
            $ballot->setTimezone($vars['timezone']);
            $ballot->setStartDate($vars['start']);
            $ballot->setEndDate($vars['end']);
            $ballot->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$ballot->validate()){
                return $response->withStatus(400)->write($ballot->getValidationFailures()->__toString());
            }
            try{
                $ballot->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write($ballot->toJSON());
        });
        $slim->get('/{ballotId}/voter', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\VoterQuery();
            $voters = $q->filterByBallotId($args['ballotId'])->find();
            $results = Array();
            foreach($voters as $voter){
                if($voter->getUserId()) $results[] = array_merge($voter->getUser()->toArray(), $voter->toArray());
                else $results[] = array_merge($voter->getAffiliate()->toArray(), $voter->toArray());
            }
            return $response->write(json_encode($results));
        });
        $slim->post('/{ballotId}/voter', function($request, $response){
            $vars = $request->getParsedBody();
            $q = new \MESBallotBox\Propel\VoterQuery();
            $voter = new \MESBallotBox\Propel\Voter();
            $voter->setBallotId($vars['ballotId']);
            if($vars['membershipNumber'] && $vars['affiliateId']){
                return $response->withStatus(400)->write('Fill in EITHER Membership Number OR Affiliate');
            }
            if($vars['membershipNumber']){
                $user = \MESBallotBox\Controller\Ballot::getUser($vars['membershipNumber']);
                if(!$user) return $response->withStatus(400)->write('User not found');
                $existingVoter = $q->filterByBallotId($vars['ballotId'])->filterByUserId($user->getId())->findOne();
                if($existingVoter) return $response->withStatus(400)->write('Already Added');
                $voter->setUserId($user->getId());
            }
            elseif ($vars['affiliateId']) {
                $existingVoter = $q->filterByBallotId($vars['ballotId'])->filterByAffiliateId($vars['affiliateId'])->findOne();
                if($existingVoter) return $response->withStatus(400)->write('Already Added');
                $voter->setAffiliateId($vars['affiliateId']);
            }
            else{
                return $response->withStatus(400)->write('Either affiliate or member is required');
            }
            
            $voter->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$voter->validate()){
                return $response->withStatus(400)->write($voter->getValidationFailures()->__toString());
            }
            try{
                $voter->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write($voter->toJSON());
        });
        $slim->get('/{ballotId}/question', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $questions = $q->filterByBallotId($args['ballotId'])->find();
            $results = Array();
            foreach($questions as $question){
                $results[] = $question->toArray();
            }
            
            return $response->write(json_encode($results));
        });
        $slim->get('/{ballotId}/question/{questionId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $question = $q->findPK($args['questionId']);
            
            return $response->write($question->toJSON());
        });
        $slim->post('/{ballotId}/question', function($request, $response){
            $vars = $request->getParsedBody();

            $question = new \MESBallotBox\Propel\Question();
            $question->fromArray($vars);
            $question->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$question->validate()){
                return $response->withStatus(400)->write($question->getValidationFailures()->__toString());
            }
            try{
                $question->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write($question->toJSON());
        });
        $slim->post('/{ballotId}/question/{questionId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $question = $q->findPK($args['questionId']);
            $vars = $request->getParsedBody();
            
            $question->fromArray($vars);
            $question->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$question->validate()){
                return $response->withStatus(400)->write($question->getValidationFailures()->__toString());
            }
            try{
                $question->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write($question->toJSON());
        });
        $slim->post('/{ballotId}/question/{questionId}/candidate', function($request, $response, $args){
            $vars = $request->getParsedBody();
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $question = $q->findPK($vars['questionId']);
            
            $user = \MESBallotBox\Controller\Ballot::getUser($vars['membershipNumber']);
            if(!$user) return $response->withStatus(400)->write('User not found');
            
            $candidate = new \MESBallotBox\Propel\Candidate();
            $candidate->setQuestionId($question->getId());
            $candidate->setUserId($user->getId());
            $candidate->setApplication($vars['application']);
            $candidate->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$candidate->validate()){
                return $response->withStatus(400)->write($candidate->getValidationFailures()->__toString());
            }
            try{
                $candidate->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write($candidate->toJSON());
        });
        $slim->get('/{ballotId}/question/{questionId}/candidate', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\CandidateQuery();
            $candidates = $q->filterByQuestionId($args['questionId'])->find();
            $results = Array();
            foreach($candidates as $candidate){
                $results[] = array_merge($candidate->getUser()->toArray(), $candidate->toArray());
            }
            return $response->write(json_encode($results));
        });
    }
    function getUser($membershipNumber){
        $q = new \MESBallotBox\Propel\UserQuery();
        $user = $q->filterByMembershipNumber($membershipNumber)->findOne();
        if(!$user){
            $userInfo = \MESBallotBox\Controller\Oauth::LookupByMembershipNumber($membershipNumber);
            if(!$userInfo['membershipNumber']){
                return false;
            }
            $user = new \MESBallotBox\Propel\User();
            $user->fromArray($userInfo);
            $user->save();
        }
        return $user;
    }
}