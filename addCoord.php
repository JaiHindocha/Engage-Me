<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$mousePosX = $_POST['mousePosX'];
$mousePosY = $_POST['mousePosY'];
$boardID = $_POST['boardID'];

$id = $_SESSION["id"];

$sql = "INSERT INTO boardPin (studentID, pinType, coordinatesX, coordinatesY, boardID) VALUES ('$id', 'Start', '$mousePosX', '$mousePosY', '$boardID')";
$result = $db->get_con()->query($sql);

?>
