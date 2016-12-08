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

	$url = 'https://whatsdown-d627f.appspot.com/api/?insertReview=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPPOST, true);
	echo "hej";
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	echo "svej";
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	echo "hallon";
	$response_json = curl_exec($ch);
	echo "paj";
	curl_close($ch);
	echo "lol";
	$response=json_decode($response_json, true);
	echo "slut";
    if ($response['status']==1){
        header('Location: https://whatsdown-d627f.appspot.com/restaurant/?id='.$restaurant_ID.);
        exit;
    } else {
	echo "RIP";
    }

?>
