<?php
$name=$_POST['rest_name'];
$location=$_POST['rest_loc'];
$description=$_POST['rest_desc'];


	$data=array(
		'name' => $name,
		'description' => $description,
		'location' => $location,
	);

	$url = 'https://whatsdown-d627f.appspot.com/api/?insertRestaurant=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
  //var_dump($response);
	header("Location: https://whatsdown-d627f.appspot.com/pages/admin.php");
	die();


?>
