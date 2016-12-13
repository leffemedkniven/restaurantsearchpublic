<?php
require_once __DIR__ . '/vendor/autoload.php';
session_start();
//echo $_SESSION['fb_access_token'];
//echo $_SESSION['access_granted'];
$fb = new Facebook\Facebook([
  'app_id' => '1814790452137377', // Replace {app-id} with your app id
  'app_secret' => '006b213f54e5c9d124167fdde6e8d29a',
  'status' => 'true',
  'default_graph_version' => 'v2.2',
  ]);

$helper = $fb->getRedirectLoginHelper();
$_SESSION['FBRLH_state']=$_GET['state'];
if(! isset($_SESSION['access_granted'])){
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

//echo "HEHEHEHEHE";
if (! isset($accessToken)) {
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
//echo "HEHEHEHEHE2";
// Logged in
//echo '<h3>Access Token</h3>';
//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();
//echo "hehehehe";
// Get the access token metadata from /debug_token
//$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//echo '<h3>Metadata</h3>';
//var_dump($tokenMetadata);

// Validation (these will throw FacebookSDKException's when they fail)
//$tokenMetadata->validateAppId(1814790452137377); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');

//$tokenMetadata->validateExpiration();
//echo "hehehehe2";
//echo "HEHEHEHEHE3";
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
//echo "hehehehe3";
$_SESSION['fb_access_token'] = (string) $accessToken;


/////////////////////////////////////////////////////////////////////////////////////////////////////
try {
  $at = $_SESSION['fb_access_token'];
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get('/me?fields=id,name', $at);
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$user = $response->getGraphUser();

	$url = 'https://whatsdown-d627f.appspot.com/api/?user_ID='.$user['id'];
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);

	if(empty($response)){
		$user_name = $user['name'];
		$user_ID = $user['id'];
		$data=array(
				'displayname' => $user_name,
				'user_ID' => $user_ID,
				'admin' => 0,

			);
		print_r($data);

		$url = 'https://whatsdown-d627f.appspot.com/api/?insertUser=1';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($ch);
		curl_close($ch);
		$response=json_decode($response_json, true);

		print_r($response);

		$_SESSION['user_name'] = $user['name'];
		$_SESSION['user_ID'] = $user['id'];
		$_SESSION['admin'] = 0;

	} else {
		foreach($response as $row){
			$_SESSION['user_name'] = $row['displayname'];
			$_SESSION['user_ID'] = $row['user_ID'];
			$_SESSION['admin'] = $row['admin'];
		}
	}


header('Location: https://whatsdown-d627f.appspot.com/browse/');
exit();
}
else{
  header('Location: https://whatsdown-d627f.appspot.com/browse/');
  exit();
}
// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
