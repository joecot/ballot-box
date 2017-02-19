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
    $user['affiliateId'] = $userRow->getAffiliateId();
    $_ENV['ballot_user'] = $user;
    return $next($request, $response);
});


/*$app->get('/login', function($request,$response,$args){
    $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost();
    if(!in_array($uri->getPort(),Array(80,443))) $redirectUrl.=':'.$uri->getPort();
    $redirectUrl.= $this->router->pathFor('oauth');
    return \MESBallotBox\Controller\Oauth::login($request,$response,$args,$redirectUrl);
})->setName('login');

$app->get('/oauth', function($request,$response,$args){
    try{
        $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost();
    if(!in_array($uri->getPort(),Array(80,443))) $redirectUrl.=':'.$uri->getPort();
    $redirectUrl.= $this->router->pathFor('oauth');
    return \MESBallotBox\Controller\Oauth::token($request,$response,$args,$redirectUrl);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    

})->setName('oauth');

$app->get('/template/{name:[a-zA-Z0-9]+\.html}', function ($request, $response, $args) {
    return $this->view->render($response, 'angular/'.$args['name'], []);
});*/
$app->run();
$end = microtime(true);