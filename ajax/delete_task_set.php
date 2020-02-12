<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$id = $_POST['id'];

$sql = "DELETE FROM boards WHERE boardID = '$id'";
$result = $db->get_con()->query($sql);

?>
