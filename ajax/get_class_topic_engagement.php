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
$taskID = $_POST['task'];
$classID = $_POST['class_'];
$year = $_POST['year'];


$sql = ("SELECT coordinatesX,coordinatesY,pinType,student.firstName,student.lastName,boards.date FROM boardPin,boards,student,studentClass WHERE boardPin.boardID = boards.boardID AND boards.taskID = '$taskID' AND boards.classID = '$classID' AND student.studentID = studentClass.studentID
  AND studentClass.classID = boards.classID");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["pin"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["coordinatesX"] = $row["coordinatesX"];
        $record["coordinatesY"] = $row["coordinatesY"];
        $record["pinType"] = $row["pinType"];
        $record["firstName"] = $row["firstName"];
        $record["lastName"] = $row["lastName"];
        $record["date"] = $row["date"];

        array_push($response["pin"], $record);
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
