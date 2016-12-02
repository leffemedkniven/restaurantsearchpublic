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
			if(!empty($_GET["restaurant_ID"]))
			{
				//echo json_encode("if test");
				$restaurant_ID=intval($_GET["restaurant_ID"]);
				get_restaurants($restaurant_ID);
			}
			else
			{
				//echo json_encode("test");
				get_restaurants();
			}
			break;
		case 'POST':
			// Insert restaurant
			insert_restaurant();
			//insert new review
			//create_review();
			break;
		case 'PUT':
			// Update restaurant
			$restaurant_id=intval($_GET["restaurant_id"]);
			update_restaurant($restaurant_id);
			break;
		case 'DELETE':
			// Delete restaurant
			$restaurant_id=intval($_GET["restaurant_id"]);
			delete_restaurant($restaurant_id);
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

	function insert_restaurant()
	{
		global $connection;
		$name=$_POST['name'];
		$picture=$_POST['picture'];
		$description=$_POST['description'];
		$location=$_POST['location'];

		//if(isset($name, $picture, $description, $location)) {
			$query=$connection->prepare('INSERT INTO restaurants(name, picture, description, location) VALUES (':name', ':picture', ':description', ':location')');
			$query->bindParam(':name',$name);
			$query->bindParam(':picture',$picture);
			$query->bindParam(':description',$description);
			$query->bindParam(':location',$location);

    	if($query->execute())
    	{
      	$response=array(
        'status' => 1,
        'status_message' =>'Restaurant added.'
      	);
    	}
			else
	 		{
		 		$response=array(
			 'status' => 0,
			 'status_message' =>'Addition failed, please try again.'
		 		);
	 		}
		// }
		// else
		// {
		//  		$response=array(
		// 	 'status' => 0,
		// 	 'status_message' =>'No Post vars set.'
		//  		);
	 // 		}
	 	header('Content-Type: application/json');
	 	echo json_encode($response);
		}
