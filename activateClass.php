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
              var class_ = "";
              for (i=0;i<myRecords.className.length;i++) {
                  var myRecord = myRecords.className[i];
                  var newClass = "<option>"+myRecord.className+"</option>";
                  class_ = class_+newClass;
              }
              document.getElementById("className").innerHTML = class_;
          }
      };

      xmlhttp.open("GET", "ajax/get_classes.php", true);
      xmlhttp.send();

    </script>

    <script>
    $(function () {
        $('form').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'ajax/activate_class.php',
            data: $(this).serialize(),
						success: function(data){
              $("#div1").transition('fade down');
              document.getElementById("code").innerHTML = data;
              document.getElementById("submit_button").disabled = true;


              // Set the date we're counting down to
              var timeInMinutes = 60;
              var currentTime = Date.parse(new Date());
              var countDownDate = new Date(currentTime + timeInMinutes*60*1000);

              // Update the count down every 1 second
              var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = countDownDate - now;

                // Time calculations for days, hours, minutes and seconds
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Display the result in the element with id="demo"
                document.getElementById("minutes").innerHTML = minutes;
                document.getElementById("seconds").innerHTML = ('0' + seconds).slice(-2);;

                // If the count down is finished, write some text
                if (distance <= 0) {
                  clearInterval(x);
                  document.getElementById("countdown").innerHTML = "EXPIRED";
                }
              }, 1000);
						}
          });
        });
      });

    </script>

	</head>

	<body>
	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<h1 id="fh5co-logo">Engage Me</h1>

			<nav id="fh5co-main-menu" role="navigation">
				<ul>
					<li><a href="student.php">Home</a></li>
          <li><a href="student.php">My Account</a></li>
          <li><a href="student.php">Add New Task</a></li>
          <li><a href="student.php">View Engagement</a></li>
          <li><a href="student.php">Set Topic</a></li>
          <li class="fh5co-active"><a href="createClass.php">Create Class</a></li>
          <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
				</ul>
			</nav>

		</aside>

		<div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
            <div class="overlay"></div>
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">Activate Class Code</div>
              <form>
                  <div class="ui form segment">
                      <div class="form-group">
              						Class <select id="className" name="className" class="ui search dropdown"></select>
                      </div>

                      <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit">Activate Temporary Code</button>

                  </div>
              </form>

              <div id='div1' hidden>
                <br>
                <div class="ui horizontal divider">CLASS CODE</div>
                <p> The following code can be entered by students to join your class. If you refresh the page the code will be reset and the time limit will restart. After the timer runs out the class code will no longer be active.<p/>
                <div id='code'>
                </div>
                <div id='countdown'>
                  <span id="minutes"></span>
                  :
                  <span id="seconds"></span>
                </div>

              </div>
          </div>
        </div>
      </div>
    </li>

       </div>
     </div>

	</body>
</html>
