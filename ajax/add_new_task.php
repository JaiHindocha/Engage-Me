<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$id= $_SESSION['id'];
$task= $_POST['task'];
$year = $_POST['year'];
$date = date('Y-m-d H:i:s');

$sql = "INSERT INTO tasks(taskName,taskDate,teacherID,yearID) VALUES ('$task','$date','$id',(SELECT yearID FROM year WHERE year='$year'))";
$result = $db->get_con()->query($sql);

?>
