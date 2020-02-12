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
$class = $_POST["className"];

$sql = ("SELECT student.firstName, student.lastName, student.studentID FROM student,studentClass,class WHERE class.className = '$class' AND class.classID = studentClass.classID AND student.studentID = studentClass.studentID");
$result = $db->get_con()->query($sql);


// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["students"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["firstName"] = $row["firstName"];
        $record["lastName"] = $row["lastName"];
        $record["studentID"] = $row["studentID"];

        array_push($response["students"], $record);
    }
    // success
    $response["class"] = $class;

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
