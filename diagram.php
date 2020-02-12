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

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

if(isset($_POST['boardID'])){
  $boardID = $_POST['boardID'];
  $end = $_POST['end'];
}


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
               img.src = 'images/flowdiagram2.png';
               var image2 = new Image();
               image2.src = 'images/pin.png';


               img.onload = function() {
                 var mousePosX = "";
                 var mousePosY = "";

                  ctx.drawImage(img,0,0);

                  canvas.addEventListener("click", function (evt) {
                      document.getElementById("diagram-submit").disabled = false;

                      var mousePos = getMousePosPin(canvas, evt);
                      var mousePosX = mousePos.x;
                      var mousePosY = mousePos.y;

                      ctx.drawImage(img,0,0);
                      ctx.drawImage(image2, mousePosX-10, mousePosY-36);

                      document.getElementById('mousePosX').value = mousePosX;
                      document.getElementById('mousePosY').value = mousePosY;

                      return mousePosX,mousePosY;

                    }, false);

                  //Get Mouse Position

                  function getMousePosPin(canvas, evt) {
                      var rect = canvas.getBoundingClientRect();
                      return {
                          x: evt.clientX - rect.left,
                          y: evt.clientY - rect.top,
                      };
                  }

                  $(function () {
                      $('#form1').on('submit', function (e) {
                        if(document.getElementById('end').value == 'true'){
                          $.ajax({
                            type: 'POST',
                            url: 'ajax/addCoordEnd.php',
                            data: $(this).serialize(),
                            success: function(data){
                              window.location.replace('trackEngagement.php');
                            }
                          });
                        }
                        else{
                          $.ajax({
                            type: 'POST',
                            url: 'ajax/addCoord.php',
                            data: $(this).serialize(),
                            success: function(data){
                              window.location.replace('trackEngagement.php');

                            }
                          });
                        }
                      });
                    });

               }
         }
      </script>

   <body>

   <div id="fh5co-page">
 		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
 		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

 			<h1 id="fh5co-logo">Engage Me</h1>

 			<nav id="fh5co-main-menu" role="navigation">
 				<ul>
 					 <li><a href="student.php">Home</a></li>
           <li><a href="editAccount.php">My Account</a></li>
           <li><a href="student.php">View Engagement</a></li>
           <li><a href="joinClass.php">Join Class</a></li>
           <li class="fh5co-active"><a href="trackEngagement.php">Track Engagement</a></li>
           <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
 				</ul>
 			</nav>
 		</aside>

   <div id="fh5co-main">
     <div class="fh5co-narrow-content">
       <div class="row row-bottom-padded-md">

         <div class="ui raised text container segment">
           <div class="ui horizontal divider">Track Engagement</div>

           <div id='div1' class="ui form segment" >
              <form id='form1'>
                <div class="center form-group" align='center'>
                 <canvas id = "mycanvas" width="600" height="600"></canvas>
                 <input value='' hidden id='mousePosX' name='mousePosX'></input>
                 <input value='' hidden id='mousePosY' name='mousePosY'></input>
                 <input value="<?php echo $boardID; ?>" hidden id='boardID' name='boardID'></input>
                 <input value="<?php echo $end; ?>" hidden id='end' name='end'></input>


                 <style>
                 canvas {
                      padding: 0;
                      margin: auto;
                      display: block;
                      width: 600px;
                  }
                </style>
               </div>
               <div class="form-group">
                 <button class="ui primary submit button" name="diagram-submit" id="diagram-submit" type="submit" disabled>Submit</button>
               </div>
              </form>
            </div>


       </div>
       <!-- </div> -->
     </div>

      </div>
    </div>
  </div>


 </body>

</html>
