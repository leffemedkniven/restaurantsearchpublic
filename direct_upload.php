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

$tmpfile = $_FILES['image']['tmp_name'];
// $filename = basename($_FILES['image']['name']);
// $data = array(
//   'uploaded_file' => curl_file_create($tmpfile, $_FILES['image']['type'], $filename
// );
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
 }
?>
