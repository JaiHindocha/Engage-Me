<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$firstName = $_POST['fname'];
$lastName = $_POST['lname'];
$id = $_SESSION['id'];

if (isset($_POST['gender']) && !(isset($_POST['department']))) {
  $gender = $_POST['gender'];
  $sql = ("UPDATE teacher SET firstName = '$firstName',lastName = '$lastName',gender = '$gender' WHERE teacherID = '$id'");
}
if (isset($_POST['department']) && !(isset($_POST['gender']))) {
  $sql = ("UPDATE teacher SET firstName = '$firstName',lastName = '$lastName',departmentID = (SELECT departmentID FROM department WHERE department = '$department') WHERE teacherID = '$id'");
  $department = $_POST['department'];
}

if (isset($_POST['department']) && (isset($_POST['gender']))) {
  $sql = ("UPDATE teacher SET firstName = '$firstName',lastName = '$lastName',gender = '$gender',departmentID = (SELECT departmentID FROM department WHERE department = '$department') WHERE teacherID = '$id'");
}

$result = $db->get_con()->query($sql);

?>
