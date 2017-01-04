<?php
  require_once __DIR__ . '/vendor/autoload.php';
  session_start();

  //Establishing Facebook connection
  $fb = new Facebook\Facebook([
  'app_id' => '1814790452137377', // Replace {app-id} with your app id
  'app_secret' => '006b213f54e5c9d124167fdde6e8d29a',
  'status' => 'true',
  'default_graph_version' => 'v2.2',
  ]);

  //Checking if access is granted else throws exception explaing why not.
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

  //Checking if accesstoken is set else throws exception explaing why not.
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
  $oAuth2Client = $fb->getOAuth2Client();

  if(! $accessToken->isLongLived()) {
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

  //Fetches userid and name of the user from Facebook.
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

  //Checks if user already exists in the database.
  $user = $response->getGraphUser();
  $userid = (string) $user['id'];
  $data=array(
    'user_ID' => $userid,
  );

	$url = 'https://whatsdown-d627f.appspot.com/api/?getUser=1';
  $ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);

  //If user doesn't exist(request returns an empty response) adds the user to the database and
  //adds user credentials as session tokens.
	if(empty($response)){
		$user_name = $user['name'];
		$user_ID = $user['id'];
		$data=array(
				'displayname' => $user_name,
				'user_ID' => $user_ID,
			);


		$url = 'https://whatsdown-d627f.appspot.com/api/?insertUser=1';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($ch);
		curl_close($ch);
		$response=json_decode($response_json, true);

		$_SESSION['user_name'] = $user['name'];
		$_SESSION['user_ID'] = $user['id'];

	} else {
    //Fetches user credentials from the database and adds them as session tokens.
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
