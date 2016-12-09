<!DOCTYPE html>
<?php
include('login.php'); // Includes Login Script
if(!isset($_SESSION['user_id'])){
	header('Location: https://whatsdown-d627f.appspot.com/');
}
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

            <li role="presentation" class="active"><a href="https://whatsdown-d627f.appspot.com/admin/">Admin</a></li>
            <li role="presentation" class="active"><a href="https://whatsdown-d627f.appspot.com/browse/">Back</a></li>

      	<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" 			data-auto-logout-link="true"></div>
          </ul>
        </nav>
        <h3 class="text-muted">Restaurantsearch</h3>
     </div>
<?php 	session_start();
	$user_ID = 1;
	$rest_ID = $_GET['id'];
	$url = 'https://whatsdown-d627f.appspot.com/api/?restaurant_ID='.$rest_ID;
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
                        Upload image:<p/>
                        <input name="file" type="file" /><p/>
                        <input type="hidden" name="restaurant_ID" id="restaurant_ID" value="<?php echo $rest_ID; ?>" />
                        <?php 
				if(isset($_SESSION['user_id'])){
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
				<form action="/pages/review.php" method="post" id="reviewform">
        Rating:
				<input type="radio" name="rate" id="r1" value="1" checked> 1
  				<input type="radio" name="rate" id="r2" value="2"> 2
  				<input type="radio" name="rate" id="r3" value="3"> 3
				<input type="radio" name="rate" id="r4" value="4"> 4
				<input type="radio" name="rate" id="r5" value="5"> 5
				<input type="hidden" name="restaurant_ID" id="restarant_ID" value="<?php echo $rest_ID; ?>" />
				<input type="hidden" name="user_ID" id="user_ID" value="<?php echo $user_ID; ?>" />
        Date of your restaurant visit:
        <input type="date" name="visitdate">
				<textarea class="no-resize-bar form-control" name="review" id="review" rows="2" placeholder="Write a review"></textarea>
			<input type=submit value="submit">
                                </form>     </div>
                                    </div>
                                </div>
                    <hr>

		    <?php
			$url = 'https://whatsdown-d627f.appspot.com/api/?restaurantReviews='.$rest_ID;
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response_json = curl_exec($ch);
			curl_close($ch);
			$response=json_decode($response_json, true);
			foreach($response as $row){
				echo("<div class=\"row\">");
				echo("<div class=\"col-md-12\">");
				echo("<p>".$row['rating']."</p>");
				echo("<p>".$row['review']."</p>");
        echo("<p>".$row['visitdate']."</p>");
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
    var rest_ID='<?php echo $rest_ID; ?>';
    $("#data").submit(function(e) {
            var formData = new FormData($(this)[0]);

            $.ajax({
                url: "https://whatsdown-d627f.appspot.com/api/?uploadImage="+rest_ID,
                type: "POST",
                data: formData,
                async: false,
                success: function (data) {
                    alert(data)
                    window.location = "https://whatsdown-d627f.appspot.com/restaurant/?id="+rest_ID;
                },
                cache: false,
                contentType: false,
                processData: false
            });

            e.preventDefault();
        })
    </script>


</body>
