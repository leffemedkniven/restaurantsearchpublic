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

    	<title>Admin</title>

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

		<form class="form-horizontal" action="/pages/addRestaurant.php" method="post" id="addRestform" autocomplete="off">
		<fieldset>

		<!-- Form for adding a restaurant to the database -->
		<legend>Insert Restaurant</legend>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Name</label>
		  <div class="col-md-4">
		  <input id="textinput" name="rest_name" placeholder="Name" class="form-control input-md" type="text">
		  </div>
		</div>

		<!-- Text input-->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textinput">Location</label>
		  <div class="col-md-4">
		  <input id="textinput" name="rest_loc" placeholder="Location" class="form-control input-md" type="text">
		  </div>
		</div>

		<!-- Textarea -->
		<div class="form-group">
		  <label class="col-md-4 control-label" for="textarea">Description</label>
		  <div class="col-md-4">
		    <textarea class="form-control" id="textarea" name="rest_desc"></textarea>
		  </div>
		</div>
		<input type=submit value="submit">

		</fieldset>
		</form>

      <footer class="footer">
        <p>&copy; 2016 Restaurantsearch</p>
      </footer>
</div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
