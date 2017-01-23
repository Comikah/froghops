<?php
session_start();
$dsn = "mysql:: host=mars.iuk.hdm-stuttgart.de; dbname=u-sd103";
$pdo = new PDO($dsn, 'sd103', 'ooshe9OhNi', array('charset'=>'utf8'));
?>