<?php

use google\appengine\api\cloud_storage\CloudStorageTools;

$bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
$root_path = 'gs://' . $bucket . '/' . $_SERVER["REQUEST_ID_HASH"] . '/';

$public_urls = [];
foreach($_FILES['userfile']['name'] as $idx => $name) {
  if ($_FILES['userfile']['type'][$idx] === 'image/jpeg' || $_FILES['userfile']['type'][$idx] === 'image/png') {
    // $im = imagecreatefromjpeg($_FILES['userfile']['tmp_name'][$idx]);
    // imagefilter($im, IMG_FILTER_GRAYSCALE);
    // $grayscale = $root_path .  'gray/' . $name;
    // imagejpeg($im, $grayscale);

    $original = $root_path . $name;
    echo '<pre>';
    if(move_uploaded_file($_FILES['userfile']['tmp_name'][$idx], $original)){
      $public_urls[] = [
        'name' => $name,
        'original' => CloudStorageTools::getImageServingUrl($original),
        'original_thumb' => CloudStorageTools::getImageServingUrl($original, ['size' => 75]),
    ];


      echo "File is valid, and was successfully uploaded.\n";
    }
    else {
    echo "Possible file upload attack!\n";
    }

    echo 'Here is some more debugging info:';
    print_r($_FILES);

    print "</pre>";
  } else {
    echo "Not a jpeg/png\n";
  }

}
?>
<html>
<body>
<?php
foreach($public_urls as $urls) {
  echo '<a href="' . $urls['original'] .'"><IMG src="' . $urls['original_thumb'] .'"></a> ';
  echo '<p>';
}
?>
<p>
<a href="/direct/">Upload More</a>
</body>
</html>
