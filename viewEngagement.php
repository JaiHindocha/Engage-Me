<?php
// Initialize the session
session_start();

// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//   if(isset($_SESSION["student"])&& $_SESSION["student"] === false){
//     header("location: teacher.php");
//     exit;
// }
// }

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

      </script>

      <script>
         window.onload=function drawShape() {
            // get the canvas element using the DOM
              var canvas = document.getElementById('mycanvas');
              // var canvas2 = document.getElementById('mycanvas2');

               // use getContext to use the canvas for drawing
               var ctx = canvas.getContext('2d');
               // var ctx2 = canvas2.getContext('2d');

               // Draw shapes
               var img = new Image();
               img.src = 'images/flowdiagram.png';
               var image2 = new Image();
               image2.src = 'images/pin.png';


               img.onload = function() {
                 var mousePosX = "";
                 var mousePosY = "";

                  ctx.drawImage(img,0,0);
                  // ctx2.drawImage(img,0,0);

                  // canvas.addEventListener("click", function (evt) {
                  //     document.getElementById("submit_button").disabled = false;
                  //
                  //     var mousePosPin = getMousePosPin(canvas, evt);
                  //     var mousePosPinX = mousePosPin.x;
                  //     var mousePosPinY = mousePosPin.y;
                  //
                  //     ctx.drawImage(img,0,0);
                  //     ctx.drawImage(image2, mousePosPinX-10, mousePosPinY-36);
                  //
                  //     var mousePos = getMousePos(canvas, evt);
                  //     mousePosX = mousePos.x;
                  //     mousePosY = mousePos.y;
                  //     return mousePosX,mousePosY;
                  //
                  //   }, false);
                  //
                  //     $('#form1').on('submit', function (e) {
                  //       e.preventDefault();
                  //       $.ajax({
                  //         type: 'POST',
                  //         url: 'ajax/addCoord.php',
                  //         data: {mousePosX:mousePosX, mousePosY:mousePosY},
              		// 				success: function(data){
                  //           $("#div1").transition('fade down');
                  //           document.getElementById("start").disabled = true;
                  //           document.getElementById("end").disabled = false;
              		// 				}
                  //       });
                  //     });
                  //
                  // canvas2.addEventListener("click", function (evt) {
                  //     document.getElementById("submit_button2").disabled = false;
                  //
                  //     var mousePosPin = getMousePosPin2(canvas, evt);
                  //     var mousePosPinX = mousePosPin.x;
                  //     var mousePosPinY = mousePosPin.y;
                  //
                  //     ctx2.drawImage(img,0,0);
                  //     ctx2.drawImage(image2, mousePosPinX-10, mousePosPinY-36);
                  //
                  //     var mousePos = getMousePos2(canvas, evt);
                  //     mousePosX = mousePos.x;
                  //     mousePosY = mousePos.y;
                  //     return mousePosX,mousePosY;
                  //   }, false);
                  //
                  //     $('#form2').on('submit', function (e) {
                  //       e.preventDefault();
                  //       $.ajax({
                  //         type: 'POST',
                  //         url: 'ajax/addCoordEnd.php',
                  //         data: {mousePosX:mousePosX, mousePosY:mousePosY},
              		// 				success: function(data){
                  //           document.getElementById("end").disabled = true;
                  //           $("#div2").transition('fade down');
                  //           window.location.replace("student.php");
              		// 				}
                  //       });
                  //     });
                  //
                  // //Get Mouse Position
                  // function getMousePos(canvas, evt) {
                  //     var rect = canvas.getBoundingClientRect();
                  //     return {
                  //         x: evt.clientX - rect.left,
                  //         y: rect.bottom - evt.clientY,
                  //     };
                  // }
                  //
                  // function getMousePosPin(canvas, evt) {
                  //     var rect = canvas.getBoundingClientRect();
                  //     return {
                  //         x: evt.clientX - rect.left,
                  //         y: evt.clientY - rect.top,
                  //     };
                  // }
                  //
                  // function getMousePos2(canvas, evt) {
                  //     var rect = canvas2.getBoundingClientRect();
                  //     return {
                  //         x: evt.clientX - rect.left,
                  //         y: rect.bottom - evt.clientY,
                  //     };
                  // }
                  //
                  // function getMousePosPin2(canvas, evt) {
                  //     var rect = canvas2.getBoundingClientRect();
                  //     return {
                  //         x: evt.clientX - rect.left,
                  //         y: evt.clientY - rect.top,
                  //     };
                  // }
               }
         }
      </script>

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


      $(function () {
          $('#selectyear').on('submit', function (e) {
            e.preventDefault();
            if (window.getComputedStyle(document.getElementById('div2')).display === "none") {
              $("#div2").transition('fade down');
            }
            $.ajax({
              type: 'POST',
              url: 'ajax/get_class_year.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
                var class_ = "";
                if (myRecords.success==1){
                  for (i=0;i<myRecords.className.length;i++) {
                    var myRecord = myRecords.className[i];
                    var newclass = "<option>"+myRecord.className+"</option>";
                    class_ = class_+newclass;
                  }
                  document.getElementById("class_").innerHTML = class_;
               }
               else{
                 document.getElementById("class_").innerHTML = "<h>There are no students in this class</h>";
               }
              }
            });
          });
        });

        $(function () {
            $('#selectclass').on('submit', function (e) {
              e.preventDefault();
              if (window.getComputedStyle(document.getElementById('div3')).display === "none") {
                $("#div3").transition('fade down');
              }
              $.ajax({
                type: 'POST',
                url: 'ajax/get_student.php',
                data: $(this).serialize(),
                success: function(data){
                  var myRecords = JSON.parse(data);
                  var class_ = "";
                  if (myRecords.success==1){
                    for (i=0;i<myRecords.className.length;i++) {
                      var myRecord = myRecords.className[i];
                      var newclass = "<option>"+myRecord.className+"</option>";
                      class_ = class_+newclass;
                    }
                    document.getElementById("class_").innerHTML = class_;
                 }
                 else{
                   document.getElementById("class_").innerHTML = "<h>There are no students in this class</h>";
                 }
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
 					 <li><a href="teacher.php">Home</a></li>
           <li><a href="teacher.php">My Account</a></li>
           <li class="fh5co-active"><a href="teacher.php">View Engagement</a></li>
           <li><a href="joinClass.php">Join Class</a></li>
           <li><a href="diagram.php">Track Engagement</a></li>
           <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
 				</ul>
 			</nav>
 		</aside>

   <div id="fh5co-main">
     <div class="fh5co-narrow-content">
       <div class="row row-bottom-padded-md">
         <div class="ui raised text container segment">
           <div class="ui horizontal divider">View Engagement</div>

             <div class="fluid three ui buttons">
               <button name='topic' id='topic' class="grey medium ui button">Topic</button>
               <button name='class' id='class' class="grey medium ui button">Class</button>
               <button name='student' id='student' class="grey medium ui button">Student</button>
             </div>

             <div id='div1' class="ui form segment">
               <form id='selectyear'>
                 <div class="form-group">
                     Year <select id="year" name="year" class="fluid ui search dropdown"></select>
                 </div>
                 <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Select Year</button>
               </form>
             </div>

            <div id='div2' class="ui form segment" hidden>
              <form id='selectclass'>
                <div class="form-group">
                  Class <select id="class_" name="class_" class="fluid ui search dropdown"></select>
                </div>
                <button class="ui fluid primary submit button" name="submit_button2" id="submit_button2" type="submit">Select Class</button>
              </form>
            </div>

            <div id='div3' class="ui form segment" hidden>
              <form id='selectstudent'>
                <div class="form-group">
                  Student <select id="student" name="student" class="fluid ui search dropdown"></select>
                </div>
                <button class="ui fluid primary submit button" name="submit_button3" id="submit_button3" type="submit">Select Student</button>
              </form>
            </div>

            <div id='div4' class="ui form segment" hidden>
              <form id='selecttask'>
                <div class="form-group">
                  Task <select id="task" name="task" class="fluid ui search dropdown"></select>
                </div>
                <button class="ui fluid primary submit button" name="submit_button4" id="submit_button4" type="submit">Select Task</button>
              </form>
            </div>

                 <!-- <div class="center form-group" align='center'>
                   <canvas id = "mycanvas" width="460" height="460"></canvas>
                 </div>
                 <div class="form-group">
                   <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit" disabled>Submit</button>
                 </div>
                </form> -->

      </div>
    </div>
  </div>


</body>

</html>
