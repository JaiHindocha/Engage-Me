<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$id = $_POST['id'];

$sql = ("UPDATE teacher SET adminVerified = 1,active=1 WHERE teacherID = '$id'");
$result = $db->get_con()->query($sql);

?>
