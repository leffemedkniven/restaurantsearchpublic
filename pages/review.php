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
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
  var_dump($response_json);
  var_dump($response);


	// echo "slut";
  //   if ($response['status']==1){
  //       header('Location: https://whatsdown-d627f.appspot.com/restaurant/?id='.$restaurant_ID.);
  //       exit;
  //   } else {
	// echo "RIP";
  //   }

?>
