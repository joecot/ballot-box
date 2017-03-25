<?php namespace MESBallotBox\Controller;

class Vote{
	function route($slim){
		$slim->get('', function($request, $response, $args){
			$orgIds = \MESBallotBox\Controller\Hub::getUserOrgIds();

			$q = new \MESBallotBox\Propel\BallotQuery();
			$time = time();
			$ballots = $q::create()
						->join('Ballot.Voter')
						->condition('byUser', 'Voter.userId = ?', $_ENV['ballot_user']['id'])
						->condition('byOrgUnit', 'Voter.orgUnitId IN ?', $orgIds)
						->where(Array('byUser', 'byOrgUnit'), 'or')
						->where('Ballot.startTime < ?', $time)
						->where('Ballot.endTime > ?', $time)
						->groupBy('Ballot.id')
						->find();
			$results = Array();
			foreach($ballots as $ballot){
				$result = Array();
				$result['id'] = $ballot->getId();
				$result['name'] = $ballot->getName();
				$result['start'] = $ballot->getStartTime();
				$result['end'] = $ballot->getEndTime();
				$result['timezoneNice'] = $ballot->getTimezoneNice();
				$results[] = $result;
			}
			
			return $response->write(json_encode($results));
		});
		
		$slim->get('/{ballotId}', function($request, $response, $args){
			$ballot = \MESBallotBox\Controller\Vote::getVoterBallot($args['ballotId']);
			if(!$ballot){
				return $response->withStatus(400)->write('Ballot not available for voting.');
			}
			$result = Array();
			$result['id'] = $ballot->getId();
			$result['name'] = $ballot->getName();
			$result['start'] = $ballot->getStartTime();
			$result['end'] = $ballot->getEndTime();
			$result['timezone'] = $ballot->getTimezone();
			$result['timezoneNice'] = $ballot->getTimezoneNice();
			$result['questions'] = \MESBallotBox\Controller\Vote::getQuestions($ballot);
			
			$vote = \MESBallotBox\Propel\VoteQuery::create()->filterByBallotId($ballot->getId())->filterbyUserId($_ENV['ballot_user']['id'])->findOne();
			if($vote) $result['voteId'] = $vote->getId();
			else{
				$invalid_message = \MESBallotBox\Controller\Vote::checkInvalidVoter($ballot);
				if($invalid_message) $result['invalid'] = $invalid_message;
			}
			return $response->write(json_encode($result));
		});
		
		$slim->post('/{ballotId}/vote', function($request, $response,$args){
			$vars = $request->getParsedBody();
			$ballot = \MESBallotBox\Controller\Vote::getVoterBallot($args['ballotId']);
			if(!$ballot){
				return $response->withStatus(400)->write('Ballot not available for voting.');
			}
			$invalid_message = \MESBallotBox\Controller\Vote::checkInvalidVoter($ballot);
			if($invalid_message){
				return $response->withStatus(400)->write($invalid_message);
			}
			$vote = new \MESBallotBox\Propel\Vote();
			$vote->setBallotId($ballot->getId());
			$vote->setUserId($_ENV['ballot_user']['id']);
			$vote->setVersionCreatedBy($_ENV['ballot_user']['id']);
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
			$result = \MESBallotBox\Controller\Vote::getVoteResult($ballot,$vote);
			return $response->write(json_encode($result));
		});
		$slim->get('/{ballotId}/vote/{voteId}', function($request, $response,$args){
			$ballot = \MESBallotBox\Controller\Vote::getVoterBallot($args['ballotId']);
			if(!$ballot){
				return $response->withStatus(400)->write('Ballot not available for voting.');
			}
			$vote = \MESBallotBox\Propel\VoteQuery::create()->filterByBallotId($args['ballotId'])->filterById($args['voteId'])->findOne();
			if(!$vote){
				return $response->withStatus(400)->write('Vote not found.');
			}
			if($vote->getUserId() != $_ENV['ballot_user']['id']){
				if($ballot->getUserId() != $_ENV['ballot_user']['id']){
					return $response->withStatus(400)->write('Vote not accessible.');
				}
			}
			$result = \MESBallotBox\Controller\Vote::getVoteResult($ballot,$vote);
			return $response->write(json_encode($result));
		});
		$slim->post('/{ballotId}/vote/{voteId}', function($request, $response,$args){
			$vars = $request->getParsedBody();
			$ballot = \MESBallotBox\Controller\Vote::getVoterBallot($args['ballotId']);
			if(!$ballot){
				return $response->withStatus(400)->write('Ballot not available for voting.');
			}
			$vote = \MESBallotBox\Propel\VoteQuery::create()->filterByBallotId($args['ballotId'])->filterById($args['voteId'])->findOne();
			if(!$vote){
				return $response->withStatus(400)->write('Vote not found.');
			}
			if($vote->getUserId() != $_ENV['ballot_user']['id']){
				if($ballot->getUserId() != $_ENV['ballot_user']['id']){
					return $response->withStatus(400)->write('Vote not accessible.');
				}
			}
			
			$vote->setVersionCreatedBy($_ENV['ballot_user']['id']);
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
					$voteItem->setVersionCreatedBy($_ENV['ballot_user']['id']);
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
						$voteItem->setVersionCreatedBy($_ENV['ballot_user']['id']);
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
							$voteItem->setVersionCreatedBy($_ENV['ballot_user']['id']);
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
							$voteItem->setVersionCreatedBy($_ENV['ballot_user']['id']);
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
			$result = \MESBallotBox\Controller\Vote::getVoteResult($ballot,$vote);
			return $response->write(json_encode($result));
		});
	}
		
	function getUser($membershipNumber){
		$q = new \MESBallotBox\Propel\UserQuery();
		if(!$membershipNumber) return false;
		$user = $q->filterByMembershipNumber($membershipNumber)->findOne();
		if(!$user){
			$userInfo = \MESBallotBox\Controller\Hub::getUser($membershipNumber);
			if(!$userInfo || ! is_array($userInfo) || !$userInfo['membershipNumber']){
				return false;
			}
			$user = new \MESBallotBox\Propel\User();
			$user->fromArray($userInfo);
			$user->save();
		}
		return $user;
	}
	function getQuestions($ballot){
		if(!$ballot) return false;
		$q = new \MESBallotBox\Propel\QuestionQuery();
		$questions = $q->filterByBallotId($ballot->getId())->orderById()->find();
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
		}
		return $questionsresult;
	}
	function getVoterBallot($ballotId){
		$q = new \MESBallotBox\Propel\BallotQuery();
		$time=time();

		$ballot = $q::create()
			->join('Ballot.Voter')
			->condition('byUser', 'Voter.userId = ?', $_ENV['ballot_user']['id'])
			->condition('byAffiliate', 'Voter.affiliateId = ?', $_ENV['ballot_user']['affiliateId'])
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
		$expire_time = strtotime($_ENV['ballot_user']['membershipExpiration']);
		if($expire_time < time()){
			return "Cannot vote while membership is expired.";
		}
		if($expire_time < $ballot->getEndTime()){
			return "You will be expired before the vote has closed, and therefore cannot vote.";
		}
		if($_ENV['ballot_user']['membershipType'] != 'Full'){
			return "You are a ".$_ENV['ballot_user']['membershipType']." member. Only full members can vote";
		}
		return false;
	}
}