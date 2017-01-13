<?php
session_start();
session_destroy();
$ini = parse_ini_file('configURL.ini');
header('Location: '. $ini[app_url]);
 ?>
