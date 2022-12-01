<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

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


class Social extends CI_Controller
{
    //Facebook
    private $appId='330453727556164';
    private $secret='1bf45d526bc007dff059dfc91450c4b2';

    //LinkedIn
    private $callbackURL = "";
    private $linkreturn_home= "";
    private $linkedinApiKey = '77o88sa1tg8rot';
    private $linkedinApiSecret = 'X5fwkmRgOaXCyGUK';
    private $linkedinScope = 'r_basicprofile r_emailaddress';

    //Google
    private $clientId = '555829293179-po80vvln6djv5ln6sm4n7vdi92v32f6f.apps.googleusercontent.com'; //Google CLIENT ID
    private $clientSecret = 'A4E2aOrTL5PVP0Cs5YuyC3yq'; //Google CLIENT SECRET
    private $redirectUrl = "";
    private $homeUrl = "";

    //Twitter
    private $CONSUMER_KEY='bTNKfCEeK1v7t8XW7Eb67mjb6';
    private $CONSUMER_SECRET='2cSjdiPRmxur6Xf0LK6bqR35MlahBn8HDIRQadbR66DwSI06WW';
    private $OAUTH_CALLBACK="";

	public function __construct()
    {
    	parent::__construct();
        $this->load->helper(array('url'));
        
        $this->callbackURL = base_url('social/linkedin/');
        $this->linkreturn_home = base_url();
        $this->redirectUrl = base_url('social/google/');
        $this->homeUrl = base_url();
        $this->OAUTH_CALLBACK = base_url('social/twitter/');
        
        $this->load->library('session');
    }

    public function facebook() {
       // init app with app id and secret
       FacebookSession::setDefaultApplication( $this->appId, $this->secret );
       
       // login helper with redirect_uri
       $helper = new FacebookRedirectLoginHelper( $this->homeUrl . 'social/facebook' );
       
       try {
          $session = $helper->getSessionFromRedirect();
       } catch( FacebookRequestException $ex ) {
          
       } catch( Exception $ex ) {
          
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
            $first_name = $graphObject->getProperty('first_name'); 
            $last_name = $graphObject->getProperty('last_name'); 

            if (isset($femail) && $femail!=null) {
                $record = $this->Common_model->get_record('Members', array('email' => $femail));
                if (!(isset($record) && $record != null)) {
                    $arr   = array(
                        'First_Name' => $first_name,
                        'Last_Name' => $last_name,
                        'Email' => $femail,
                        'Avatar' => '',
                        'Password' => md5($femail . ':' . time()),
                        'Status' => 1
                    );
                    $id = $this->Common_model->add('Members', $arr);
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $femail,
                        'id' => $id,
                        'full_name' => $first_name . ' ' . $last_name,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'address' => '',
                        'avatar' => '/skins/frontend/images/user_default.png'
                    ));
                    
                    // Check Create_Login_First field if empty then 
                    if ($record["Create_At"] == null) {
                    	$arr = array(
		                    'Create_At' => date('Y-m-d H:i:s')
		                );
		                $this->Common_model->update('Members', $arr, array(
		                    'ID' => $id
		                ));
                    }
                    
                    if ($record["Create_Login_First"] == null || $record["Create_Login_First"] == '0000-00-00 00:00:00') {
                    	$arr = array(
		                    'Create_Login_First' => date('Y-m-d H:i:s')
		                );
		                $this->Common_model->update('Members', $arr, array(
		                    'ID' => $id
		                ));
                    }
                    // Update last login
                    $this->Common_model->update('Members', ['Last_Login' => date('Y-m-d H:i:s')], array(
	                    'ID' => $id
	                ));
	                // Save to history login
	                $arr = array(
	                    'Member_ID' => $id,
	                    'IP' => @$_SERVER["REMOTE_ADDR"],
	                    'Info_Browser' => @$_SERVER["HTTP_USER_AGENT"]
	                );
	                $this->Common_model->add('Member_Login', $arr);
		                
                }
                else{
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $record["Email"],
                        'id' => $record["ID"],
                        'full_name' => $record["First_Name"] . ' ' . $record["Last_Name"],
                        'first_name' => $record["First_Name"],
                        'last_name' => $record["Last_Name"],
                        'address' => $record["Address"],
                        'avatar' => (@$record["Avatar"] != null) ? $record["Avatar"] : '/skins/frontend/images/user_default.png'
                    ));
                    
                    // Check Create_Login_First field if empty then 
                    if ($record["Create_At"] == null) {
                    	$arr = array(
		                    'Create_At' => date('Y-m-d H:i:s')
		                );
		                $this->Common_model->update('Members', $arr, array(
		                    'ID' => $record['ID']
		                ));
                    }
                    
                    if ($record["Create_Login_First"] == null || $record["Create_Login_First"] == '0000-00-00 00:00:00') {
                    	$arr = array(
		                    'Create_Login_First' => date('Y-m-d H:i:s')
		                );
		                $this->Common_model->update('Members', $arr, array(
		                    'ID' => $record['ID']
		                ));
                    }
                    // Update last login
                    $this->Common_model->update('Members', ['Last_Login' => date('Y-m-d H:i:s')], array(
	                    'ID' => $record['ID']
	                ));
	                // Save to history login
	                $arr = array(
	                    'Member_ID' => $record['ID'],
	                    'IP' => @$_SERVER["REMOTE_ADDR"],
	                    'Info_Browser' => @$_SERVER["HTTP_USER_AGENT"]
	                );
	                $this->Common_model->add('Member_Login', $arr);
                }
            }
          
            redirect('/');
        } else {
            $loginUrl = $helper->getLoginUrl(array('scope' => 'email'));
            redirect($loginUrl);
        }
        redirect('/');
    }

    public function linkedin(){
        include_once("Social/LinkedIn/http.php");
        include_once("Social/LinkedIn/oauth_client.php");
        $client = new oauth_client_class;
        $client->debug = false;
        $client->debug_http = true;
        $client->redirect_uri = $this->callbackURL;
        $client->client_id = $this->linkedinApiKey;
        $application_line = __LINE__;
        $client->client_secret = $this->linkedinApiSecret;
        if (strlen($client->client_id) == 0 || strlen($client->client_secret) == 0)
              die('Please go to LinkedIn Apps page https://www.linkedin.com/secure/developer?newapp= , '.
                        'create an application, and in the line '.$application_line.
                        ' set the client_id to Consumer key and client_secret with Consumer secret. '.
                        'The Callback URL must be '.$client->redirect_uri).' Make sure you enable the '.
                        'necessary permissions to execute the API calls your application needs.';
        /* API permissions */
        $client->scope = $this->linkedinScope;
        $success=false;
        if (($success = $client->Initialize())) {
          if (($success = $client->Process())) {
            if (strlen($client->authorization_error)) {
                  $client->error = $client->authorization_error;
                  $success = false;
            } elseif (strlen($client->access_token)) {
                  $success = $client->CallAPI(
                            'http://api.linkedin.com/v1/people/~:(id,email-address,first-name,last-name,location,picture-url,public-profile-url,formatted-name)', 
                            'GET', array(
                                'format'=>'json'
                            ), array('FailOnAccessError'=>true), $user);
            }
          }
          $success = $client->Finalize($success);
        }

        if ($success) {
            //print_r($user);
            //die();
            $email=$user->emailAddress;
            $first_name=$user->firstName;
            $last_name=$user->lastName;
            if($email!=null){//successfully
               
            }
            else{//error

            }
        }else {//error

        }
    }

    public function google(){
        include_once("Social/Google/Google_Client.php");
        include_once("Social/Google/contrib/Google_Oauth2Service.php");
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($this->clientId);
        $gClient->setClientSecret($this->clientSecret);
        $gClient->setRedirectUri($this->redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        if(isset($_GET['code'])){
            $gClient->authenticate();
            $token = $gClient->getAccessToken();
            $this->session->set_userdata('token', $token);
        }
        if ($this->session->userdata('token')) {
            $gClient->setAccessToken($this->session->userdata('token'));
            $this->session->unset_userdata('token');
        }

        if ($gClient->getAccessToken()) { 
            $userProfile = $google_oauthV2->userinfo->get();
            $email      = @$userProfile['email'];
            $first_name = @$userProfile['given_name'];
            $last_name  = @$userProfile['family_name'];
            $record = $this->Common_model->get_record('Members', array('email' => $email));
            if(!(isset($record) && $record != null)){
                $arr   = array(
                    'First_Name' => $first_name,
                    'Last_Name' => $last_name,
                    'Email' => $email,
                    'Avatar' => '/skins/frontend/images/user_default.png',
                    'Password' => md5($email . ':' . time()),
                    'Status' => 1
                );
                $id = $this->Common_model->add('Members', $arr);
                $this->session->set_userdata('is_login', TRUE);
                $this->session->set_userdata('user_info', array(
                    'email' => $email,
                    'id' => $id,
                    'full_name' => $first_name . ' ' . $last_name,
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'address' => '',
                    'avatar' => (@$picture_url != null) ? $picture_url : '/skins/frontend/images/user_default.png'
                ));
                
                // Check Create_Login_First field if empty then 
                if ($record["Create_At"] == null) {
                	$arr = array(
	                    'Create_At' => date('Y-m-d H:i:s')
	                );
	                $this->Common_model->update('Members', $arr, array(
	                    'ID' => $id
	                ));
                }
                
                if ($record["Create_Login_First"] == null || $record["Create_Login_First"] == '0000-00-00 00:00:00') {
                	$arr = array(
	                    'Create_Login_First' => date('Y-m-d H:i:s')
	                );
	                $this->Common_model->update('Members', $arr, array(
	                    'ID' => $id
	                ));
                }
                // Update last login
                $this->Common_model->update('Members', ['Last_Login' => date('Y-m-d H:i:s')], array(
                    'ID' => $id
                ));
                // Save to history login
                $arr = array(
                    'Member_ID' => $id,
                    'IP' => @$_SERVER["REMOTE_ADDR"],
                    'Info_Browser' => @$_SERVER["HTTP_USER_AGENT"]
                );
                $this->Common_model->add('Member_Login', $arr);
            }
            else{
                $this->session->set_userdata('is_login', TRUE);
                $this->session->set_userdata('user_info', array(
                    'email' => $record["Email"],
                    'id' => $record["ID"],
                    'full_name' => $record["First_Name"] . ' ' . $record["Last_Name"],
                    'first_name' => $record["First_Name"],
                    'last_name' => $record["Last_Name"],
                    'address' => $record["Address"],
                    'avatar' => (@$record["Avatar"] != null) ? $record["Avatar"] : '/skins/frontend/images/user_default.png'
                ));
                
                // Check Create_Login_First field if empty then 
                if ($record["Create_At"] == null) {
                	$arr = array(
	                    'Create_At' => date('Y-m-d H:i:s')
	                );
	                $this->Common_model->update('Members', $arr, array(
	                    'ID' => $record['ID']
	                ));
                }
                
                if ($record["Create_Login_First"] == null || $record["Create_Login_First"] == '0000-00-00 00:00:00') {
                	$arr = array(
	                    'Create_Login_First' => date('Y-m-d H:i:s')
	                );
	                $this->Common_model->update('Members', $arr, array(
	                    'ID' => $record['ID']
	                ));
                }
                // Update last login
                $this->Common_model->update('Members', ['Last_Login' => date('Y-m-d H:i:s')], array(
                    'ID' => $record['ID']
                ));
                // Save to history login
                $arr = array(
                    'Member_ID' => $record['ID'],
                    'IP' => @$_SERVER["REMOTE_ADDR"],
                    'Info_Browser' => @$_SERVER["HTTP_USER_AGENT"]
                );
                $this->Common_model->add('Member_Login', $arr);
            }

            redirect("/");
            
        } else {
            $authUrl = $gClient->createAuthUrl();
            redirect($authUrl);
        }
    }

    public function twitter(){
        include_once("Social/Twitter/twitteroauth.php");
        if(!isset($_SESSION['token']) && !isset($_SESSION['token_secret'])){
            //Fresh authentication
            $connection = new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET);
            $request_token = $connection->getRequestToken($this->OAUTH_CALLBACK);
            
            //Received token info from twitter
            $_SESSION['token'] 			= $request_token['oauth_token'];
			$_SESSION['token_secret'] 	= $request_token['oauth_token_secret'];

            //Any value other than 200 is failure, so continue only if http code is 200
            if($connection->http_code == '200'){
                //redirect user to twitter
                $twitter_url = $connection->getAuthorizeURL($request_token['oauth_token']);
                redirect($twitter_url); 
            }else{
                die("error connecting to twitter! try again later!");
            }
        }else if(isset($_REQUEST['oauth_token']) && $_SESSION['token'] == $_REQUEST['oauth_token']){
            //Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
            $connection = new TwitterOAuth($this->CONSUMER_KEY,$this->CONSUMER_SECRET, $_SESSION['token'] , $_SESSION['token_secret']);
            $access_token = $connection->getAccessToken(@$_REQUEST['oauth_verifier']);
            if($connection->http_code == '200')
            {
                
                //Insert user into the database
                $user_info = $connection->get('account/verify_credentials'); 
    			print_r($user_info);
                
                //Unset no longer needed request tokens
                unset($_SESSION['token']);
                unset($_SESSION['token_secret']);
                die();
                
            }else{
                die("error, try again later!");
            }
        }
    }

    function curl($url, $post = "") {
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);
        //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        //The number of seconds to wait while trying to connect.
        if ($post != "") {
            curl_setopt($curl, CURLOPT_POST, 5);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }
}