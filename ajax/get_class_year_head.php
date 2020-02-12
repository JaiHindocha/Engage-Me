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

$sql = ("SELECT isHead FROM teacher WHERE teacherID = '$id'");
$result = $db->get_con()->query($sql);
$query_arr = mysqli_fetch_assoc($result);
$isHead = $query_arr['isHead'];

if($isHead == 0){
  $sql = ("SELECT className,classID FROM class WHERE yearID = (SELECT yearID FROM year WHERE year = '$year') AND teacherID = '$id'");
}
else{
  $sql = ("SELECT className,classID FROM class WHERE yearID = (SELECT yearID FROM year WHERE year = '$year') AND departmentID = (SELECT departmentID FROM teacher WHERE teacherID = '$id')");
}
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["class"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["className"] = $row["className"];
        $record["classID"] = $row["classID"];

        array_push($response["class"], $record);
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
