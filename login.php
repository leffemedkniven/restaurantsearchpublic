<?php
<<<<<<< HEAD
session_start();
=======
$x = json_decode($_POST["data"]);
$y = json_decode($_POST["data"]);
>>>>>>> ce9790c396c0fb5e1c2ed8ecca35cc863280fedc

$user_name = json_decode($_POST['name']);
$user_id = json_decode($_POST['id']);


$_SESSION['user_id'] = '1';
$_SESSION['user_name'] = 'Jokke';


echo $user_name;
echo ":Tjena:";
<<<<<<< HEAD
echo $user_id;
=======
print_r("hih".$y);

>>>>>>> ce9790c396c0fb5e1c2ed8ecca35cc863280fedc

?>
