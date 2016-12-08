<?php
$user_ID=$_POST['user_ID'];
$restaurant_ID=$_POST['restaurant_ID'];
$review=$_POST['review'];
$rate=$_POST['rate'];

	$data=array(
		'user_ID' => $user_ID,
		'restaurant_ID' => $restaurant_ID,
		'review' => $review,
		'rating' => $rate,
	);
	echo($data);
				
	$url = 'https://whatsdown-d627f.appspot.com/api/?insertReview=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPPOST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);	

header('Location: https://whatsdown-d627f.appspot.com/restaurant/?id='.$restaurant_ID.);
die();
?>
