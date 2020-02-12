<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$id = $_POST['id'];
$class = $_POST['class_'];

$sql = "DELETE FROM studentClass WHERE studentID = '$id' AND classID = (SELECT classID FROM class WHERE className = '$class')";
$result = $db->get_con()->query($sql);

?>
