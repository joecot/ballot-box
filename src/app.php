<?php
include('../vendor/autoload.php');
include('../../credentials.php');
//add back normal autoloader
set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__));
spl_autoload_extensions(".php");
spl_autoload_register(spl_autoload,true,true);

session_start();

$container = new \Slim\Container;
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


$app->get('/', function ($request, $response) {
    return $this->view->render($response, 'index.html', []);
})->setName('index');

$app->group('/API', function(){
    $this->get('user', function ($request, $response) {
        echo json_encode($_SESSION['user']);
    })->setName('API/user');
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
    $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost().$this->router->pathFor('oauth');
    return \MESBallotBox\Controller\Oauth::token($request,$response,$args,$redirectUrl);

})->setName('oauth');

$app->get('/template/{name:[a-zA-Z0-9]+\.html}', function ($request, $response, $args) {
    return $this->view->render($response, 'angular/'.$args['name'], []);
});
$app->run();
$end = microtime(true);