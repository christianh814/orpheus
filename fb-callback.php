<?php
require_once("includes/config.php");
require_once("includes/vendor/autoload.php");
require_once("includes/classes/Account.php");
require_once("includes/classes/Constants.php");
//
function generate_uuid() {
	return md5(rand(100, 999));
}
//
$fb = new Facebook\Facebook([
  'app_id' => getenv("FB_APP_ID"),
  'app_secret' => getenv("FB_APP_SECRET"),
  'default_graph_version' => 'v2.2'
]);

$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (!isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId(getenv("FB_APP_ID")); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
    exit;
  }

  echo '<h3>Long-lived</h3>';
  var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

$fb_session = $_SESSION['fb_access_token'];

// Here we either login the user; or register them. We will also...
//	* Create a FAUX password for them
//	* Create a Username
// TODO: Let them edit username at a later date


// First let's get the user's information
$fblogin = new Facebook\Facebook([
	'app_id' => getenv("FB_APP_ID"),
	'app_secret' => getenv("FB_APP_SECRET"),
	'default_graph_version' => 'v2.2'
]); 
$res = $fblogin->get( '/me?fields=id,first_name,last_name,email,gender,locale', $fb_session);

$user = $res->getGraphObject()->asArray();
//
// Now let's check if the user has an email in the DB
$user_to_check = $user['email'];
$sql = "SELECT * FROM users WHERE email = '" . $user['email'] . "' ";
$query = mysqli_query($con, $sql);
if (mysqli_num_rows($query) > 0) {
	//User exists, log 'em in
	$row = mysqli_fetch_array($query);
	$_SESSION['user_logged_in'] = $row['username'];
	$fb_session = $_SESSION['fb_access_token'];
	header("Location: index.php");
} else {
	//means user hasn't been  created; log them in
	function sanitizeFormPassword($input) {
	return !empty($input) ? strip_tags($input) : false;
	}
	function sanitizeFormUsername($input) {
	        return !empty($input) ? strtolower(str_replace(" ", "", strip_tags($input))) : false;
	}
	function sanitizeFormString($input) {
	        return !empty($input) ? ucfirst(strtolower(str_replace(" ", "", strip_tags($input)))) : false;
	}
	//register user
	// These entries we have to "create" becuase we are using FB
	$faux_un =  explode("@", $user['email']);
	$faux_num = rand(100, 999);
	$faux_pass = generate_uuid();
	//
	$username = sanitizeFormUsername($faux_un[0] . "-" . $faux_num);
	$firstname = sanitizeFormString($user['first_name']);
	$lastname = sanitizeFormString($user['last_name']);
	$email1 =  sanitizeFormUsername($user['email']);
	$email2 =  sanitizeFormUsername($user['email']);
	$pw1 =  sanitizeFormPassword($faux_pass);
	$pw2 =  sanitizeFormPassword($faux_pass);
	$pic = "http://graph.facebook.com/" . $user['id'] . "/picture?type=large";
	//  

	/*
	var_dump($username);
	var_dump($firstname);
	var_dump($lastname);
	var_dump($email1);
	var_dump($email2);
	var_dump($pw1);
	var_dump($pw2);
	*/

	$account = new Account($con);
	$was_successful = $account->register($username, $firstname, $lastname, $email1, $email2, $pw1, $pw2, $pic);
	
	if($was_successful) {
		$_SESSION['user_logged_in'] = $username;
		$_SESSION['user_logged_in_firstname'] = $firstname;
		$_SESSION['user_logged_in_lastname'] = $lastname;
		$_SESSION['user_logged_in_fullname'] = $firstname . " " . $lastname;
		$fb_session = $_SESSION['fb_access_token'];
		header("Location: index.php");
	}   
}
?>
