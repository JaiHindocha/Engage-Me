<?php
// Initialize the session
session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if(isset($_SESSION["student"])&& $_SESSION["student"] === false){
    header("location: teacher.php");
    exit;
}
}

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// require_once __DIR__ . '/db_connect.php';
// $db = new DB_CONNECT();
//
// $mousePosX = $_POST["mousePos.x"];
// $mousePosY = $_POST["mousePos.y"];
//
// $id = $_SESSION["id"];
//
// $sql = "INSERT INTO boardPin (studentID, pinType, coordinatesX, coordinatesY, boardID) VALUES ('$id', '$type', '$mousePosX', '$mousePosY', '$boardID')";
// $result = $db->get_con()->query($sql);

?>

<!DOCTYPE HTML>
<html>
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
         window.onload=function drawShape() {

            // get the canvas element using the DOM
            var canvas = document.getElementById('mycanvas');

               // use getContext to use the canvas for drawing
               var ctx = canvas.getContext('2d');
               // Draw shapes
               var img = new Image();
               img.src = 'images/flowdiagram.png';

               img.onload = function() {
                  ctx.drawImage(img,-12,-12);
                  canvas.addEventListener("click", function (evt) {
                      var mousePos = getMousePos(canvas, evt);
                      var mousePosX = mousePos.x;
                      var mousePosY = mousePos.y;
                      document.getElementById("submit_button").disabled = false;

                      $('form').on('submit', function (e) {
                        e.preventDefault();
                        $.ajax({
                          type: 'POST',
                          url: 'ajax/addCoord.php',
                          data: {mousePosX:mousePosX, mousePosY:mousePosY},
              						success: function(data){
              							alert("success");
              						}
                        });
                      });

                  }, false);

                  //Get Mouse Position
                  function getMousePos(canvas, evt) {
                      var rect = canvas.getBoundingClientRect();
                      return {
                          x: evt.clientX - rect.left,
                          y: evt.clientY - rect.top,
                      };
                  }
               }
         }
      </script>

      <script>

      $(document).ready(function() {
        $("#start").click(function() {
          $("#div1").transition('fade right');
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
           <li><a href="student.php">View Engagement</a></li>
           <li><a href="student.php">Join Class</a></li>
           <li class="fh5co-active"><a href="student.php">Track Engagement</a></li>
           <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
 				</ul>
 			</nav>
 		</aside>

   <div id="fh5co-main">
     <div class="fh5co-narrow-content">
       <div class="row row-bottom-padded-md">
         <div class="ui two column very relaxed grid">

         <div class='column'>
           <button name='start' id='start' class="ui primary button"> Start of Lesson </button>
         </div>

         <div class='column'>
         <div id='div1' class="ui raised text container segment">
           <div class="ui horizontal divider">Track Engagement</div>
           <div class="ui form segment">
             <form id='form1'>
               <div class="form-group" align='centre'>
                 <canvas id = "mycanvas" width="460" height="460"></canvas>
               </div>
               <div class="form-group">
                 <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit" disabled>Submit</button>
               </div>
              </form>
         </div>
       </div>
     </div>
       </div>
      </div>
    </div>
  </div>
</div>


 </body>

</html>
