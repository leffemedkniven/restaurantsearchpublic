<?php

$new_rev = $_GET['new_review'];
echo($new_rev);
/*				
	if(new_rev!=null) {
	$data=array(
		'user_ID' => 1,
		'restaurant_ID' => $rest_ID,
		'review' => rev,
		'rating' => 4
	);
				
	$url = 'https://whatsdown-d627f.appspot.com/api/?insertReview=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPPOST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
*/
?>
