<?php
// Include config file
// require_once "config.php";

require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

// Define variables and initialize with empty values
$email = $password = $confirm_password = "";
$email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"]);
    $sql = ("SELECT teacherID FROM teacher WHERE email = '$email'");
    $result = $db->get_con()->query($sql);

    if ($result->num_rows < 1) {
      $sql = ("SELECT studentID FROM student WHERE email = '$email'");
      $result = $db->get_con()->query($sql);
      if ($result->num_rows < 1) {
        $email = trim($_POST["email"]);
      }
    } else{
      $email_err = "This email is already taken.";
    }

    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);


    if(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must be at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
      $confirm_password_err = "Password did not match.";
    }

    $gender = trim($_POST["gender"]);

    $department = trim($_POST["department"]);
    $sql = "SELECT departmentID FROM department WHERE department = '$department'";
    $result = $db->get_con()->query($sql);

    $row=mysqli_fetch_array($result,MYSQLI_NUM);
    $departmentID = $row[0];

    if (isset($_POST['isHead'])){
      $isHead = 1;
    }
    else{
      $isHead = 0;
    }

    if(empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        $param_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO teacher (email, firstName, lastName, password, gender, active, emailVerified, adminVerified, isHead, departmentID) VALUES ('$email', '$firstname', '$lastname', '$param_password', '$gender', 1, 0, 0, '$isHead', '$departmentID')";
        $result = $db->get_con()->query($sql);
    }

    header("location: login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
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

    <script>
    var xmlhttp = new XMLHttpRequest();

      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              var myRecords = JSON.parse(this.responseText);
              var deps = "";
              for (i=0;i<myRecords.deps.length;i++) {
                  var myRecord = myRecords.deps[i];
                  var newDep = "<option>"+myRecord.department+"</option>";
                  deps = deps+newDep;
              }
              document.getElementById("department").innerHTML = deps;
          }
      };

      xmlhttp.open("GET", "ajax/get_department.php", true);
      xmlhttp.send();

    </script>

    <body>
      <div id="fh5co-page">
        <a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
        <aside id="fh5co-aside" role="complementary" class="border js-fullheight">

          <h1 id="fh5co-logo">Engage Me

    				<div align="centre">
      				<div class="ui buttons">
      					<button onclick=tab() class="medium ui button">Sign Up</button>
      					<div class="or"></div>
      					<button class="medium ui blue button" onclick="location.href = 'login.php';">Login</button>
      				</div>
    			  </div>

            <div id="signupselect" hidden>
              <div class="ui pointing label">
                <div class="ui buttons">
                  <a href='studentregister.php'>
                    <button class="ui primary button">Student</button>
                  </a>
                  <div class="or"></div>
                  <a href='teachersignup.php'>
                    <button class="ui primary button">Teacher</button>
                  </a>
                </div>
              </div>
            </div>

            <script>
            function tab(){
              if (window.getComputedStyle(document.getElementById('signupselect')).display === "none") {
                $('#signupselect').transition('fade down');
              }else{
                $('#signupselect').transition('fade up');
              }
            }

            </script>

    			</h1>

          <nav id="fh5co-main-menu" role="navigation">
            <ul>
              <li><a href="index.php">Home</a></li>
            </ul>
          </nav>
      </div>

    <div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
              <div class="ui horizontal divider">Teacher Sign Up</div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <div class="ui form segment">
                      <!-- EMAIL -->
                      <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                          School Email <input type="email" name="email" autofocus placeholder="example@dubaicollege.org" required id="email" pattern=".+@dubaicollege.org" value="<?php echo $email; ?>"/>
                          <span class="help-block"><?php echo $email_err; ?></span>
                      </div>
                      <!-- FIRST AND LAST NAME -->
                      <div class="two fields">
                          <div class="field">
                              First name <input type="text" name="firstname" maxlength="30" placeholder="First Name" id="firstname" required/>
                          </div>
                          <div class="field">
                              Last name <input type="text" name="lastname" maxlength="30" placeholder="Last Name" id="lastname" required/>
                          </div>
                      </div>
                      <!-- GENDER AND YEAR GROUP -->
                      <div class="two fields">
                          <div class="field">
                              Gender <select class="ui search dropdown" name="gender" placeholder="Gender" id="gender">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                      </select>
                          </div>

                          <div class="field">
              							Department <select id="department" name="department" class="ui search dropdown">
              							</select>
                          </div>
                      </div>

                      <!-- PASSWORD -->
                      <div class="two fields">
                          <div class="field  <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                              Password <input type="password" name="password" placeholder="Password" required id="password" value="<?php echo $password; ?>"/>
                              <span class="help-block"><?php echo $password_err; ?></span>
                          </div>
                          <div class="field  <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                              Password confirmation <input type="password" name="confirm_password" placeholder="Password" required id="confirm_password" value="<?php echo $confirm_password; ?>" />
                              <span class="help-block"><?php echo $confirm_password_err; ?></span>
                          </div>
                      </div>

                      <div class="ui checkbox">
                        <input type="checkbox" value='on' name="isHead" id='isHead'>
                        <label>Head of Department</label>
                      </div>

                      <div class="ui divider"></div>

                      <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit">Sign up</button>
                  </div>
              </form>
            </div>
          </div>
        </div>

    </body>
</html>
