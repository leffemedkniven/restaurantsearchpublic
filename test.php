<?php
use google\appengine\api\cloud_storage\CloudStorageTools;

//Connect to database
$dsn = 'mysql:unix_socket=/cloudsql/whatsdown-d627f:us-central1:whatsdown;dbname=whatsdown';
$user = 'root';
$password = 'd0bb3';

$connection = new PDO($dsn, $user, $password);

$bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
$root_path = 'gs://' . $bucket . '/' . $_SERVER["REQUEST_ID_HASH"] . '/';

$userfile=$_POST['userfile'];
$fname=$_POST['name'];
$type=$_POST['type'];

$public_urls = [];
 foreach($_FILES['userfile']['name'] as $idx => $name) {
   if ($_FILES[$userfile][$type][$idx] === 'image/jpeg' || $_FILES[$userfile][$type][$idx] === 'image/png') {
  //
  //   $original = $root_path . $name;
  //   echo '<pre>';
  //   if(move_uploaded_file($_FILES['userfile']['tmp_name'][$idx], $original)){
  //     echo "File is valid, and was successfully uploaded.\n";
  //     $response=array('status' => 1, 'info' =>'Image uploaded.');
          // $public_urls[] = [
          //     'name' => $name,
          //     'original' => CloudStorageTools::getImageServingUrl($original),
          //      'original_thumb' => CloudStorageTools::getImageServingUrl($original, ['size' => 75]),
          // ];
          //
  //   }
  //   else {
  //   echo "Possible file upload attack!\n";
  //   $response=array('status' => 1, 'info' =>'Image not uploaded.');
  //   }
  //
  //   echo 'Here is some more debugging info:';
  //   print_r($_FILES);
  //
  //   print "</pre>";
  } else {
      echo "Not a jpeg/png\n";
      $response=array('status' => 1, 'info' =>'Image not a jpg/png.');
  }

   header('Content-Type: application/json');
   echo json_encode($response);

}
$response2=array('status' => 1, 'info' =>'ALLT ÄR FEL.');
header('Content-Type: application/json');
echo json_encode($response2);
