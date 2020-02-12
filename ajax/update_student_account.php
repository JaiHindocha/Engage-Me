<?php
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$firstName = $_POST['fname'];
$lastName = $_POST['lname'];
$id = $_SESSION['id'];

$sql = ("UPDATE student SET firstName = '$firstName',lastName = '$lastName'");
$result = $db->get_con()->query($sql);

if (isset($_POST['gender']) && !(isset($_POST['year']))) {
  $gender = $_POST['gender'];
  $sql = ("UPDATE student SET firstName = '$firstName',lastName = '$lastName',gender = '$gender' WHERE studentID = '$id'");
  $result = $db->get_con()->query($sql);

}
if (isset($_POST['year']) && !(isset($_POST['gender']))) {
  $sql = ("UPDATE student SET firstName = '$firstName',lastName = '$lastName',yearID = (SELECT yearID FROM year WHERE year = '$year') WHERE studentID = '$id'");
  $result = $db->get_con()->query($sql);

}

if (isset($_POST['year']) && (isset($_POST['gender']))) {
  $sql = ("UPDATE student SET firstName = '$firstName',lastName = '$lastName',gender = '$gender',yearID = (SELECT yearID FROM year WHERE year = '$year') WHERE studentID = '$id'");
  $result = $db->get_con()->query($sql);
}

?>
