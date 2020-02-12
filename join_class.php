<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$code = $_POST['inpcode'];

$id = $_SESSION['id'];

$sql = "INSERT INTO studentClass (classID, studentID) VALUES ((SELECT classID FROM classCode WHERE code = '$code'), '$id')";
$result = $db->get_con()->query($sql);

?>
