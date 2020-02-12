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
$sql = ("SELECT department FROM department");
$result = $db->get_con()->query($sql);

// check for empty result
if ($result->num_rows > 0) {
    // looping through all results
    $response["deps"] = array();

    while ($row = $result->fetch_assoc()) {
        $record = array();
        $record["department"] = $row["department"];

        // $record["gameID"] = $row["gameID"];
        array_push($response["deps"], $record);
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
