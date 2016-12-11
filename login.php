<?php

session_start();

// $x = json_decode($_POST['name']);
$y = json_decode($_POST['data']);
$data = $_POST['data'];
// $user_name = json_decode($_POST['name']);
// $user_id = json_decode($_POST['id']);


// $_SESSION['user_id'] = "1";
// $_SESSION['user_name'] = 'Jokke';
// $_SESSION['admin'] = true;


// echo $user_name;
// echo ":Tjena:";
//
// echo $user_id;
// echo $x;
print_r("hih".$y);
print_r("hih2".$data);
echo $data;

?>
