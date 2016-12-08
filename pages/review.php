<?php



$user_ID=$_GET['user_ID'];
$restaurant_ID=$_GET['restaurant_ID'];
$review=$_GET['review'];
$rating=$_GET['rating'];

	$data=array(
		'user_ID' => $user_ID,
		'restaurant_ID' => $rest_ID,
		'review' => $review,
		'rating' => $rating
	);
				
	$url = 'https://whatsdown-d627f.appspot.com/api/?insertReview=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPPOST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
	
?>
