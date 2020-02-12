<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

$password = password_hash('admin', PASSWORD_DEFAULT);

$sql = "INSERT INTO admin(username,password) VALUES ('dubaicollege','$password')";
$result = $db->get_con()->query($sql);

?>
