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
$sql = ("SELECT isHead FROM teacher WHERE teacherID = '$id'");
$result = $db->get_con()->query($sql);
$head = mysqli_fetch_array($result);
if($head[0] ==0){
  $sql = ("SELECT className,year,classID FROM class,year WHERE teacherID = '$id' AND class.yearID = year.yearID");
}
else{
  $sql = ("SELECT className,year,classID FROM class,year WHERE departmentID = (SELECT departmentID FROM teacher WHERE teacherID = '$id') AND class.yearID = year.yearID");
}

$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["className"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["className"] = $row["className"];
        $record["year"] = $row["year"];
        $record["classID"] = $row["classID"];


        array_push($response["className"], $record);
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
