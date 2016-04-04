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
        $slim->get('/{ballotId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\BallotQuery();
            $ballot = $q->findPK($args['ballotId']);
            $result = Array();
            $result['id'] = $ballot->getId();
            $result['name'] = $ballot->getName();
            $result['start'] = $ballot->getStartDate();
            $result['end'] = $ballot->getEndDate();
            $result['timezone'] = $ballot->getTimezoneNice();
            return $response->write(json_encode($result));
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
            
            $q = new \MESBallotBox\Propel\UserQuery();
            $user = $q->filterByMembershipNumber($vars['membershipNumber'])->findOne();
            if(!$user){
                $userInfo = \MESBallotBox\Controller\Oauth::LookupByMembershipNumber($vars['membershipNumber']);
                if(!$userInfo['remoteId']){
                    return $response->withStatus(400)->write('User not found');
                }
                $user = new \MESBallotBox\Propel\User();
                $user->fromArray($userInfo);
                $user->save();
            }
            
            $candidate = new \MESBallotBox\Propel\Candidate();
            $candidate->setQuestionId($question->getId());
            $candidate->setUserId($user->getId());
            $candidate->setApplication($vars['application']);
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
}