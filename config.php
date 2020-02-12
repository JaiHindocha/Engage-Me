<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

define('DB_USER', "jai8031_admin"); // db user
define('DB_PASSWORD', "HelloWorld123"); // db password
define('DB_DATABASE', "jai8031_engage_me"); // database name
define('DB_SERVER', "localhost"); // db server

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
