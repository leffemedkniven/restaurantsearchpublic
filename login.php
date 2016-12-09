<?php
session_start();

$user_name = json_decode($_POST['name']);
$user_id = json_decode($_POST['id']);


$_SESSION['user_id'] = '1';
$_SESSION['user_name'] = 'Jokke';


echo $user_name;
echo ":Tjena:";
echo $user_id;

?>
