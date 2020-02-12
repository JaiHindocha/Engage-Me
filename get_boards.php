<?php

/*
 * Following code will list all the records on the layouts table
 */

// array for JSON response
$response = array();
session_start();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$id = $_SESSION["id"];
$classID = $_POST['subj'];
$date = date('Y-m-d');
// get all products from products table

$sql = ("SELECT boards.boardID,taskName,boards.date FROM tasks,boards WHERE tasks.taskID = boards.taskID AND boards.classID = '$classID' AND boards.date <= '$date'
  AND boards.boardID NOT IN (SELECT boardID FROM boardPin WHERE boardID IN (SELECT boardID FROM boards WHERE classID = '$classID') AND studentID = '$id' GROUP BY boardID HAVING COUNT(boardID) > 1)");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["boards"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["taskName"] = $row["taskName"];
        $record["date"] = $row["date"];
        $record["boardID"] = $row["boardID"];

        array_push($response["boards"], $record);
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No records found";

    // echo no users JSON
    echo json_encode($response);
}

?>
