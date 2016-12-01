	// Connect to database
	$dsn = 'mysql:unix_socket=/cloudsql/whatsdown-d627f:us-central1:whatsdown;dbname=DATABASE';
	$user = 'root';
	$password = 'd0bb3';

	$connection = new PDO($dsn, $user, $password);

	$request_method=$_SERVER["REQUEST_METHOD"];
	switch($request_method)
	{
		case 'GET':
			// Retrive restaurants
			if(!empty($_GET["restaurant_id"]))
			{
				$restaurant_id=intval($_GET["restaurant_id"]);
				get_restaurants($restaurant_id);
			}
			else
			{
				get_restaurants();
			}
			break;
		case 'POST':
			// Insert restaurant
			insert_restaurant();
			//insert new review
			create_review();
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

	function get_restaurants($product_id=0)
	{
		global $connection;
		$query="SELECT * FROM restaurants";
		if($product_id != 0)
		{
			$query.=" WHERE id=".$product_id.;
		}
		$response=array();
		$result=mysqli_query($connection, $query);
		while($row=mysqli_fetch_array($result))
		{
			$response[]=$row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
