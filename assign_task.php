<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$class= $_POST['class_'];
$task = $_POST['task'];
$dateinp = $_POST['date'];

$date = date("Y-m-d",strtotime($dateinp));

$sql = "INSERT INTO boards (taskID, classID, date)
SELECT tasks.taskID, class.classID, '$date'
FROM tasks,class
WHERE tasks.taskName = '$task' AND class.className = '$class'
AND NOT EXISTS
(SELECT boardID FROM boards WHERE taskID = (SELECT taskID FROM tasks WHERE taskName = '$task') AND classID = (SELECT classID FROM class WHERE className = '$class') AND date = '$date')";
$result = $db->get_con()->query($sql);

?>
