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

$sql = ("SELECT boardID,taskName,className,date
  FROM boards,class,tasks
  WHERE boards.classID IN (SELECT classID FROM class WHERE teacherID = '$id' AND yearID = (SELECT yearID FROM year WHERE year = '$year'))
  AND boards.classID = class.classID
  AND boards.taskID IN (SELECT taskID FROM tasks WHERE yearID = (SELECT yearID FROM year WHERE year = '$year'))
  AND boards.taskID = tasks.taskID");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["taskSet"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["taskName"] = $row["taskName"];
        $record["boardID"] = $row["boardID"];
        $record["className"] = $row["className"];
        $record["date"] = $row["date"];

        array_push($response["taskSet"], $record);
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
