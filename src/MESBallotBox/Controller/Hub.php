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
			$response = $client->request('GET', 'user/'.$membershipNumber);
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
			$response = $client->request('GET', 'org-unit/',Array('query' => $args));
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
	function getOrgUnit($id){
		$client = self::getClient();
		try{
			$response = $client->request('GET', 'org-unit/'.$id);
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
}