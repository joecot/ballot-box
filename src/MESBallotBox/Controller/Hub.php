<?php namespace MESBallotBox\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
class Hub{
	function getClient(){
		static $client = false;
		if(!$client) $client = new Client([
			// Base URI is used with relative requests
			'base_uri' => 'http://api-stage.mindseyesociety.org/users/v1/',
			// You can set any number of default request options.
			'timeout'  => 2.0,
			'headers' => Array(
				'Authorization' => $_SERVER['HTTP_AUTHORIZATION']
			)
		]);
		return $client;
	}
	function getUser($membershipNumber){
		$client = self::getClient();
		try{
			$response = $client->request('GET', 'user/'.$membershipNumber,Array('query' => Array('private' => true)));
			$body = (string)$response->getBody();
		}catch(RequestException $e){
			$error = $e->getMessage();
			if ($e->hasResponse()) {
				$error .= '/'. Psr7\str($e->getResponse());
			}
			throw new \Exception('User hub threw exception '.$error);
		}
		$user = json_decode($body,true);
		if(!$user) throw new Exception('Invalid user response');
		$user['remoteId'] = $user['id'];
		unset($user['id']);
		return $user;
	}
	function getOrgUnits($args){
		$client = self::getClient();
		try{
			$query = Array();
			if($args) $query=$args;
			$response = $client->request('GET', 'org-unit/',Array('query' => $query));
			$body = (string)$response->getBody();
		}catch(RequestException $e){
			$error = $e->getMessage();
			if ($e->hasResponse()) {
				$error .= '/'. Psr7\str($e->getResponse());
			}
			throw new \Exception('User hub threw exception '.$error);
		}
		$units = json_decode($body,true);
		if(!$units) throw new Exception('Invalid user response');
		return $units;
	}
	function getOrgUnit($id,$args=false){
		$client = self::getClient();
		try{
			$query = Array();
			if($args) $query=$args;
			$response = $client->request('GET', 'org-unit/'.$id,Array('query' => $query));
			$body = (string)$response->getBody();
		}catch(RequestException $e){
			$error = $e->getMessage();
			if ($e->hasResponse()) {
				$error .= '/'. Psr7\str($e->getResponse());
			}
			throw new \Exception('User hub threw exception '.$error);
		}
		$unit = json_decode($body,true);
		if(!$unit) throw new Exception('Invalid user response');
		return $unit;
	}
	
	function getUserOrgIds(){
		if(!$_ENV['ballot_user']['orgUnit']){
			$user = self::getUser($_ENV['ballot_user']['membershipNumber']);
			//print_r($user);
			$_ENV['ballot_user']['orgUnit'] = $user['orgUnit'];
		}
		$orgUnit = self::getOrgUnit($_ENV['ballot_user']['orgUnit']['id'], Array('users' => 0,'offices' =>0,'children' =>0, 'parents' => -1));
		$ids = Array($orgUnit['unit']['id']);
		foreach($orgUnit['parents'] as $parent) $ids[] = $parent['id'];
		return $ids;
	}
}