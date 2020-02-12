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
      function track(id,end){
        var form = $('<form action="diagram.php" method="post">' +
          '<input type="text" name="boardID" value="' + id + '" />' +
          '<input type="text" name="end" value="'+end+'" />' +
          '</form>');
        $('body').append(form);
        form.submit();
      }

      </script>

      <script>

      $(function () {
          $('#selectsubject').on('submit', function (e) {
            e.preventDefault();
            if (window.getComputedStyle(document.getElementById('div3')).display === "none") {
              $("#div3").transition('fade down');
            }
            $.ajax({
              type: 'POST',
              url: 'ajax/get_boards.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
                var boards = "";
                if (myRecords.success==1){
                  for (i=0;i<myRecords.boards.length;i++) {
                    var myRecord = myRecords.boards[i];
                    var newboard = "<div><h>"+myRecord.taskName+"</h><button disabled onclick=track(this.id,'true') id="+myRecord.boardID+" name='"+myRecord.boardID+"_end' class='right floated compact ui button delete_student'>End</button><button onclick=track(this.id,'false') id="+myRecord.boardID+" name='"+myRecord.boardID+"_start' class='right floated compact ui button delete_student'>Start</button><br>"+myRecord.date+"</div><br>";
                    boards = boards+newboard;
                  }
                  document.getElementById("boards").innerHTML = boards;

                  var subj=document.getElementById("subj").value;
                  $.ajax({
                    type: 'POST',
                    url: 'ajax/check_boards.php',
                    data: {subj:subj},
                    success: function(data){
                      var myRecords = JSON.parse(data);
                      var boards = "";
                      if (myRecords.success==1){
                        for (i=0;i<myRecords.boards.length;i++) {
                          var myRecord = myRecords.boards[i];
                          document.getElementsByName(myRecord.boardID+"_start")[0].disabled=true;
                          document.getElementsByName(myRecord.boardID+"_end")[0].disabled=false;
                        }
                     }

                    }
                  });
                  document.getElementById('submit_button').disabled=true;

               }
               else{
                 document.getElementById("boards").innerHTML = "<h>There are no lessons that need to be tracked.</h>";
               }
              }
            });
          });
        });


      </script>

      <script>
      var xmlhttp = new XMLHttpRequest();

        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var myRecords = JSON.parse(this.responseText);
                var subject = "";
                for (i=0;i<myRecords.subj.length;i++) {
                    var myRecord = myRecords.subj[i];
                    var newsubject = "<option value='"+myRecord.classID+"'>"+myRecord.department+" ("+myRecord.firstName+" "+myRecord.lastName+")</option>";
                    subject = subject+newsubject;
                }
                document.getElementById("subj").innerHTML = subject;
            }
        };
        xmlhttp.open("GET", "ajax/get_subject_teacher.php", true);
        xmlhttp.send();

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
           <li class="fh5co-active"><a href="diagram.php">Track Engagement</a></li>
           <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
 				</ul>
 			</nav>
 		</aside>

   <div id="fh5co-main">
     <div class="fh5co-narrow-content">
       <div class="row row-bottom-padded-md">

         <div class="ui raised text container segment">
           <div class="ui horizontal divider">Track Engagement</div>

           <div id='div1' class="ui form segment">
             <form id='selectsubject'>
               <div class="form-group">
                   Subject <select id="subj" name="subj" class="fluid ui search dropdown"></select>
               </div>
               <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Select Subject</button>
             </form>
           </div>


             <div id='div3' hidden>
               <div class="ui form segment">
                 <div id='boards'></div>
             </div>
           </div>

       </div>


       </div>
       <!-- </div> -->
     </div>

      </div>
    </div>

 </body>

</html>
