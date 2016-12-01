// Connect to database
// Connect to database
$dsn = 'mysql:unix_socket=/cloudsql/whatsdown-d627f:us-central1:whatsdown;dbname=DATABASE';
$user = 'root';
$pass = 'd0bb3';

	$request_method=$_SERVER["REQUEST_METHOD"];
	switch($request_method)
	{
		case 'GET':
			// Retrive restaurant
			if(!empty($_GET["restaurant_id"]))
			{
				$restaurant_id=intval($_GET["restaurant_id"]);
				get_restaurants($restaurant_id);
			}
			else
			{
				get_products();
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
