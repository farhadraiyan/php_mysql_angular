<?php
$servername = 'localhost';
$username = 'root';
$password = 'root';
$dbname= 'php_login';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(!$conn){
    echo 'Connection erro'.mysqli_connect_error();

}

//echo 'Connect successfully';