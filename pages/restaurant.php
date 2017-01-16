<!DOCTYPE html>
	<?php
	require_once '../vendor/autoload.php';
	session_start();
	$ini = parse_ini_file('../configURL.ini');
	//Checking login-status
	if($_SESSION['fb_access_token']===""){
		header("Location: " . $ini[app_url]);
		die();
	}


	//Establishing Facebook connection
	$fb = new Facebook\Facebook([
  	'app_id' => '1814790452137377', // Replace {app-id} with your app id
  	'app_secret' => XXXX,
  	'default_graph_version' => 'v2.2',
  	]);

		//Fetching userid and name from facebook
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

?>
<html lang="en">
<head>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
						<?php
						if($_SESSION['admin']==true) {echo("<li role=\"presentation\" class=\"active\"><a href=\"$ini[app_url]/admin/\">Admin</a></li>"); }
						echo("<li role=\"presentation\" class=\"active\"><a href=\"$ini[app_url]/browse/\">Home</a></li>");
						echo("<li role=\"presentation\" class=\"active\"><a href=\"$ini[app_url]/logout/\">Logout</a></li>");?>
          </ul>
        </nav>
        <h3 class="text-muted">Restaurantsearch</h3>
     </div>

		 <?php
		 //Getting restaurant information
		 session_start();
		 $rest_ID = $_GET['id'];
		 $url = $ini[app_url] . '/api/?restaurant_ID='.$rest_ID;
		 $ch = curl_init($url);
		 curl_setopt($ch, CURLOPT_HTTPGET, true);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 $response_json = curl_exec($ch);
		 curl_close($ch);
		 $response=json_decode($response_json, true);
		 foreach($response as $row){
			 $rest_name = $row['name'];
			 $rest_desc = $row['description'];
			 $rest_loc = $row['location'];
			 $rest_pic = $row['picture'];
		 }
?>
        <div class="row">
                <div class="thumbnail">
                    <img class="img-responsive" src="<?php echo $rest_pic ?>" alt="">
                    <div class="caption-full">
                        <h4 class="pull-right"><?php echo $rest_loc;?></h4>
                        <h4><?php echo $rest_name;?></h4>
                        <p><?php echo $rest_desc;?> </p>
                    </div>
    								<div class="imageupload">
      								<center>
      									<form id="data" method="POST" enctype="multipart/form-data">
												<input type="hidden" name="restaurant_ID" id="restaurant_ID" value="<?php echo $rest_ID; ?>" />
      									<?php
												if($_SESSION['admin']==true){
												echo("Upload image:<p/>");
          							echo("<input name=\"file\" type=\"file\" /><p/>");
												echo("<input type=\"submit\" value=\"Upload image\" />");
												}
												?>
    										</form>
    									</center>
      							</div>
  						</div>

            <div class="well">
			       	<div class="row send-wrap">
                  <div class="send-message">
                      <div class="message-text">
        Write a review and rate the restaurant(Only for logged-in users): </br>
				<form action="/pages/review.php" method="post" id="reviewform" autocomplete="off">
					<?php
      		echo("Rating:");
					echo("<input type=\"radio\" name=\"rate\" id=\"r1\" value=\"1\" checked> 1 ");
					echo("<input type=\"radio\" name=\"rate\" id=\"r2\" value=\"2\" checked> 2 ");
					echo("<input type=\"radio\" name=\"rate\" id=\"r3\" value=\"3\" checked> 3 ");
					echo("<input type=\"radio\" name=\"rate\" id=\"r4\" value=\"4\" checked> 4 ");
					echo("<input type=\"radio\" name=\"rate\" id=\"r5\" value=\"5\" checked> 5 ");

        	echo(" Date of your restaurant visit: ");
        	echo("<input type=\"date\" name=\"visitdate\">");
					echo("<textarea class=\"no-resize-bar form-control\" name=\"review\" id=\"review\" rows=\"2\" placeholder=\"Write a review\"></textarea>");
					echo("<input type=submit value=\"submit\">");
					?>

					<input type="hidden" name="restaurant_ID" id="restaurant_ID" value="<?php echo $rest_ID; ?>" />
					<input type="hidden" name="user_ID" id="user_ID" value="<?php echo $user['id']; ?>" />
					<input type="hidden" name="displayname" id="displayname" value="<?php echo $user['name']; ?>" />

          </form>
											</div>
                    </div>
                  </div>
                <hr>

		  <?php
			//Getting all reviews placed corresponding to the restaurant and listing them.
			$url = $ini[app_url] . '/api/?restaurantReviews='.$rest_ID;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response_json = curl_exec($ch);
			curl_close($ch);
			$response=json_decode($response_json, true);
			foreach($response as $row){
				echo("<div class=\"row\">");
				echo("<div class=\"col-md-12\">");
				echo("<p>Name: ".$row['displayname']."</p>");
				echo("<p>Rating: ".$row['rating']."</p>");
				echo("<p>Review: ".$row['review']."</p>");
        echo("<p>Date of visit: ".$row['visitdate']."</p>");
				echo("</div>");
				echo("</div>");
				echo("<hr>");
	    		}
		    ?>

                </div>





        <hr>
       <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>© 2016 Restaurantsearch</p>
                </div>
            </div>
        </footer>

 </div>
    </div>
    <!-- /.container -->



    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <script>
		//Upload image function.
    var rest_ID='<?php echo $rest_ID; ?>';
		var app_url='<?php echo $ini[app_url]?>';
    $("#data").submit(function(e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: app_url+"/api/?uploadImage="+rest_ID,
                type: "POST",
                data: formData,
                async: false,
                success: function (data) {
                    alert(data)
                    window.location = app_url+"/restaurant/?id="+rest_ID;
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        })
    </script>


</body>
