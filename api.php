<?php
	use google\appengine\api\cloud_storage\CloudStorageTools;

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
			//RestaurantRevies takes the value of the restaurant_ID
			else if(!empty($_GET["restaurantReviews"])){
				$restaurantReviews=intval($_GET["restaurantReviews"]);
				get_reviews($restaurantReviews);
			}
			else if(!empty($_GET["reviews"])){
				get_reviews();
			}

			else if(!empty($_GET["users"])){
			  get_users();
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
			else if(!empty($_GET["getUser"])){
				get_users();
			}
			else if(!empty($_GET["insertReview"])){
				insert_review();
			}
			else if(!empty($_GET["insertUser"])){
				insert_user();
			}
			else if(!empty($_GET["uploadImage"])){
				$restaurant_ID=intval($_GET["uploadImage"]);

				upload_image($restaurant_ID);
			}
			else {
				header("HTTP/1.0 405 Method Not Allowed");
				break;
			}
			break;
		case 'PUT':
			// Update restaurant
			$restaurant_ID=intval($_GET["restaurant_ID"]);
			update_restaurant($restaurant_ID);
			break;
		case 'DELETE':
			// Delete restaurant

			if(!empty($_GET["restaurant_ID"])){
				$restaurant_ID=intval($_GET["restaurant_ID"]);
				delete_restaurant($restaurant_ID);
			}
			else if(!empty($_GET["review_ID"])){
				$review_ID=intval($_GET["review_ID"]);
				delete_review($review_ID);
			}
			else if(!empty($_GET["user_ID"])){
				$user_ID=intval($_GET["user_ID"]);
				delete_user($user_ID);
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
		$query=$connection->prepare("SELECT restaurant_ID, name, picture, description, location FROM restaurants");

		if($restaurant_ID != 0)
		{
			$query=$connection->prepare("SELECT name, picture, description, location FROM restaurants WHERE restaurant_ID= :id");
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

	function get_reviews($restaurantReviews=0)
	{
		global $connection;
		$query=$connection->prepare("SELECT * FROM reviews");

		if($restaurantReviews != 0)
		{
			$query=$connection->prepare("SELECT * FROM reviews WHERE restaurant_ID=:id");
			$query->bindParam(':id',$restaurantReviews);
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

	function get_users($user_ID=0)
	{
		global $connection;
		$user_ID=$_POST['user_ID'];
		$query=$connection->prepare("SELECT * FROM users");

		if($user_ID != 0)
		{
			$query=$connection->prepare("SELECT * FROM users WHERE user_ID=:id");
			$query->bindParam(':id',$user_ID);
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
		//$picture=$_POST['picture'];
		$description=$_POST['description'];
		$location=$_POST['location'];

		$query=$connection->prepare('INSERT INTO restaurants(name, description, location) VALUES (:name, :description, :location)');
		$query->bindParam(':name',$name);
		//$query->bindParam(':picture',$picture);
		$query->bindParam(':description',$description);
		$query->bindParam(':location',$location);

    if($query->execute()){
    	$response=array('status' => 1, 'info' =>'Restaurant added.');
    }
		else{
			$response=array('info' =>'Addition failed, please try again.');
		}

	 	header('Content-Type: application/json');
	 	echo json_encode($response);
	}

	function insert_review()
	{
		global $connection;
		$user_ID=$_POST['user_ID'];
		$restaurant_ID=$_POST['restaurant_ID'];
		$displayname=$_POST['displayname'];
		$review=$_POST['review'];
		$rating=$_POST['rating'];
		$visitdate=$_POST['visitdate'];


		$parts = explode('/',$visitdate);
		$vdate = $parts[2] . '-' . $parts[0] . '-' . $parts[1];

		$query=$connection->prepare('INSERT INTO reviews(user_ID, restaurant_ID, displayname, review, rating, visitdate) VALUES (:user_ID, :restaurant_ID, :displayname, :review, :rating, :visitdate)');
		$query->bindParam(':user_ID',$user_ID);
		$query->bindParam(':restaurant_ID',$restaurant_ID);
		$query->bindParam(':displayname',$displayname);
		$query->bindParam(':review',$review);
		$query->bindParam(':rating',$rating);
		$query->bindParam(':visitdate',$visitdate);

	  if($query->execute()){
	    $response=array('info' =>'Review added.');

	  }
		else{
			$response=array('info' =>'Addition failed, please try again.', 'vdate' => $vdate, 'visitdate' => $visitdate );
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function insert_user()
	{
	  global $connection;
		$user_ID = $_POST['user_ID'];
	  $displayname=$_POST['displayname'];
	  $profilepic=$_POST['profilepic'];
		$admin=$_POST['admin'];

	  $query=$connection->prepare('INSERT INTO users(user_ID, displayname, profilepic, admin) VALUES (:user_ID, :displayname, :profilepic, :admin)');
		$query->bindParam(':user_ID',$user_ID);
	  $query->bindParam(':displayname',$displayname);
	  $query->bindParam(':profilepic',$profilepic);
		$query->bindParam(':admin',$admin);

	  if($query->execute()){
	    $response=array('info' =>'user added.');
	  }
	  else{
	    $response=array('info' =>'Addition failed, please try again.');
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
			$response=array('info' =>'Restaurant deleted.');
		}
		else{
					$response=array('info' =>'Deletion failed, please try again.');
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
	    $response=array('info' =>'Review deleted.');
	  }
	  else{
	        $response=array('info' =>'Deletion failed, please try again.');
	  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	}

	function delete_user($user_ID)
	{
	  global $connection;

	  $query=$connection->prepare('DELETE FROM users WHERE user_ID=:id');
	  $query->bindParam(':id',$user_ID);

	  if($query->execute()){
	    $response=array('info' =>'User deleted.');
	  }
	  else{
	        $response=array('info' =>'Deletion failed, please try again.');
	  }

	  header('Content-Type: application/json');
	  echo json_encode($response);
	}

	function update_restaurant($restaurant_ID)
	{
		global $connection;
		$id=$restaurant_ID;
		parse_str(file_get_contents("php://input"),$post_variables);
		$name=$post_variables['name'];
		$picture=$post_variables['picture'];
		$description=$post_variables['description'];
		$location=$post_variables['location'];

		$query=$connection->prepare('UPDATE restaurants SET name=:name, picture=:picture, description=:description, location=:location WHERE restaurant_ID=:id');
		$query->bindParam(':id',$id);
		$query->bindParam(':name',$name);
		$query->bindParam(':picture',$picture);
		$query->bindParam(':description',$description);
		$query->bindParam(':location',$location);

		if($query->execute()){
			$response=array('info' =>'Restaurant updated.');
		}
		else{
			$response=array('info' =>'Update failed, please try again.');
		}

		header('Content-Type: application/json');
		echo json_encode($response);
	}

	function upload_image($restaurant_ID)
	{
		global $connection;

		$bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
		$root_path = 'gs://' . $bucket . '/' . $_SERVER["REQUEST_ID_HASH"] . '/';

		$name = $_FILES['file']['name'];
		$public_urls = [];
		if ($_FILES['file']['type'] === 'image/jpeg' || $_FILES['file']['type'] === 'image/png') {

		    $original = $root_path . $name;

		    if(move_uploaded_file($_FILES['file']['tmp_name'], $original)){
		      echo "Success!.\n";
					$response=array('info' =>'Image uploaded.');
					$public_urls[] = [
								'name' => $name,
								'original' => CloudStorageTools::getImageServingUrl($original),
								];

					foreach($public_urls as $urls) {
	        $original=$urls['original'];
					}

					$query=$connection->prepare('UPDATE restaurants SET picture=:pic WHERE restaurant_ID=:id');
					$query->bindParam(':pic',$original);
					$query->bindParam(':id', $restaurant_ID);

					if($query->execute()){
						$response=array('info' =>'Picture added.');
					}
					else{
						$response=array('info' =>'Addition failed, please try again.');
					}

				}
				else {
		    echo "Possible file upload attack!\n";
		    }

		} else {
			echo "Please try again.\n";
		  $response=array('info' =>'Not a jpeg/png.');
		}
			header('Content-Type: application/json');
			echo json_encode($response);
	}
