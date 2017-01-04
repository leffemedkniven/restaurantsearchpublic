<?php
//Adds a review via the API

$user_ID=$_POST['user_ID'];
$restaurant_ID=$_POST['restaurant_ID'];
$displayname=$_POST['displayname'];
$review=$_POST['review'];
$rate=$_POST['rate'];
$visitdate=$_POST['visitdate'];

	$data=array(
		'user_ID' => $user_ID,
		'restaurant_ID' => $restaurant_ID,
		'displayname' => $displayname,
		'review' => $review,
		'rating' => $rate,
		'visitdate' => $visitdate,
	);

	$url = 'https://whatsdown-d627f.appspot.com/api/?insertReview=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);


  header("Location: https://whatsdown-d627f.appspot.com/restaurant/?id=".$restaurant_ID);
?>
