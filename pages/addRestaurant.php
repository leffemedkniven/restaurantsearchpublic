<?php
//Adds a restaurant via the API
$name=$_POST['rest_name'];
$location=$_POST['rest_loc'];
$description=$_POST['rest_desc'];


	$data=array(
		'name' => $name,
		'description' => $description,
		'location' => $location,
	);
	$ini = parse_ini_file('configURL.ini');

	$url = $ini[app_url] . '/api/?insertRestaurant=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
  //var_dump($response);
    header('Location: ' . $ini[app_url] . '/browse/',true,303);
	die();


?>
