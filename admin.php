
<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if(isset($_SESSION["admin"])&& $_SESSION["admin"] === false){
    header("location: student.php");
    exit;
	}
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
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

	</head>

	<body>
  <script>

  function confirm(id){
    $.ajax({
           type: 'POST',
           url: 'ajax/approve_teacher.php',
           data: {id:id},
           success: function(data){
             window.location.reload();
           }
   });
  }

	function remove(id){
    $.ajax({
           type: 'POST',
           url: 'ajax/remove_teacher.php',
           data: {id:id},
           success: function(data){
             window.location.reload();
           }
   });
  }


  var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            var teacher = "";
            for (i=0;i<myRecords.teacher.length;i++) {
                var myRecord = myRecords.teacher[i];
                var newTeacher = "<div><div style='font-weight:bold'>"+myRecord.firstName+" "+myRecord.lastName+"</div>"+myRecord.email+"<div style='float:right'><div onclick=confirm(this.id) id="+myRecord.teacherID+" class='compact green ui button'><i class='check icon'></i>Confirm</div><div onclick=remove(this.id) id="+myRecord.teacherID+" class='compact negative ui button'><i class='x icon'></i>Remove</div></div><br>"+myRecord.isHead+"<br>"+myRecord.department+"</div><br>";
                teacher = teacher+newTeacher;
            }
            document.getElementById("verify_teachers").innerHTML = teacher;
        }
    };
    xmlhttp.open("GET", "ajax/get_teacher_requests.php", true);
    xmlhttp.send();

		var xmlhttp = new XMLHttpRequest();

		    xmlhttp.onreadystatechange = function() {
		        if (this.readyState == 4 && this.status == 200) {
		            var myRecords = JSON.parse(this.responseText);
		            var teacher = "";
		            for (i=0;i<myRecords.teacher.length;i++) {
		                var myRecord = myRecords.teacher[i];
		                var newTeacher = "<div><div style='font-weight:bold'>"+myRecord.firstName+" "+myRecord.lastName+"</div>"+myRecord.email+"<div style='float:right'><div onclick=remove(this.id) id="+myRecord.teacherID+" class='compact negative ui button'><i class='x icon'></i>Remove</div></div><br>"+myRecord.isHead+"<br>"+myRecord.department+"</div><br>";
		                teacher = teacher+newTeacher;
		            }
		            document.getElementById("approved_teachers").innerHTML = teacher;
		        }
		    };
		    xmlhttp.open("GET", "ajax/get_approved_teachers.php", true);
		    xmlhttp.send();

			var xmlhttp = new XMLHttpRequest();

			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            var myRecords = JSON.parse(this.responseText);
			            var teacher = "";
			            for (i=0;i<myRecords.teacher.length;i++) {
			                var myRecord = myRecords.teacher[i];
			                var newTeacher = "<div><div style='font-weight:bold'>"+myRecord.firstName+" "+myRecord.lastName+"</div>"+myRecord.email+"<div style='float:right'><div onclick=confirm(this.id) id="+myRecord.teacherID+" class='compact green ui button'><i class='check icon'></i>Confirm</div></div><br>"+myRecord.isHead+"<br>"+myRecord.department+"</div><br>";
			                teacher = teacher+newTeacher;
			            }
			            document.getElementById("rejected_teachers").innerHTML = teacher;
			        }
			    };
			    xmlhttp.open("GET", "ajax/get_rejected_teachers.php", true);
			    xmlhttp.send();
			  </script>

  </script>

	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<h1 id="fh5co-logo">Engage Me</h1>

			<nav id="fh5co-main-menu" role="navigation">
				<ul>
					<li class="fh5co-active"><a href="student.php">Home</a></li>
          <li><a href="editAccountAdmin.php">My Account</a></li>
          <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
				</ul>
			</nav>


		</aside>

    <div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">Verify Teachers</div>
              <div class="ui form segment">
                <div id='div1'>
                  <div id='verify_teachers'>No teacher's are awaiting verification.</div>
                </div>
              </div>
              <div class="ui horizontal divider">Approved Teachers</div>
              <div class='ui form segment'>
                <div id='div2'>
                  <div id='approved_teachers'>No teacher's are verified.</div>
                </div>
              </div>
							<div class="ui horizontal divider">Rejected Teachers</div>
              <div class='ui form segment'>
                <div id='div3'>
                  <div id='rejected_teachers'>No teacher's have been rejected.</div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
  </div>
	</body>
</html>
