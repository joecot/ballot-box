<?php
include('../vendor/autoload.php');
include('../../credentials.php');
include('propel-config.php');

session_start();
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$container = new \Slim\Container($configuration);
// Register component on container
$container['view'] = function ($c) {
    $view = new \Slim\Views\Twig('../templates', [
        'cache' => '../cache',
        'auto_reload' => true,
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $c['router'],
        $c['request']->getUri()
    ));

    return $view;
};

$app = new \Slim\App($container);
//unset($app->getContainer()['errorHandler']);

$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'index.html', []);
})->setName('index');

$app->group('/API/', function(){
    $this->get('users/current', function ($request, $response) {
        echo json_encode($_SESSION['user']);
    })->setName('API/users/current');
    $this->group('ballots', function(){
        $this->post('', function($request, $response){
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
            return $response->write(json_encode(Array('id' => $ballot->getId())));
        });
        $this->get('', function($request, $response, $args){
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
        $this->get('/{ballotId}', function($request, $response, $args){
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
        $this->get('/{ballotId}/questions', function($request, $response, $args){
             $q = new \MESBallotBox\Propel\BallotQuestionQuery();
            $questions = $q->filterByBallotId($args['ballotId'])->find();
            $results = Array();
            foreach($questions as $question){
                $results[] = $question->toArray();
            }
            
            return $response->write(json_encode($results));
        });
         $this->post('/{ballotId}/questions', function($request, $response){
            $vars = $request->getParsedBody();

            $question = new \MESBallotBox\Propel\BallotQuestion();
            $question->fromArray($vars);
            
            if(!$question->validate()){
                return $response->withStatus(400)->write($question->getValidationFailures()->__toString().$question->toJson());
            }
            try{
                $question->save();
            }catch(Exception $e){
                return $response->withStatus(500)->write($e->getMessage());
            }
            return $response->write(json_encode(Array('id' => $question->getId())));
        });
    });
})->add(function ($request, $response, $next) {
   if(empty($_SESSION['user'])){
        return $response->withStatus(401)->write('Login required');
    }
    return $next($request, $response);
});


$app->get('/login', function($request,$response,$args){
    $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost().$this->router->pathFor('oauth');
    return \MESBallotBox\Controller\Oauth::login($request,$response,$args,$redirectUrl);
})->setName('login');

$app->get('/oauth', function($request,$response,$args){
    try{
        $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost().$this->router->pathFor('oauth');
    return \MESBallotBox\Controller\Oauth::token($request,$response,$args,$redirectUrl);
    }
    catch(Exception $e){
        echo $e->getMessage();
    }
    

})->setName('oauth');

$app->get('/template/{name:[a-zA-Z0-9]+\.html}', function ($request, $response, $args) {
    return $this->view->render($response, 'angular/'.$args['name'], []);
});
$app->run();
$end = microtime(true);