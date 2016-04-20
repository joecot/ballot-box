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
        $slim->get('/{ballotId}/voteinfo', function($request, $response, $args){
            $ballot = \MESBallotBox\Controller\Ballot::getVoterBallot($args['ballotId']);
            if(!$ballot){
                return $response->withStatus(400)->write('Ballot not available for voting.');
            }
            $result = Array();
            $result['id'] = $ballot->getId();
            $result['name'] = $ballot->getName();
            $result['start'] = $ballot->getStartDate();
            $result['startArray'] = $ballot->getStartArray();
            $result['end'] = $ballot->getEndDate();
            $result['endArray'] = $ballot->getEndArray();
            $result['timezone'] = $ballot->getTimezone();
            $result['timezoneNice'] = $ballot->getTimezoneNice();
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $questions = $q->filterByBallotId($args['ballotId'])->orderById()->find();
            if($questions){
                $questionsresult = Array();
                foreach($questions as $question){
                    $questionresult = $question->toArray();
                    if($questionresult['type'] == 'office'){
                        $candidateresults = Array();
                        $candidates = \MESBallotBox\Propel\CandidateQuery::create()->filterByQuestionId($question->getId())->orderById()->find();
                        foreach($candidates as $candidate){
                            $candidateresults[] = array_merge($candidate->getUser()->toArray(), $candidate->toArray());
                        }
                        $questionresult['candidates'] = $candidateresults;
                    }
                    $questionsresult[] = $questionresult;
                }
                $result['questions'] = $questionsresult;
            }
            
            $vote = \MESBallotBox\Propel\VoteQuery::create()->filterByBallotId($ballot->getId())->filterbyUserId($_SESSION['user']['id'])->findOne();
            if($vote) $result['voteId'] = $vote->getId();
            else{
                $invalid_message = \MESBallotBox\Controller\Ballot::checkInvalidVoter($ballot);
                if($invalid_message) $result['invalid'] = $invalid_message;
            }
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
            $q->filterByBallotId($args['ballotId']);
            $params = $request->getQueryParams();
            if(!$params['show_deleted'] || $params['show_deleted'] == 'false') $q->filterByIsDeleted(0);
            $questions = $q->orderByorderId()->find();
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
            $max_question = \MESBallotBox\Propel\QuestionQuery::create()->filterByBallotId($question->getBallotId())->orderByorderId()->findOne();
            if(!$max_question) $question->setOrderId(1);
            else $question->setOrderId($max_question->getOrderId()+1);
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
        $slim->post('/{ballotId}/question/reorder', function($request, $response, $args){
            $ballot = \MESBallotBox\Propel\BallotQuery::create()->findPK($args['ballotId']);
            if(!$ballot){
                return $response->withStatus(400)->write('Ballot not found.');
            }
            $vars = $request->getParsedBody();
            foreach($vars['questions'] as $var_question){
                $question = \MESBallotBox\Propel\QuestionQuery::create()->findPK($var_question['id']);
                if(!$question || $question->getBallotId() != $ballot->getId()){
                    return $response->withStatus(400)->write('Question not found.');
                }
                $question->setOrderId($var_question['orderId']);
                $question->setVersionCreatedBy($_SESSION['user']['id']);
                try{
                    $question->save();
                }catch(Exception $e){
                    return $response->withStatus(500)->write($e->getMessage());
                }
            }
            $questions = \MESBallotBox\Propel\QuestionQuery::create()->filterByBallotId($args['ballotId'])->orderByorderId()->find();
            $results = Array();
            foreach($questions as $question){
                $results[] = $question->toArray();
            }
            
            return $response->write(json_encode($results));
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
        $slim->delete('/{ballotId}/question/{questionId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $question = $q->findPK($args['questionId']);
            
            $question->SetIsDeleted(1);
            $question->SetOrderId(1000);
            $question->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$question->validate()){
                return $response->withStatus(400)->write($question->getValidationFailures()->__toString());
            }
            try{
                $question->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write(json_encode($question->toArray()));
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
        $slim->post('/{ballotId}/vote', function($request, $response,$args){
            $vars = $request->getParsedBody();
            $ballot = \MESBallotBox\Controller\Ballot::getVoterBallot($args['ballotId']);
            if(!$ballot){
                return $response->withStatus(400)->write('Ballot not available for voting.');
            }
            $invalid_message = \MESBallotBox\Controller\Ballot::checkInvalidVoter($ballot);
            if($invalid_message){
                return $response->withStatus(400)->write($invalid_message);
            }
            $vote = new \MESBallotBox\Propel\Vote();
            $vote->setBallotId($ballot->getId());
            $vote->setUserId($_SESSION['user']['id']);
            $vote->setVersionCreatedBy($_SESSION['user']['id']);
            if(!$vote->validate()){
                return $response->withStatus(400)->write($vote->getValidationFailures()->__toString());
            }
            
            if(!$vars['voteItem']){
                return $response->withStatus(400)->write('Vote answers required');
            }
            $voteItems = Array();
            foreach($vars['voteItem'] as $vars_voteItem){
                if(!$vars_voteItem['questionId']) return $response->withStatus(400)->write('Vote question required');
                $question = \MESBallotBox\Propel\QuestionQuery::create()->filterByBallotId($ballot->getId())->filterById($vars_voteItem['questionId'])->findOne();
                if(!$question) return $response->withStatus(400)->write('Question invalid');
                
                if($question->getType() == 'proposition'){
                    $voteItem = new \MESBallotBox\Propel\VoteItem();
                    $voteItem->setQuestionId($question->getId());
                    if(in_array($vars_voteItem['answer'],Array(0,1,2))){
                        $voteItem->setAnswer($vars_voteItem['answer']);
                    }
                    else{
                        return $response->withStatus(400)->write('Question answer required');
                    }
                    if(!$voteItem->validate()){
                        return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                    }
                    $voteItems[] = $voteItem;
                }
                elseif($question->getType() == 'office'){
                    if(!$vars_voteItem['candidates']){
                        return $response->withStatus(400)->write('Question candidates required');
                    }
                    $ranking = Array();
                    $noranking = Array();
                    foreach($vars_voteItem['candidates'] as $var_candidate){
                        if(!empty($var_candidate['candidateId'])){
                            $candidate = \MESBallotBox\Propel\CandidateQuery::create()->filterByQuestionId($question->getId())->filterById($var_candidate['candidateId'])->findOne();
                            if(!$candidate) return $response->withStatus(400)->write('Question candidates required');
                        }else $var_candidate['candidateId'] = 0;
                        
                        if(!$var_candidate['answer']){
                            $noranking[] = $var_candidate['candidateId'];
                        }
                        elseif(isset($ranking[$var_candidate['answer']])){
                            return $response->withStatus(400)->write('Duplicate candidate ranking');
                        }
                        else $ranking[$var_candidate['answer']] = $var_candidate['candidateId'];
                    }
                    ksort($ranking);
                    $i = 0;
                    foreach($ranking as $rankItem){
                        $i++;
                        $voteItem = new \MESBallotBox\Propel\VoteItem();
                        $voteItem->setQuestionId($question->getId());
                        $voteItem->setCandidateId($rankItem);
                        $voteItem->setAnswer($i);
                        if(!$voteItem->validate()){
                            return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                        }
                        $voteItems[] = $voteItem;
                    }
                    if($noranking){
                        $none_rank = array_search(0,$noranking);
                        if($none_rank!==false){
                            unset($noranking[$none_rank]);
                            $i++;
                            $voteItem = new \MESBallotBox\Propel\VoteItem();
                            $voteItem->setQuestionId($question->getId());
                            $voteItem->setCandidateId(0);
                            $voteItem->setAnswer($i);
                            $voteItems[] = $voteItem;
                        }
                        if($noranking) foreach($noranking as $rankItem){
                            $i++;
                            $voteItem = new \MESBallotBox\Propel\VoteItem();
                            $voteItem->setQuestionId($question->getId());
                            $voteItem->setCandidateId($rankItem);
                            $voteItem->setAnswer($i);
                            if(!$voteItem->validate()){
                                return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                            }
                            $voteItems[] = $voteItem;
                        }
                    }
                }
            }
            try{
                $vote->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            foreach($voteItems as $voteItem){
                $voteItem->setVoteId($vote->getId());
                try{
                    $voteItem->save();
                }catch(Exception $e){
                    return $response->withStatus(500)->write($e->getMessage());
                }
            }
            $result = \MESBallotBox\Controller\Ballot::getVoteResult($ballot,$vote);
            return $response->write(json_encode($result));
        });
        $slim->get('/{ballotId}/vote/{voteId}', function($request, $response,$args){
            $ballot = \MESBallotBox\Controller\Ballot::getVoterBallot($args['ballotId']);
            if(!$ballot){
                return $response->withStatus(400)->write('Ballot not available for voting.');
            }
            $vote = \MESBallotBox\Propel\VoteQuery::create()->filterByBallotId($args['ballotId'])->filterById($args['voteId'])->findOne();
            if(!$vote){
                return $response->withStatus(400)->write('Vote not found.');
            }
            if($vote->getUserId() != $_SESSION['user']['id']){
                if($ballot->getUserId() != $_SESSION['user']['id']){
                    return $response->withStatus(400)->write('Vote not accessible.');
                }
            }
            $result = \MESBallotBox\Controller\Ballot::getVoteResult($ballot,$vote);
            return $response->write(json_encode($result));
        });
        $slim->post('/{ballotId}/vote/{voteId}', function($request, $response,$args){
            $vars = $request->getParsedBody();
            $ballot = \MESBallotBox\Controller\Ballot::getVoterBallot($args['ballotId']);
            if(!$ballot){
                return $response->withStatus(400)->write('Ballot not available for voting.');
            }
            $vote = \MESBallotBox\Propel\VoteQuery::create()->filterByBallotId($args['ballotId'])->filterById($args['voteId'])->findOne();
            if(!$vote){
                return $response->withStatus(400)->write('Vote not found.');
            }
            if($vote->getUserId() != $_SESSION['user']['id']){
                if($ballot->getUserId() != $_SESSION['user']['id']){
                    return $response->withStatus(400)->write('Vote not accessible.');
                }
            }
            
            $vote->setVersionCreatedBy($_SESSION['user']['id']);
            $vote->setUpdatedAt(time());
            if(!$vars['voteItem']){
                return $response->withStatus(400)->write('Vote answers required');
            }
            $voteItems = Array();
            foreach($vars['voteItem'] as $vars_voteItem){
                if(!$vars_voteItem['questionId']) return $response->withStatus(400)->write('Vote question required');
                $question = \MESBallotBox\Propel\QuestionQuery::create()->filterByBallotId($ballot->getId())->filterById($vars_voteItem['questionId'])->findOne();
                if(!$question) return $response->withStatus(400)->write('Question invalid');
                
                if($question->getType() == 'proposition'){
                    $voteItem = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->findOne(); 
                    if(!$voteItem){
                        $voteItem = new \MESBallotBox\Propel\VoteItem();
                        $voteItem->setQuestionId($question->getId());
                    }
                    if(in_array($vars_voteItem['answer'],Array(0,1,2))){
                        $voteItem->setAnswer($vars_voteItem['answer']);
                    }
                    else{
                        return $response->withStatus(400)->write('Question answer required');
                    }
                    if(!$voteItem->validate()){
                        return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                    }
                    $voteItem->setVersionCreatedBy($_SESSION['user']['id']);
                    $voteItems[] = $voteItem;
                }
                elseif($question->getType() == 'office'){
                    if(!$vars_voteItem['candidates']){
                        return $response->withStatus(400)->write('Question candidates required');
                    }
                    $ranking = Array();
                    $noranking = Array();
                    foreach($vars_voteItem['candidates'] as $var_candidate){
                        if(!empty($var_candidate['candidateId'])){
                            $candidate = \MESBallotBox\Propel\CandidateQuery::create()->filterByQuestionId($question->getId())->filterById($var_candidate['candidateId'])->findOne();
                            if(!$candidate) return $response->withStatus(400)->write('Question candidates required');
                        }else $var_candidate['candidateId'] = 0;
                        
                        if(!$var_candidate['answer']){
                            $noranking[] = $var_candidate['candidateId'];
                        }
                        elseif(isset($ranking[$var_candidate['answer']])){
                            return $response->withStatus(400)->write('Duplicate candidate ranking');
                        }
                        else $ranking[$var_candidate['answer']] = $var_candidate['candidateId'];
                    }
                    ksort($ranking);
                    $i = 0;
                    foreach($ranking as $rankItem){
                        $i++;
                        $voteItem = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->filterByCandidateId($rankItem)->findOne();
                        if(!$voteItem){
                            $voteItem = new \MESBallotBox\Propel\VoteItem();
                            $voteItem->setQuestionId($question->getId());
                            $voteItem->setCandidateId($rankItem);
                        }
                        $voteItem->setAnswer($i);
                        $voteItem->setVersionCreatedBy($_SESSION['user']['id']);
                        if(!$voteItem->validate()){
                            return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                        }
                        $voteItems[] = $voteItem;
                    }
                    if($noranking){
                        $none_rank = array_search(0,$noranking);
                        if($none_rank!==false){
                            unset($noranking[$none_rank]);
                            $i++;
                            $voteItem = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->filterByCandidateId(0)->findOne();
                            if(!$voteItem){
                                $voteItem = new \MESBallotBox\Propel\VoteItem();
                                $voteItem->setQuestionId($question->getId());
                                $voteItem->setCandidateId(0);
                            }
                            $voteItem->setAnswer($i);
                            $voteItem->setVersionCreatedBy($_SESSION['user']['id']);
                            $voteItem = new \MESBallotBox\Propel\VoteItem();
                            if(!$voteItem->validate()){
                                return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                            }
                            $voteItems[] = $voteItem;
                        }
                        if($noranking) foreach($noranking as $rankItem){
                            $i++;
                            $voteItem = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->filterByCandidateId($rankItem)->findOne();
                            if(!$voteItem){
                                $voteItem = new \MESBallotBox\Propel\VoteItem();
                                $voteItem->setQuestionId($question->getId());
                                $voteItem->setCandidateId($rankItem);
                            }
                            $voteItem->setAnswer($i);
                            $voteItem->setVersionCreatedBy($_SESSION['user']['id']);
                            $voteItem = new \MESBallotBox\Propel\VoteItem();
                            if(!$voteItem->validate()){
                                return $response->withStatus(400)->write($voteItem->getValidationFailures()->__toString());
                            }
                            $voteItems[] = $voteItem;
                        }
                    }
                }
            }
            try{
                $vote->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            foreach($voteItems as $voteItem){
                $voteItem->setVoteId($vote->getId());
                try{
                    $voteItem->save();
                }catch(Exception $e){
                    return $response->withStatus(500)->write($e->getMessage());
                }
            }
            $result = \MESBallotBox\Controller\Ballot::getVoteResult($ballot,$vote);
            return $response->write(json_encode($result));
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
    function getVoterBallot($ballotId){
        $q = new \MESBallotBox\Propel\BallotQuery();
        $time=time();

        $ballot = $q::create()
            ->join('Ballot.Voter')
            ->condition('byUser', 'Voter.userId = ?', $_SESSION['user']['id'])
            ->condition('byAffiliate', 'Voter.affiliateId = ?', $_SESSION['user']['affiliateId'])
            ->where(Array('byUser', 'byAffiliate'), 'or')
            ->where('Ballot.startTime < ?', $time)
            ->where('Ballot.endTime > ?', $time)
            ->where('Ballot.id = ?',$ballotId)
            ->findOne();
        return $ballot;
    }
    function getVoteResult($ballot,$vote){
        $result = $vote->toArray();
        $result['voteItem'] = Array();
        $questions = \MESBallotBox\Propel\QuestionQuery::create()->filterByBallotId($ballot->getId())->orderById()->find();
        if(count($questions))foreach($questions as $question){
            
            if($question->getType() == 'proposition'){
                $answer = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->findOne();
                if($answer){
                    $voteItemResult = $answer->toArray();
                }
                else{
                    $voteItemResult = Array('questionId' => $question->getId(), 'voteId' => $vote->getId(), 'answer' => 0);
                }
            }
            else{
                $voteItemResult = Array('questionId' => $question->getId());
                $voteItemResult['candidates'] = Array();
                $candidates = \MESBallotBox\Propel\CandidateQuery::create()->filterByQuestionId($question->getId())->orderById()->find();
                foreach($candidates as $candidate){
                    $candidateResult = Array();
                    $answer = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->filterByCandidateId($candidate->getId())->findOne();
                    if($answer){
                        $candidateResult = $answer->toArray();
                    }
                    else{
                        $candidateResult = Array('questionId' => $question->getId(), 'voteId' => $vote->getId(), 'candidateId' => $candidate->getId(), 'answer' => 0);
                    }
                    $voteItemResult['candidates'][] = $candidateResult;
                }
                $candidateResult = Array();
                $answer = \MESBallotBox\Propel\VoteItemQuery::create()->filterByVoteId($vote->getId())->filterByQuestionId($question->getId())->filterByCandidateId(0)->findOne();
                if($answer){
                    $candidateResult = $answer->toArray();
                }
                else{
                    $candidateResult = Array('questionId' => $question->getId(), 'voteId' => $vote->getId(), 'candidateId' => 0, 'answer' => 0);
                }
                $voteItemResult['candidates'][] = $candidateResult;
            }
            $result['voteItem'][] = $voteItemResult;
        }
        return $result;
    }
    
    function checkInvalidVoter($ballot){
        $expire_time = strtotime($_SESSION['user']['membershipExpiration']);
        if($expire_time < time()){
            return "Cannot vote while membership is expired.";
        }
        if($expire_time < $ballot->getEndTime()){
            return "You will be expired before the vote has closed, and therefore cannot vote.";
        }
        if($_SESSION['user']['membershipType'] != 'Full'){
            return "You are a ".$_SESSION['user']['membershipType']." member. Only full members can vote";
        }
        return false;
    }
}