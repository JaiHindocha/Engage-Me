
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
      $(function () {
          $("#check").submit(function(e){
            e.preventDefault();
            $.ajax({
              type: 'POST',
              url: 'ajax/check_class.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
  							var className = myRecords.className;
                var code = myRecords.code;
                var valid = myRecords.valid;
                var inClass = myRecords.inClass;
                var dateValid = myRecords.dateValid;

                if (valid == 0){
                  document.getElementById("error").innerHTML = "The code you entered is invalid";
                }
                else{
                  if (inClass == 1){
                    document.getElementById("error").innerHTML = "You are already in that class";
                  }
                  else{
                    if (dateValid == 0){
                      document.getElementById("error").innerHTML = "The code is expired";
                    }
                    else{
                      $("#div1").transition('fade down');
                      document.getElementById("submit_button").disabled = true;
                      document.getElementById("error").hidden = true;
                      document.getElementById("class").innerHTML = className;
                      document.getElementById("inpcode").value = code;

                      $(function () {
                          $("#submitform").submit(function(e){
                            e.preventDefault();
                            $.ajax({
                              type: 'POST',
                              url: 'ajax/join_class.php',
                              data: $(this).serialize(),
                              success: function(data){
                                window.location.replace("student.php");
                              }
                            });
                          });
                        });
                      }
                  }
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
 					 <li><a href="student.php">Home</a></li>
           <li><a href="editAccount.php">My Account</a></li>
           <li><a href="student.php">View Engagement</a></li>
           <li class="fh5co-active"><a href="joinClass.php">Join Class</a></li>
           <li><a href="diagram.php">Track Engagement</a></li>
           <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
 				</ul>
 			</nav>
 		</aside>

    <div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">Join Class</div>
              <form id='check'>
                  <div class="ui form segment">
                      <!-- CODE -->
                      <div class="form-group">
                           Class Code <input autofocus required name="code" id="code"/>
                           <span id="error"></span>

                      </div>

                      <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit">Submit</button>
                  </div>
              </form>

              <div id='div1' hidden>
              <div class="ui horizontal divider">Confirm Class</div>
              <p>Are you sure you want to join the class below?</p>
                <p id="class"></p>
                <form id=submitform>
                  <input hidden name='inpcode' id='inpcode'></input>
                  <button class="ui primary submit button" name="confirm" id="confirm" type="submit">Confirm</button>
                </form>
           </div>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>


 </body>

</html>
