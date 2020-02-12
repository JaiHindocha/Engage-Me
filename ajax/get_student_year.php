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
$year = $_POST['yeargroup'];

$sql = ("SELECT isHead FROM teacher WHERE teacherID = '$id'");
$result = $db->get_con()->query($sql);
$query_arr = mysqli_fetch_assoc($result);
$isHead = $query_arr['isHead'];

if($isHead == 0){
  $sql = ("SELECT DISTINCT student.studentID,firstName,lastName FROM student,studentClass,class WHERE studentClass.studentID = student.studentID AND studentClass.classID IN (SELECT classID FROM class WHERE teacherID = '$id' AND yearID = (SELECT yearID FROM year WHERE year = '$year'))");
}
else{
  $sql = ("SELECT DISTINCT student.studentID,firstName,lastName FROM student,studentClass,class WHERE studentClass.studentID = student.studentID AND studentClass.classID IN (SELECT classID FROM class WHERE departmentID = (SELECT departmentID FROM teacher WHERE teacherID = '$id') AND yearID = (SELECT yearID FROM year WHERE year = '$year'))");
}

$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["student"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["firstName"] = $row["firstName"];
        $record["lastName"] = $row["lastName"];
        $record["studentID"] = $row["studentID"];

        array_push($response["student"], $record);
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
