<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$id = $_POST['classID'];

$sql = "DELETE FROM class WHERE class = '$id'";

$result = $db->get_con()->query($sql);

?>
