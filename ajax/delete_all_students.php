<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$class = $_POST['class_'];

$sql = "DELETE FROM class WHERE className = '$class'";
$result = $db->get_con()->query($sql);

?>
