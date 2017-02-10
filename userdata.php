<?php
session_start();
$dsn = "mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-sd103";
$dbuser = "sd103";
$dbpass = "ooshe9OhNi";

try {
    $pdo = new PDO($dsn, $dbuser, $dbpass, array('charset' => 'utf8'));
}

catch(PDOException $exception){
    echo "Connection error: " . $exception->getMessage();
}

?>