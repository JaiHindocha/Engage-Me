<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if(isset($_SESSION["student"])&& $_SESSION["student"] === true){
    header("location: student.php");
    exit;
}
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

$name = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  $name = $_POST["name"];
  $year = $_POST["year"];
  $id = $_SESSION["id"];

  $sql = ("INSERT INTO class (teacherID, className, yearID, departmentID) VALUES ('$id','$name',(SELECT yearID FROM year WHERE year = '$year'),(SELECT departmentID FROM teacher WHERE teacherID = '$id'))");
  $result = $db->get_con()->query($sql);

  if(isset($_SESSION["head"]) && $_SESSION["head"] === true){
    header("location: headteacher.php");
    exit;
  }
  else {
    header("location: teacher.php");
    exit;
  }
}

?>

<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Home</title>

		<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700" rel="stylesheet">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

		<script src="https://code.jquery.com/jquery-3.1.1.min.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
		<script src="https://cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>

		<!-- CODE WRITTEN BY TEMPLATE CREATOR -->
		<link rel="stylesheet" href="css/animate.css">
		<link rel="stylesheet" href="css/icomoon.css">
		<link rel="stylesheet" href="css/flexslider.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/modernizr-2.6.2.min.js"></script>

    <script>
    var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var year = "";
              for (i=0;i<myRecords.year.length;i++) {
                  var myRecord = myRecords.year[i];
                  var newYear = "<option>"+myRecord.year+"</option>";
                  year = year+newYear;
              }
              document.getElementById("year").innerHTML = year;
          }
      };

      xmlhttp.open("GET", "ajax/get_year.php", true);
      xmlhttp.send();

    </script>

	</head>

	<body>
	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<h1 id="fh5co-logo">Engage Me</h1>

			<nav id="fh5co-main-menu" role="navigation">
				<ul>
          <li><a href="teacher.php">Home</a></li>
          <li><a href="teacher.php">My Account</a></li>
          <li><a href="addNewTask.php">Add New Task</a></li>
          <li><a href="teacher.php">View Engagement</a></li>
          <li><a href="setTask.php">Set Topic</a></li>
          <li class="fh5co-active"><a href="createClass.php">Create Class</a></li>
          <li><a href="manageClass.php">Manage Class</a></li>
          <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
				</ul>
			</nav>

		</aside>

		<div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">Create Class</div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="ui form segment">
                      <!-- EMAIL -->
                      <div class="form-group">
                           Class Name <input autofocus required name="name" id="name"/>
                      </div>
                      <!-- GENDER AND YEAR GROUP -->
                      <div class="form-group">
              						Year <select id="year" name="year" class="ui search dropdown"></select>
                      </div>

                      <div class="ui divider"></div>

                      <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Create Class</button>
                  </div>
              </form>
          </div>

        </div>
      </div>

       </div>
     </div>
   </div>

	</body>
</html>
