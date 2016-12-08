<?php
$restaurant_ID=$_POST['restaurant_ID'];
$location=$_POST['rest_loc'];
$description=$_POST['rest_desc'];

echo $restaurant_ID;
echo $location;
echo $description;


	$data=array(
		'restaurant_ID' => $restaurant_ID,
		'description' => $description,
		'location' => $location,
	);
/*
	$url = 'https://whatsdown-d627f.appspot.com/api/?insertReview=1';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
  var_dump($response);

    if ($response['status']==1){
         header('Location: https://whatsdown-d627f.appspot.com/restaurant/?id='.$restaurant_ID.);
      exit;
     } else {
	 echo "Something went wrong";
    }
*/
?>
