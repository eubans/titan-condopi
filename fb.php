<?php
   
   session_start();
   
   // added in v4.0.0
   require_once __DIR__ . '/php-graph-sdk-4.0.23/autoload.php';
   use Facebook\FacebookSession;
   use Facebook\FacebookRedirectLoginHelper;
   use Facebook\FacebookRequest;
   use Facebook\FacebookResponse;
   use Facebook\FacebookSDKException;
   use Facebook\FacebookRequestException;
   use Facebook\FacebookAuthorizationException;
   use Facebook\GraphObject;
   use Facebook\Entities\AccessToken;
   use Facebook\HttpClients\FacebookCurlHttpClient;
   use Facebook\HttpClients\FacebookHttpable;
   
   // init app with app id and secret
   FacebookSession::setDefaultApplication( '140611746485821','8eb27cf81d441dfb9795a267d8e1d160' );
   
   // login helper with redirect_uri
   $helper = new FacebookRedirectLoginHelper('http://7daylisting.kindusa.org/fb.php' );
   
   try {
      $session = $helper->getSessionFromRedirect();
   }catch( FacebookRequestException $ex ) {
      // When Facebook returns an error
   }catch( Exception $ex ) {
      // When validation fails or other local issues
   }
   
   // see if we have a session
   if ( isset( $session ) ) {
      // graph api request for user data
      $request = new FacebookRequest( $session, 'GET', '/me?fields=first_name,last_name,email' );
      $response = $request->execute();
      
      // get response
      $graphObject = $response->getGraphObject();
      $fbid = $graphObject->getProperty('id');           // To Get Facebook ID
      $fbfullname = $graphObject->getProperty('name');   // To Get Facebook full name
      $femail = $graphObject->getProperty('email');      // To Get Facebook email ID
      
      /* ---- Session Variables -----*/
      $_SESSION['FBID'] = $fbid;
      $_SESSION['FULLNAME'] = $fbfullname;
      $_SESSION['EMAIL'] =  $femail;

      die(var_dump($_SESSION));
      
      /* ---- header location after session ----*/
      header("Location: index.php");
   }else {
      $loginUrl = $helper->getLoginUrl(array('scope' => 'email'));
      header("Location: ".$loginUrl);
   }
?>
