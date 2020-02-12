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
// get all products from products table
$sql = ("SELECT firstName,lastName,department,class.classID FROM teacher,class,studentClass,department WHERE class.teacherID = teacher.teacherID AND class.classID = studentClass.classID AND studentClass.studentID = '$id' AND department.departmentID = class.departmentID");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["subj"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["firstName"] = $row["firstName"];
        $record["lastName"] = $row["lastName"];
        $record["department"] = $row["department"];
        $record["classID"] = $row["classID"];

        array_push($response["subj"], $record);
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
