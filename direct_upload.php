<?php
// Direct uploads requires PHP 5.5 on App Engine.
if (strncmp("5.5", phpversion(), strlen("5.5")) != 0) {
  die("Direct uploads require the PHP 5.5 runtime. Your runtime: " . phpversion());
}
?>
<html>
<body>
<form action="upload" method="POST" enctype="multipart/form-data">
  Send these files:<p/>
  <input name="userfile[]" type="file" multiple="multiple"/><p/>
  <input type="submit" value="Send files" />
</form>
</body>
</html>

<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){

// $tmpfile = $_FILES['userfile']['tmp_name'];
// $filename = basename($_FILES['userfile']['name']);
// $data = array(
  //'uploaded_file' => curl_file_create($tmpfile, $_FILES['userfile']['type'], $filename
//);
//
//
//   $url = 'https://whatsdown-d627f.appspot.com/api/?uploadImage=1';
//   $ch = curl_init($url);
//   curl_setopt($ch, CURLOPT_POST, true);
//   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//   $response_json = curl_exec($ch);
//   curl_close($ch);
//   $response=json_decode($response_json, true);

 $tmpfile = $_FILES['userfile']['tmp_name'];
 $filename = basename($_FILES['userfile']['name']);
 $filetype = $_FILES['userfile']['type'];

 // Connecting to external api via cURL
 $curl_handle = curl_init("https://whatsdown-d627f.appspot.com/api/?uploadImage=1");
 // curl_setopt($curl_handle, CURLOPT_POST, 1);
 // $args['file'] = new CurlFile($tmpfile, $filetype, $filename);
 // curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $args);
 //curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
 //
 // //execute the API Call
 // $returned_data = curl_exec($curl_handle);
 // curl_close ($curl_handle);
 //
 // echo $returned_data;
}

?>
