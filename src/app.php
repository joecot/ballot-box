<?php
session_start();
include('../vendor/autoload.php');
include('../../credentials.php');
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


$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.html', [
        
    ]);
})->setName('index');

$app->get('/API/isLoggedIn', function ($request, $response, $args) use ($app) {
    if(!empty($_SESSION['user'])) echo json_encode($_SESSION['user']);
    else{
        return $response->withStatus(401)->write('Login required');
    }
});
$app->get('/login', function($request,$response,$args) use ($app){
    $params = $request->getQueryParams();
    if($params['jspath']) $_SESSION['jspath'] = $params['jspath'];
    
    $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost().$this->router->pathFor('oauth');
    
    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => OAUTHCLIENTID,    // The client ID assigned to you by the provider
        'clientSecret'            => OAUTHSECRET,   // The client password assigned to you by the provider
        'redirectUri'             => $redirectUrl,
        'urlAuthorize'            => 'http://portal.mindseyesociety.org/oauth/v2/auth',
        'urlAccessToken'          => 'http://portal.mindseyesociety.org/oauth/v2/token',
        'urlResourceOwnerDetails' => 'http://portal.mindseyesociety.org/api/authorized/user.json'
    ]);
    // Fetch the authorization URL from the provider; this returns the
    // urlAuthorize option and generates and applies any necessary parameters
    // (e.g. state).
    $authorizationUrl = $provider->getAuthorizationUrl();

    // Get the state generated for you and store it to the session.
    $_SESSION['oauth2state'] = $provider->getState();

    // Redirect the user to the authorization URL.
    header('Location: ' . $authorizationUrl);
    exit;
});

$app->get('/oauth', function($request,$response,$args) use ($app){
    $uri = $request->getUri();
    $scheme = 'http';
    if($uri->getPort() == 443) $scheme = 'https';
    $redirectUrl = $scheme."://".$uri->getHost().$this->router->pathFor('oauth');

    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => OAUTHCLIENTID,    // The client ID assigned to you by the provider
        'clientSecret'            => OAUTHSECRET,   // The client password assigned to you by the provider
        'redirectUri'             => $redirectUrl,
        'urlAuthorize'            => 'http://portal.mindseyesociety.org/oauth/v2/auth',
        'urlAccessToken'          => 'http://portal.mindseyesociety.org/oauth/v2/token',
        'urlResourceOwnerDetails' => 'http://portal.mindseyesociety.org/api/authorized/user.json'
    ]);
   if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {
        var_dump($_GET);
        var_dump($_SESSION);
        unset($_SESSION['oauth2state']);
        exit('Invalid state');
    
    } else {
    
        try {
    
            // Try to get an access token using the authorization code grant.
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
    
            // We have an access token, which we may use in authenticated
            // requests against the service provider's API.
            
    
            // Using the access token, we may look up details about the
            // resource owner.
            $resourceOwner = $provider->getResourceOwner($accessToken);
    
           $_SESSION['user'] = $resourceOwner->toArray();
           if($_SESSION['jspath']){
               $jspath = $_SESSION['jspath'];
               unset($_SESSION['jspath']);
               return $response->withStatus(301)->withHeader("Location", "/#".$jspath);
           }
           else return $response->withStatus(301)->withHeader("Location", "/");
    
            
    
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
    
            // Failed to get the access token or user details.
            exit($e->getMessage());
    
        }
    }

})->setName('oauth');
$app->run();
$end = microtime(true);