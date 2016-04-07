<?php namespace MESBallotBox\Controller;
class Oauth{
    static private function getProvider($redirectUrl = false){
        $config = [
            'clientId'                => OAUTHCLIENTID,    // The client ID assigned to you by the provider
            'clientSecret'            => OAUTHSECRET,   // The client password assigned to you by the provider
            'redirectUri'             => $redirectUrl,
            'urlAuthorize'            => 'https://portal.mindseyesociety.org/oauth/v2/auth',
            'urlAccessToken'          => 'https://portal.mindseyesociety.org/oauth/v2/token',
            'urlResourceOwnerDetails' => 'https://portal.mindseyesociety.org/api/authorized/user.json'
        ];
        $provider = new \League\OAuth2\Client\Provider\GenericProvider($config);
        return $provider;
    }
    static public function login($request,$response,$args,$redirectUrl){
        $params = $request->getQueryParams();
        if($params['jspath']) $_SESSION['jspath'] = $params['jspath'];

        $provider = self::getProvider($redirectUrl);
        // Fetch the authorization URL from the provider; this returns the
        // urlAuthorize option and generates and applies any necessary parameters
        // (e.g. state).
        $authorizationUrl = $provider->getAuthorizationUrl();
    
        // Get the state generated for you and store it to the session.
        $_SESSION['oauth2state'] = $provider->getState();
    
        // Redirect the user to the authorization URL.
        return $response->withStatus(301)->withHeader("Location", $authorizationUrl);
    }
    
    static public function token($request,$response,$args,$redirectUrl){
        $provider = self::getProvider($redirectUrl);
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

                $user = $resourceOwner->toArray();
                $userselect = \MESBallotBox\Propel\UserQuery::create();
                $userRow = $userselect->findOneByMembershipNumber($user['membershipNumber']);
                if($userRow) $userRow->fromArray($user);
                else{
                    $userRow = new \MESBallotBox\Propel\User();
                    $userRow->fromArray($user);
                }
                $userRow->save();
                $user['id'] = $userRow->getId();
                $_SESSION['user'] = $user;
                $_SESSION['accessToken'] = $accessToken;
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
    }
    static private function checkToken(){
        $provider = self::getProvider();
        if ($_SESSION['accessToken']->hasExpired()) {
            $newAccessToken = $provider->getAccessToken('refresh_token', [
                'refresh_token' => $_SESSION['accessToken']->getRefreshToken()
            ]);
            if($newAccessToken) $_SESSION['accessToken'] = $newAccessToken;
            // Purge old access token and store new access token to your data store.
        }
    }
    static public function LookupByMembershipNumber($membershipNumber){
        $provider = self::getProvider();
        self::checkToken();
        $url = 'https://portal.mindseyesociety.org/api/users/'.$membershipNumber.'/membershipnumber';
        $request = $provider->getAuthenticatedRequest($provider::METHOD_GET, $url, $_SESSION['accessToken']);
        return $provider->getResponse($request);
    }
}