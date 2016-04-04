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
$app->get('/logout', function($request, $response){
    unset($_SESSION['user']);
    return $response->withStatus(301)->withHeader("Location", '/');
});
$app->get('/session', function($request, $response){
    print_r($_SESSION);
});
$app->group('/API/', function(){
    $this->get('users/current', function ($request, $response) {
        echo json_encode($_SESSION['user']);
    })->setName('API/users/current');
    $this->get('users/{membershipNumber}', function ($request, $response,$args) {
        $q = new \MESBallotBox\Propel\UserQuery();
        $user = $q->filterByMembershipNumber($args['membershipNumber'])->findOne();
        if(!$user){
            $userInfo = \MESBallotBox\Controller\Oauth::LookupByMembershipNumber($args['membershipNumber']);
            if(!$userInfo['remoteId']){
                return $response->withStatus(400)->write('User not found');
            }
            $user = new \MESBallotBox\Propel\User();
            $user->fromArray($userInfo);
            $user->save();
        }
        //return json_encode($args);
        return $response->write($user->toJSON());
    });
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
            return $response->write($ballot->toJSON());
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
        $this->get('/{ballotId}/question', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $questions = $q->filterByBallotId($args['ballotId'])->find();
            $results = Array();
            foreach($questions as $question){
                $results[] = $question->toArray();
            }
            
            return $response->write(json_encode($results));
        });
        $this->get('/{ballotId}/question/{questionId}', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\QuestionQuery();
            $question = $q->findPK($args['questionId']);
            
            return $response->write($question->toJSON());
        });
         $this->post('/{ballotId}/question', function($request, $response){
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
        $this->post('/{ballotId}/question/{questionId}/candidate', function($request, $response, $args){
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
        $this->get('/{ballotId}/question/{questionId}/candidate', function($request, $response, $args){
            $q = new \MESBallotBox\Propel\CandidateQuery();
            $candidates = $q->filterByQuestionId($args['questionId'])->find();
            $results = Array();
            foreach($candidates as $candidate){
                $results[] = array_merge($candidate->getUser()->toArray(), $candidate->toArray());
            }
            return $response->write(json_encode($results));
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