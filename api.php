<?php

	// Connect to database
	$dsn = 'mysql:unix_socket=/cloudsql/whatsdown-d627f:us-central1:whatsdown;dbname=whatsdown';
	$user = 'root';
	$password = 'd0bb3';

	$connection = new PDO($dsn, $user, $password);

	$request_method=$_SERVER["REQUEST_METHOD"];


	switch($request_method)
	{
		case 'GET':
			// Retrive restaurants
			if(!empty($_GET["restaurant_ID"])){
				$restaurant_ID=intval($_GET["restaurant_ID"]);
				get_restaurants($restaurant_ID);
			}
			else if(!empty($_GET["restaurants"])){
				get_restaurants();
			}
			else if(!empty($_GET["review_ID"])){
				$review_ID=intval($_GET["review_ID"]);
				get_reviews($review_ID);
			}
			else if(!empty($_GET["reviews"])){
				get_reviews();
			}

			else {
				header("HTTP/1.0 405 Method Not Allowed");
				break;
			}
			break;
		case 'POST':
			// Insert restaurant
			if(!empty($_GET["insertRestaurant"])){
				insert_restaurant();
			}
			else if(!empty($_GET["insertReview"]))
				insert_review();
			else {
				header("HTTP/1.0 405 Method Not Allowed");
				break;
			}
			break;
			//insert new review
			//create_review();
			break;
		case 'PUT':
			// Update restaurant
			$restaurant_id=intval($_GET["restaurant_ID"]);
			update_restaurant($restaurant_id);
			break;
		case 'DELETE':
			// Delete restaurant

			if(!empty($_GET["deleteRestaurant"])){
				$restaurant_ID=intval($_GET["restaurant_ID"]);
				delete_restaurant($restaurant_ID);
			}
			else if(!empty($_GET["deleteReview"])){
				$restaurant_ID=intval($_GET["review_ID"]);
				delete_review($review_ID);
			}


			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	function get_restaurants($restaurant_ID=0)
	{
		global $connection;
		$query=$connection->prepare("SELECT * FROM restaurants");

		if($restaurant_ID != 0)
		{
			$query=$connection->prepare("SELECT * FROM restaurants WHERE restaurant_ID= :id");
			$query->bindParam(':id',$restaurant_ID);
		}
		$response=array();
		$query->execute();
		while($row=$query->fetch(PDO::FETCH_ASSOC))
		{
			$response[]=$row;
		}

		header('Content-Type: application/json');
		echo json_encode($response);
  }

	function get_reviews($restaurant_ID=0)
	{
		global $connection;
		$query=$connection->prepare("SELECT * FROM reviews");

		if($review_ID != 0)
		{
			$query=$connection->prepare("SELECT * FROM reviews WHERE review_ID=:id");
			$query->bindParam(':id',$review_ID);
		}
		$response=array();
		$query->execute();
		while($row=$query->fetch(PDO::FETCH_ASSOC))
		{
			$response[]=$row;
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function insert_restaurant()
	{
		global $connection;
		$name=$_POST['name'];
		$picture=$_POST['picture'];
		$description=$_POST['description'];
		$location=$_POST['location'];

		$query=$connection->prepare('INSERT INTO restaurants(name, picture, description, location) VALUES (:name, :picture, :description, :location)');
		$query->bindParam(':name',$name);
		$query->bindParam(':picture',$picture);
		$query->bindParam(':description',$description);
		$query->bindParam(':location',$location);

    if($query->execute()){
    	$response=array('status' => 1, 'info' =>'Restaurant added.');
    }
		else{
			$response=array('status' => 0, 'info' =>'Addition failed, please try again.');
		}

	 	header('Content-Type: application/json');
	 	echo json_encode($response);
	}

	function insert_review()
	{
		global $connection;
		$user_ID=$_POST['user_ID'];
		$restaurant_ID=$_POST['restaurant_ID'];
		$review=$_POST['review'];
		$rating=$_POST['rating'];

		$query=$connection->prepare('INSERT INTO reviews(user_ID, restaurant_ID, review, rating) VALUES (:user_ID, :restaurant_ID, :review, :rating)');
		$query->bindParam(':user_ID',$user_ID);
		$query->bindParam(':restaurant_ID',$restaurant_ID);
		$query->bindParam(':review',$review);
		$query->bindParam(':rating',$rating);

	  if($query->execute()){
	    $response=array('status' => 1, 'info' =>'Review added.');
	  }
		else{
			$response=array('status' => 0, 'info' =>'Addition failed, please try again.');
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function delete_restaurant($restaurant_ID)
	{
		global $connection;

		$query=$connection->prepare('DELETE FROM restaurants WHERE restaurant_ID=:id');
		$query->bindParam(':id',$restaurant_ID);

		if($query->execute()){
			$response=array('status' => 1, 'info' =>'Restaurant deleted.');
		}
		else{
					$response=array('status' => 0, 'info' =>'Deletion failed, please try again.');
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function delete_review($review_ID)
	{
	  global $connection;

	  $query=$connection->prepare('DELETE FROM reviews WHERE review_ID=:id');
	  $query->bindParam(':id',$review_ID);

	  if($query->execute()){
	    $response=array('status' => 1, 'info' =>'Review deleted.');
	  }
	  else{
	        $response=array('status' => 0, 'info' =>'Deletion failed, please try again.');
	  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	}
