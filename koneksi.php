<?php
define('HOST','localhost');
define('USER','root');
define('PASS','');
define('DB','fazztrack');

$con = mysqli_connect(HOST,USER,PASS,DB) or die('Tidak terhubung Database');
?>