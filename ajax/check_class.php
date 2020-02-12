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
$code = $_POST["code"];
$id = $_SESSION['id'];

$sql = ("SELECT className,end_time FROM class,classCode WHERE (SELECT classID FROM classCode WHERE code = '$code') = class.classID AND classCode.code = '$code'");
$result = $db->get_con()->query($sql);
// echo $result;

if ($result->num_rows > 0) {
    $response["className"] = array();
    $row = $result->fetch_assoc();
    $response["className"] = $row["className"];
    $response["code"] = $code;

    $date = date('Y-m-d H:i:s');
    $databasedate = date('Y-m-d H:i:s', strtotime($row['end_time']));

    if ($date > $databasedate){
      $response["dateValid"] = 0;
    }
    else{
      $response["dateValid"] = 1;
    }

    $sql = ("SELECT studentID FROM studentClass WHERE (SELECT classID FROM classCode WHERE code = '$code') = studentClass.classID AND studentClass.studentID = '$id'");
    $result = $db->get_con()->query($sql);

    if ($result->num_rows > 0) {
      $response["inClass"] = 1;
    }
    else{
      $response["inClass"] = 0;
    }

    $response["valid"] = 1;


    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["valid"] = 0;
    $response["message"] = "No records found";

    // echo no users JSON
    echo json_encode($response);
}

?>
