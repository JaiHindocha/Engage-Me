<?php

/*
 * Following code will list all the records on the layouts table
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();


// get all products from products table
$sql = ("SELECT teacherID,firstName,lastName,email,isHead,department FROM teacher,department WHERE teacher.departmentID = department.departmentID AND teacher.active = 0 ORDER BY department,firstName");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["teacher"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["teacherID"] = $row["teacherID"];
        $record["firstName"] = $row["firstName"];
        $record["lastName"] = $row["lastName"];
        $record["email"] = $row["email"];
        $record["department"] = $row["department"];
        if ($row["isHead"] == 1){
          $record["isHead"] = "Head of Department";
        }
        else{
          $record["isHead"] = "Teacher";
        }


        array_push($response["teacher"], $record);
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
