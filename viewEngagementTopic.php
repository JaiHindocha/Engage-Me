<?php
// Initialize the session
session_start();

// if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
//   if(isset($_SESSION["student"])&& $_SESSION["student"] === false){
//     header("location: teacher.php");
//     exit;
//   }
// }

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
              document.getElementById("yeargroup").innerHTML = year;
          }
      };
      xmlhttp.open("GET", "ajax/get_year.php", true);
      xmlhttp.send();

    </script>

    <script>

      $(function () {
          $('#selectyear').on('submit', function (e) {
            e.preventDefault();
            if (window.getComputedStyle(document.getElementById('div2')).display === "none") {
              $("#div2").transition('fade down');
            }
            $.ajax({
              type: 'POST',
              url: 'ajax/get_topic_year.php',
              data: $(this).serialize(),
              success: function(data){
                var myRecords = JSON.parse(data);
                var task = "";
                if (myRecords.success==1){
                  for (i=0;i<myRecords.task.length;i++) {
                    var myRecord = myRecords.task[i];
                    var newtask = "<option value='"+myRecord.taskID+"'>"+myRecord.taskName+"</option>";
                    task = task+newtask;
                  }
                  document.getElementById("task").innerHTML = task;
               }
               else{
                 document.getElementById("task").innerHTML = "<option disabled>There are no tasks set in this year</option>";
               }
              }
            });
          });
        });

        $(function () {
            $('#selecttask').on('submit', function (e) {
              e.preventDefault();
              if (window.getComputedStyle(document.getElementById('div3')).display === "none") {
                $("#div3").transition('fade down');
              }
              var task=document.getElementById('task').value;
              var year=document.getElementById('yeargroup').value;

              $.ajax({
                type: 'POST',
                url: 'ajax/get_task_class.php',
                data: {task:task,year:year},
                success: function(data){
                  var myRecords = JSON.parse(data);
                  var class_ = "";
                  if (myRecords.success==1){
                    for (i=0;i<myRecords.class.length;i++) {
                      var myRecord = myRecords.class[i];
                      var newclass = "<option value='"+myRecord.classID+"'>"+myRecord.className+"</option>";
                      class_ = class_+newclass;
                    }
                    document.getElementById("classlist").innerHTML = class_;
                 }
                 else{
                   document.getElementById("classlist").innerHTML = "<option disabled>There are no classes with this topic set</option>";
                 }
                }
              });
            });
          });

      $(function () {
          $('#selectclass').on('submit', function (e) {
            e.preventDefault();
            var task=document.getElementById('task').value;
            var year=document.getElementById('yeargroup').value;
            var class_=document.getElementById('classlist').value;

            $.ajax({
              type: 'POST',
              url: 'ajax/get_class_topic_engagement.php',
              data: {task:task,year:year,class_:class_},
              success: function(data){
                var image2 = new Image();
                image2.src = 'images/pin.png';
                var image3 = new Image();
                image3.src = 'images/blue_pin.png';
                var img = new Image();
                img.src = 'images/flowdiagram4.png';

                function Shape(x, y, w, h, fill,type,description) {
                  this.x = x || 0;
                  this.y = y || 0;
                  this.w = w || 1;
                  this.h = h || 1;
                  this.fill = fill || '#AAAAAA';
                  this.image = type || 'false';
                  this.description = description || '';
                }

                // Draws this shape to a given context
                Shape.prototype.draw = function(ctx) {
                  if (this.image == 'start'){
                      ctx.drawImage(image2,this.x,this.y);
                  }
                  if (this.image == 'end'){
                      ctx.drawImage(image3,this.x,this.y);
                  }
                  else{
                    ctx.fillStyle = this.fill;
                    ctx.fillRect(this.x, this.y, this.w, this.h);
                  }

                }

                // Determine if a point is inside the shape's bounds
                Shape.prototype.contains = function(mx, my) {
                  return  (this.x <= mx) && (this.x + this.w >= mx) &&
                          (this.y <= my) && (this.y + this.h >= my);
                }

                function CanvasState(canvas) {
                  // **** First some setup! ****

                  this.canvas = canvas;
                  this.width = canvas.width;
                  this.height = canvas.height;
                  this.ctx = canvas.getContext('2d');
                  // This complicates things a little but but fixes mouse co-ordinate problems
                  // when there's a border or padding. See getMouse for more detail
                  var stylePaddingLeft, stylePaddingTop, styleBorderLeft, styleBorderTop;
                  if (document.defaultView && document.defaultView.getComputedStyle) {
                    this.stylePaddingLeft = parseInt(document.defaultView.getComputedStyle(canvas, null)['paddingLeft'], 10)      || 0;
                    this.stylePaddingTop  = parseInt(document.defaultView.getComputedStyle(canvas, null)['paddingTop'], 10)       || 0;
                    this.styleBorderLeft  = parseInt(document.defaultView.getComputedStyle(canvas, null)['borderLeftWidth'], 10)  || 0;
                    this.styleBorderTop   = parseInt(document.defaultView.getComputedStyle(canvas, null)['borderTopWidth'], 10)   || 0;
                  }
                  // Some pages have fixed-position bars (like the stumbleupon bar) at the top or left of the page
                  // They will mess up mouse coordinates and this fixes that
                  var html = document.body.parentNode;
                  this.htmlTop = html.offsetTop;
                  this.htmlLeft = html.offsetLeft;

                  this.valid = false; // when set to false, the canvas will redraw everything
                  this.shapes = [];  // the collection of things to be drawn
                  // the current selected object. In the future we could turn this into an array for multiple selection
                  this.selection = null;

                  var myState = this;

                  //fixes a problem where double clicking causes text to get selected on the canvas
                  canvas.addEventListener('selectstart', function(e) { e.preventDefault(); return false; }, false);
                  // Up, down, and move are for dragging
                  canvas.addEventListener('click', function(e) {
                    var mouse = myState.getMouse(e);
                    var mx = mouse.x;
                    var my = mouse.y;
                    var shapes = myState.shapes;
                    var l = shapes.length;
                    for (var i = l-1; i >= 0; i--) {
                      if (shapes[i].contains(mx, my)) {
                        var mySel = shapes[i];

                        myState.selection = mySel;
                        myState.valid = false;
                        return;
                      }
                    }
                    // If there was an object selected, we deselect it
                    if (myState.selection) {
                      myState.selection = null;
                      myState.valid = false; // Need to clear the old selection border
                    }
                  }, true);


                  this.selectionColor = '#CC0000';
                  this.selectionWidth = 2;
                  this.interval = 30;
                  setInterval(function() { myState.draw(); }, myState.interval);
                }

                CanvasState.prototype.addShape = function(shape) {
                  this.shapes.push(shape);
                  this.valid = false;
                }

                CanvasState.prototype.clear = function() {
                  this.ctx.clearRect(0, 0, this.width, this.height);
                }

                // While draw is called as often as the INTERVAL variable demands,
                // It only ever does something if the canvas gets invalidated by our code
                CanvasState.prototype.draw = function() {
                  // if our state is invalid, redraw and validate!
                  if (!this.valid) {
                    var ctx = this.ctx;
                    var shapes = this.shapes;
                    this.clear();

                    // ** Add stuff you want drawn in the background all the time here **

                    ctx.drawImage(img,0,0);

                    // draw all shapes
                    var l = shapes.length;
                    for (var i = 0; i < l; i++) {
                      var shape = shapes[i];
                      shapes[i].draw(ctx);
                    }

                    // draw selection
                    if (this.selection != null) {
                      ctx.strokeStyle = this.selectionColor;
                      ctx.lineWidth = this.selectionWidth;
                      var mySel = this.selection;
                      ctx.strokeRect(mySel.x,mySel.y,mySel.w,mySel.h);
                    }
                    if(this.selection != null){
                      var mySel = this.selection;
                      ctx.font = "14px Helvetica";
                      ctx.fillStyle = "#000000";
                      ctx.textAlign = "start";
                      ctx.textBaseline = "bottom";
                      ctx.fillText(mySel.description, parseInt(mySel.x)+25, parseInt(mySel.y)+25);

                    }

                    this.valid = true;
                  }
                }

                CanvasState.prototype.getMouse = function(e) {
                  var element = this.canvas, offsetX = 0, offsetY = 0, mx, my;

                  // Compute the total offset
                  if (element.offsetParent !== undefined) {
                    do {
                      offsetX += element.offsetLeft;
                      offsetY += element.offsetTop;
                    } while ((element = element.offsetParent));
                  }

                  // Add padding and border style widths to offset
                  // Also add the <html> offsets in case there's a position:fixed bar
                  offsetX += this.stylePaddingLeft + this.styleBorderLeft + this.htmlLeft;
                  offsetY += this.stylePaddingTop + this.styleBorderTop + this.htmlTop;

                  mx = e.pageX - offsetX;
                  my = e.pageY - offsetY;

                  // We return a simple javascript object (a hash) with x and y defined
                  return {x: mx, y: my};
                }

                function init() {
                  if (window.getComputedStyle(document.getElementById('canvas1')).display === "none") {
                    $("#canvas1").transition('fade down');
                  }
                  var s = new CanvasState(document.getElementById('canvas1'));

                  var myRecords = JSON.parse(data);

                  if (myRecords.success==1){
                    for (i=0;i<myRecords.pin.length;i++) {
                      var myRecord = myRecords.pin[i];
                      var description = myRecord.firstName+' '+myRecord.lastName;
                      if (myRecord.pinType == 'Start'){
                        s.addShape(new Shape(parseInt(myRecord.coordinatesX),parseInt(myRecord.coordinatesY),0,0,'','start'));
                      }
                      else{
                        s.addShape(new Shape(parseInt(myRecord.coordinatesX),parseInt(myRecord.coordinatesY),0,0,'','end'));
                      }
                      s.addShape(new Shape(parseInt(myRecord.coordinatesX),parseInt(myRecord.coordinatesY),20,36,'rgba(0, 0, 0, 0)',false,description));
                    }
                 }

                 }

                       init();

                }
              });
            });
          });

</script>

<body>

  <body>

  <div id="fh5co-page">
   <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
   <aside id="fh5co-aside" role="complementary" class="border js-fullheight">

     <h1 id="fh5co-logo">Engage Me</h1>

     <nav id="fh5co-main-menu" role="navigation">
       <ul>
         <li><a href='teacher.php'>Home</a></li>
         <li><a href='editAccount.php'>My Account</a></li>
         <li><a href='addNewTask.php'>Add New Task</a></li>
         <li class='fh5co-active'><a href='viewEngagement.php'>View Engagement</a></li>
         <li><a href='setTask.php'>Set Topic</a></li>
         <li><a href='createClass.php'>Create Class</a></li>
         <li><a href='manageClass.php'>Manage Class</a></li>
         <li><a href='logout.php' class='btn btn-danger'>Log Out</a></li>
       </ul>
     </nav>
   </aside>

  <div id="fh5co-main">
    <div class="fh5co-narrow-content">
      <div class="row row-bottom-padded-md">
        <div class="ui raised text container segment">
          <div class="ui horizontal divider">View Engagement</div>

            <div class="fluid three ui buttons">
              <button name='topic' id='topic' class="medium ui button"><a href='viewEngagementTopic.php'>Topic<a></button>
              <button name='class' id='class' class="grey medium ui button"><a href='viewEngagementClass.php'>Class</a></button>
              <button name='student' id='student' class="grey medium ui button"><a href='viewEngagementStudent.php'>Student</a></button>
            </div>

            <div id='div1' class="ui form segment">
              <form id='selectyear'>
                <div class="form-group">
                    Year <select id="yeargroup" name="yeargroup" class="fluid ui search dropdown"></select>
                </div>
                <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Select Year</button>
              </form>
            </div>

           <div id='div2' class="ui form segment" hidden>
             <form id='selecttask'>
               <div class="form-group">
                 Topic <select id="task" name="task" class="fluid ui search dropdown"></select>
               </div>
               <button class="ui fluid primary submit button" name="submit_button2" id="submit_button2" type="submit">Select Topic</button>
             </form>
           </div>

           <div id='div3' class="ui form segment" hidden>
             <form id='selectclass'>
               <div class="form-group">
                 Class <select id="classlist" name="classlist" class="fluid ui search dropdown"></select>
               </div>
               <button class="ui fluid primary submit button" name="submit_button3" id="submit_button3" type="submit">Select Student</button>
             </form>
           </div>

           <canvas id = "canvas1" width="700" height="600" hidden></canvas>
           <style>
           canvas {
                padding: 0;
                margin: auto;
                display: block;
                width: 700px;
            }
          </style>

     </div>
   </div>
 </div>


</body>

</html>
