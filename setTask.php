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

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if(isset($_SESSION["student"])&& $_SESSION["student"] !== true){
    if(isset($_SESSION["head"]) && $_SESSION["head"] === true){
    header("location: setTaskHead.php");
    exit;
  }
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
    <link href="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.rawgit.com/mdehoog/Semantic-UI/6e6d051d47b598ebab05857545f242caf2b4b48c/dist/semantic.min.js"></script>
		<!-- CODE WRITTEN BY TEMPLATE CREATOR -->
		<link rel="stylesheet" href="css/animate.css">
		<link rel="stylesheet" href="css/icomoon.css">
		<link rel="stylesheet" href="css/flexslider.css">
		<link rel="stylesheet" href="css/style.css">
		<script src="js/modernizr-2.6.2.min.js"></script>

    <script>

      function foo(id){
        $.ajax({
               type: 'POST',
               url: 'ajax/delete_task.php',
               data: {id:id},
               success: function(data){
                 window.location.reload();
               }
       });
     };

     function remove(id){
       $.ajax({
              type: 'POST',
              url: 'ajax/delete_task_set.php',
              data: {id:id},
              success: function(data){
                window.location.reload();
              }
      });
    };

    $(function () {
        $('#taskform').on('submit', function (e) {
          e.preventDefault();
          $.ajax({
            type: 'POST',
            url: 'ajax/set_task.php',
            data: $(this).serialize(),
						success: function(data){
						}
          });
        });
      });

      $(function () {
          $('#yearform').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
              type: 'POST',
              url: 'ajax/get_teacher_task.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
                var task = "";
                for (i=0;i<myRecords.task.length;i++) {
                    var myRecord = myRecords.task[i];
                    var newTask = "<div><h>"+myRecord.taskName+"</h>"+"<div id="+myRecord.taskID+"_div class='item' style='float:right'><button onclick=foo(this.id) id="+myRecord.taskID+" class='compact negative ui button delete_student'>Remove</button></div></div><br>";
                    task = task +newTask;
                }
                document.getElementById("teacher_task").innerHTML = task;
              }
            });

            $.ajax({
              type: 'POST',
              url: 'ajax/get_task.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
                var task2 = "";
                for (i=0;i<myRecords.task.length;i++) {
                    var myRecord = myRecords.task[i];
                    var newTask = "<div><h><font color='green'>"+myRecord.taskName+"</font></h>"+"<div id="+myRecord.taskID+"_div class='item' style='float:right'></div></div><br>";
                    task2 = task2+newTask;
                }
                document.getElementById("head_task").innerHTML = task2;
              }
            });

            $.ajax({
              type: 'POST',
              url: 'ajax/get_all_tasks.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
                var task3 = "";
                for (i=0;i<myRecords.task.length;i++) {
                    var myRecord = myRecords.task[i];
                    var newTask = "<option>"+myRecord.taskName+"</option>";
                    task3 = task3+newTask;
                }
                document.getElementById("tasks").innerHTML = task3;
              }
            });

            var year = document.getElementById("year").value

            $.ajax({
              type: 'POST',
              url: 'ajax/get_class_year.php',
              data: {year:year},
              success: function(data){
                var myRecords = JSON.parse(data);
                var class_ = "";
                for (i=0;i<myRecords.className.length;i++) {
                    var myRecord = myRecords.className[i];
                    var newClass = "<option>"+myRecord.className+"</option>";
                    class_ = class_+newClass;
                }
                document.getElementById("class_").innerHTML = class_;
              }
            });

            $.ajax({
              type: 'POST',
              url: 'ajax/get_task_set.php',
              data: {year:year},
              success: function(data){
                var myRecords = JSON.parse(data);
                var task = "";
                for (i=0;i<myRecords.taskSet.length;i++) {
                    var myRecord = myRecords.taskSet[i];
                    var newTask = "<div><h>"+myRecord.className+"</h>"+"<br>"+myRecord.taskName+"<div id="+myRecord.taskClassID+"_div class='item' style='float:right'><button onclick=remove(this.id) id="+myRecord.taskClassID+" class='compact negative ui button delete_student'>Remove</button></div><br>"+myRecord.date+"</div><br>";
                    task = task +newTask;
                }
                document.getElementById("teach").innerHTML = task;
              }
            });

            $("#tasklist").transition('fade up');

          });
        });

        $(function () {
            $('#set').on('submit', function (e) {
              var date = document.getElementById('dateinp').value;
              var class_ = document.getElementById('class_').value;
              var task = document.getElementById('tasks').value;

              e.preventDefault();
              $.ajax({
                type: 'POST',
                url: 'ajax/assign_task.php',
                data: {date:date, class_:class_, task:task},
                success: function(data){
                  window.location.reload();
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
          <li class="fh5co-active"><a href="setTask.php">Set Topic</a></li>
          <li><a href="createClass.php">Create Class</a></li>
          <li><a href="manageClass.php">Manage Class</a></li>
          <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
				</ul>
			</nav>

		</aside>

		<div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">View Tasks</div>
            <form id='yearform'>
                  <div class="form-group">
                      Year <select id="year" name="year" class="fluid ui search dropdown"></select>
                  </div>
                  <button class="ui fluid primary submit button" name="submit_button2" id="submit_button2" type="submit">Search Tasks</button>
            </form>
            <div id='tasklist' hidden>
              <br>
              Green tasks are tasks created by the head of the department, that all teachers in the department can access.
                <div class="ui form segment">
                  <div id='div1'>
                    <div id='teacher_task'></div>
                    <div class="ui divider"></div>
                    <div id='head_task'></div>
                  </div>
                </div>

              <div id='div2'>
                <div class="ui horizontal divider">Assign Task</div>
                <form id='set'>
                  <div class="ui form segment">

                    <div class="three fields">

                      <div class='field'>
                        Tasks <select id="tasks" name="tasks" class="ui search dropdown"></select>
                      </div>

                      <div class='field'>
                        Class <select id="class_" name="class_" class="ui search dropdown"></select>
                      </div>

                      <div class='field'>
                          Date
                          <div class="ui calendar" id="cal">
                            <div class="ui input left icon">
                              <i class="calendar icon"></i>
                              <input id='dateinp' type="date" placeholder="Date">
                            </div>
                          </div>
                      </div>

                  </div>
                  <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Add Task</button>

                  </div>
                </form>
                </div>

                <div id='div3'>
                  <div class="ui horizontal divider">De-Assign Task</div>
                  <div class="ui form segment">
                    <div id='div1'>
                      <div id='teach'></div>
                    </div>
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
