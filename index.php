<!DOCTYPE html>
<html>
<head>

    <title>Login</title>

    <?php require_once __DIR__ . '/vendor/autoload.php';
    session_start();
    if(isset($_SESSION['fb_access_token'])){

        header('Location: https://whatsdown-d627f.appspot.com/browse/');

        }


    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">


    <!-- Bootstrap core CSS -->
    <link href="static/bootstrap-3.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="static/bootstrap-3.3.7/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="static/bootstrap-3.3.7/docs/examples/signin/signin.css" rel="stylesheet">

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
      <form class="form-signin">
        <center><h2 class="form-signin-heading">RestaurantSearch</h2></center>
        <center><h2 class="form-signin-heading">Please sign in</h2></center>

        <!--
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        -->

      <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="true"></div>
      </form>

    </div> <!-- /container -->

<?php
  //session_start();
  $fb = new Facebook\Facebook([
          'app_id' => '1814790452137377', // Replace {app-id} with your app id
          'app_secret' => '006b213f54e5c9d124167fdde6e8d29a',
          'default_graph_version' => 'v2.2',
  ]);


  $helper = $fb->getRedirectLoginHelper();

  $permissions = ['email']; // Optional permissions
  $loginUrl = $helper->getLoginUrl('https://whatsdown-d627f.appspot.com/fb-callback.php', $permissions);
  echo '<a href="' . htmlspecialchars($loginUrl) . '"><center>Log in with Facebook!</center></a>';

?>
