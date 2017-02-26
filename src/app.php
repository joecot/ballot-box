<?php
$start = microtime(true);
include('../vendor/autoload.php');
//include('../../credentials.php');
include('propel-config.php');
use Propel\Runtime\Propel;
$con = Propel::getWriteConnection('default');
//$con->useDebug(true);
//session_start();
$configuration = [
    'settings' => [
        'displayErrorDetails' => false,
    ],
];
$container = new \Slim\Container($configuration);

$app = new \Slim\App($container);
unset($app->getContainer()['errorHandler']);

$app->group('/API/', function(){
    \MESBallotBox\Controller\API::route($this);
})->add(function ($request, $response, $next) {
   /*if(empty($_SESSION['user'])){
        return $response->withStatus(401)->write('Login required');
    }*/
    $user = json_decode($_SERVER['HTTP_AUTH_USER_DATA'],true);
    $user['remoteId'] = $user['id'];
    unset($user['id']);
    $userselect = \MESBallotBox\Propel\UserQuery::create();
    $userRow = $userselect->findOneByMembershipNumber($user['membershipNumber']);
    if($userRow){
        $userRow->fromArray($user);
        $userRow->save();
    }
    else{
        $userRow = new \MESBallotBox\Propel\User();
        $userRow->fromArray($user);
        $userRow->save();
    }
    
    $user['id'] = $userRow->getId();
    $_ENV['ballot_user'] = $user;
    $response = $response->withAddedHeader('Access-Control-Allow-Headers', 'Content-Type,Authorization,X-Amz-Date,X-Api-Key,X-Amz-Security-Token')
                        ->withAddedHeader('Access-Control-Allow-Methods', 'DELETE,GET,HEAD,OPTIONS,PATCH,POST,PUT')
                        ->withAddedHeader('Access-Control-Allow-Origin', '*');
    return $next($request, $response);
});

$app->run();
$end = microtime(true);