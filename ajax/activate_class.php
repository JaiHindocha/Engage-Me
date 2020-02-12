<?php

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

session_start();

$className = $_POST['className2'];

$date = date('Y-m-d H:i:s');
$dateEnd = date('Y-m-d H:i:s',strtotime('+1 hour',strtotime($date)));

function generateCode($length) {
    $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength = strlen($chars);
    $code = '';
    for ($i = 0; $i < $length; $i++) {
        $code .= $chars[rand(0, $charLength - 1)];
    }
    return $code;
}

$classCode = generateCode(6);

$sql = "INSERT INTO classCode (classID, start, end_time, code) VALUES ((SELECT classID FROM class WHERE className = '$className'), '$date', '$dateEnd', '$classCode')";
// echo $sql;
$result = $db->get_con()->query($sql);

echo $classCode;

?>
