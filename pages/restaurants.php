<!DOCTYPE html>
<?php
require_once '../vendor/autoload.php';
include('login.php'); // Includes Login Script'

//include('fb-callback.php');
//echo $_SESSION['fb_access_token'];




if($_SESSION['fb_access_token']===""){
	header("Location: https://whatsdown-d627f.appspot.com/");
	die();
}

$fb = new Facebook\Facebook([
  'app_id' => '1814790452137377', // Replace {app-id} with your app id
  'app_secret' => '006b213f54e5c9d124167fdde6e8d29a',
  'default_graph_version' => 'v2.2',
  ]);

$at = $_SESSION['fb_access_token'];
try {
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

echo 'Name: ' . $user['name'];
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Restaurantsearch</title>

    <!-- Bootstrap core CSS -->
    <link href="../static/bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../static/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../static/bootstrap-3.3.7/docs/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../../assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">

            <?php if($_SESSION['admin']==true) {echo("<li role=\"presentation\" class=\"active\"><a href=\"https://whatsdown-d627f.appspot.com/admin/\">Admin</a></li>"); }?>
            <li role="presentation" class="active"><a href="https://whatsdown-d627f.appspot.com/browse/">Home</a></li>

	<li role="presentation" class="active"><a href="https://whatsdown-d627f.appspot.com/logout.php">Log out</a></li>
      	<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true"></div>
          </ul>
        </nav>
        <h3 class="text-muted">Restaurantsearch</h3>
      </div>

      <div class="jumbotron">
        <img src="https://storage.googleapis.com/whatsdown-d627f.appspot.com/restar.jpg">
      </div>

      <div class="row marketing">
	<?php
		$url = 'https://whatsdown-d627f.appspot.com/api/?restaurants=1';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($ch);
		curl_close($ch);
		$response=json_decode($response_json, true);
		foreach($response as $row){
			echo("<div class=\"col-lg-6\">");
			echo("<h4>".$row['name']."</h4>");
			echo("<p>".$row['description']."</p>");
			echo("<p>".$row['location']."</p>");
        		echo("<p><a class=\"btn btn-default\" id=".$row[restaurant_ID]." onclick=\"myFunction(this.id)\" role=\"button\">View details </a></p>");
			echo $user_name;
			echo $user_id;
			echo("</div>");
	    	}
	?>

		<script>
		function myFunction(id) {
			window.location = "https://whatsdown-d627f.appspot.com/restaurant/?id="+id;
		}
		</script>




   </div>
    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
