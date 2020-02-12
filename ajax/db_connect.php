<?php
class DB_CONNECT {

	private $con;
    function __construct() {
        $this->connect();
    }
    function __destruct() {
        $this->close();
    }

    function connect() {
        require_once __DIR__ . '/db_config.php';
        $this->con = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
		if ($this->con->connect_error) {
			die("Failed to connect to MySQL: ".$this->con->connect_error);
		};
	}

	function get_con() {
        return $this->con;
    }
    function close() {
        $this->con->close();
    }
}
?>
