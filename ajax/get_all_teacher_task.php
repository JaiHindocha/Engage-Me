<?php

/*
 * Following code will list all the records on the layouts table
 */

// array for JSON response

session_start();

$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();


// get all products from products table
$id = $_SESSION["id"];
$year = $_POST['year'];

$sql = ("SELECT taskID,taskName FROM teacher,tasks WHERE tasks.yearID = (SELECT yearID FROM year WHERE year = '$year') AND tasks.teacherID = teacher.teacherID AND tasks.teacherID IN (SELECT teacherID FROM teacher WHERE teacherID != '$id' AND departmentID = (SELECT departmentID FROM teacher WHERE teacherID = '$id'))");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["task"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["taskName"] = $row["taskName"];
        $record["taskID"] = $row["taskID"];


        array_push($response["task"], $record);
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
