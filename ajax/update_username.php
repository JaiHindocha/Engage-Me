<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$username = $_POST['username'];
$id = $_SESSION['id'];

$sql = ("UPDATE admin SET username = '$username' WHERE adminID = '$id'");
$result = $db->get_con()->query($sql);

?>
