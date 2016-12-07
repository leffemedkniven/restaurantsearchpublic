<!DOCTYPE html>
<html lang="en">

<head>
<?php 	session_start();
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
		//$rest_pic = $row['picture'];
		
	}

?>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Restaurant</title>

    <!-- Bootstrap Core CSS -->
    <link href="../static/onerestaurant/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../static/onerestaurant/css/shop-item.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="https://whatsdown-d627f.appspot.com/browse/">Back</a></li>
      	<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" 			data-auto-logout-link="true"></div>
          </ul>
        </nav>
     </div>


    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <div class="col-md-9">

                <div class="thumbnail">
                    <img class="img-responsive" src="http://placehold.it/800x300" alt="">
                    <div class="caption-full">
                        <h4 class="pull-right"><?php echo $rest_loc;?></h4>
                        <h4><?php echo $rest_name;?></h4>
                        <p><?php echo $rest_desc;?> </p>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">n reviews</p>
                        <p>
                            Rating
                        </p>
                    </div>
                </div>

                <div class="well">
			       <div class="row send-wrap">
                                    <div class="send-message">
                                        <div class="message-text">
                                            <textarea class="no-resize-bar form-control" id="message" rows="2" placeholder="Write a review"></textarea>
				<form>
				<input type="hidden" id="rest_ID" value="<?php echo $rest_ID ?>" />
				<input type="hidden" id="user_ID" value="<?php echo $user_ID ?>" />
                                </form>     </div>
                                    </div>
                                </div>
                    <div class="text-right">
                        <a class="btn btn-default" role="button" onclick="reviewFunction()">Leave a Review</a>
                    </div>

		<script>
			function reviewFunction() {
				var rev = document.getElementById('message').value;
				var uID = document.getElementById('user_ID').value;
				var rID = document.getElementById('rest_ID').value;
				var rate = document.getElementById('rating').value;
				alert(rev);
			//	$.ajax({
			//url: 'https://whatsdown-d627f.appspot.com/api/?restaurantReviews=1',
			//	    type: 'post',
			//data: {"user_ID": uID, "restaurant_ID": rID, "rating": rate, "review": rev},
			//	    success: function(response) { console.log(response); }
			//	});
			}
		</script>

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
				echo("</div>");
				echo("</div>");
				echo("<hr>");
	    		}

		    ?>
<!--
                    <div class="row">
                        <div class="col-md-12">
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star"></span>
                            <span class="glyphicon glyphicon-star-empty"></span>
                            Anonymous
                            <span class="pull-right">10 days ago</span>
                            <p>This product was great in terms of quality. I would definitely buy another!</p>
                        </div>
                    </div>

                    <hr>
-->
                </div>

            </div>

        </div>

    </div>
    <!-- /.container -->

    <div class="container">

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>© 2016 Company, Inc.</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
