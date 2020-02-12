<?php
// Initialize the session
session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  if(isset($_SESSION["student"])&& $_SESSION["student"] !== true){
    if(isset($_SESSION["admin"])&& $_SESSION["admin"] !== true){
      header("location: editAccountTeacher.php");
      exit;
    }
    else{
      header("location: editAccountAdmin.php");
      exit;
    }
  }
}


require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

$id = $_SESSION['id'];

$sql = "SELECT studentID,firstName,lastName,password,gender,active,emailVerified,student.yearID,year FROM student,year WHERE studentID = '$id' AND year.yearID = (SELECT yearID FROM student WHERE studentID = '$id')";
$result = $db->get_con()->query($sql);

$query_arr = mysqli_fetch_assoc($result);

$studentID = $query_arr['studentID'];
$firstName = $query_arr['firstName'];
$lastName = $query_arr['lastName'];
$hashed_password = $query_arr['password'];
$gender = $query_arr['gender'];
$active = $query_arr['active'];
$emailVerified = $query_arr['emailVerified'];
$yearID = $query_arr['yearID'];
$year = $query_arr['year'];

if($emailVerified == 0){
  $emailVerified = 'No';
}
else{
  $emailVerified = 'Yes';
}


$old_password_err = $password_err = $confirm_password_err = $oldpassword = $newpassword = $confirm = '';


    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $id = $_SESSION['id'];
        $old_password_err = $password_err = $confirm_password_err = $oldpassword = $newpassword = $confirm = '';

        $oldpassword = $_POST["oldpass"];
        $newpassword = $_POST['newpass'];
        $confirm = $_POST['confirm'];

        if(!(password_verify($oldpassword, $hashed_password))){
          $old_password_err = "Old password is incorrect.";
        }

        if(empty($old_password_err) && strlen($newpassword) < 6){
          $password_err = 'Password not long enough.';
        }

        if(empty($old_password_err) && strlen($newpassword) >= 6 && ($newpassword != $confirm)){
          $confirm_password_err = "Password did not match.";
        }

        if(empty($old_password_err) && empty($password_err) && empty($confirm_password_err)){
          $param_password = password_hash($newpassword, PASSWORD_DEFAULT);
          $sql = "UPDATE student SET password = '$param_password' WHERE studentID = '$id'";
          $result = $db->get_con()->query($sql);

          header("location:student.php");
        }
    }

?>

<!DOCTYPE html>
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

	</head>

  <script>
  var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var myRecords = JSON.parse(this.responseText);
            var year = "<option value='<?php echo $year; ?>' disabled selected><?php echo $year; ?></option>";
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
            $('#updateinfo').on('submit', function (e) {
              e.preventDefault();

              $.ajax({
                type: 'POST',
                url: 'ajax/update_student_account.php',
                data: $(this).serialize(),
                success: function(data){
                  window.location.reload();
                }
              });
            });
          });

  </script>

	<body>
	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<h1 id="fh5co-logo">Engage Me</h1>

			<nav id="fh5co-main-menu" role="navigation">
				<ul id='links'>
          <li><a href='student.php'>Home</a></li>
          <li class='fh5co-active'><a href='editAccount.php'>My Account</a></li>
          <li><a href='student.php'>View Engagement</a></li>
          <li><a href='joinClass.php'>Join Class</a></li>
          <li><a href='diagram.php'>Track Engagement</a></li>
          <li><a href='logout.php' class='btn btn-danger'>Log Out</a></li>
				</ul>
			</nav>

		</aside>

		<div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">Account Details</div>
            <form id='updateinfo'>
              <div class="ui form segment">

              <div class="form-group">
                First Name: <input value='<?php echo $firstName; ?>' name='fname' id='fname'></input>
              </div>
              <div class="form-group">
                Last Name: <input value='<?php echo $lastName; ?>' name='lname' id='lname'></input>
              </div>
              <div class='two fields'>
              <div class="field">
                  Gender <select class="ui search dropdown" name="gender" placeholder="Gender" id="gender">
                            <option value='<?php echo $gender; ?>' disabled selected><?php echo $gender; ?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                          </select>
              </div>
              <div class="field">
                Year <select value='<?php echo $year; ?>' id="year" name="year" class="ui search dropdown">
                </select>
              </div>
            </div>
              <div class="form-group">
                Email Verified: <input value='<?php echo $emailVerified; ?>' disabled id='email'></input>
              </div>
            </div>
          <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit">Update Information</button>
        </form>

        <div class="ui horizontal divider">Change Password</div>
          <form id='changepasswordform' action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="ui form segment">
              <div class='form-group <?php echo (!empty($old_password_err)) ? 'has-error' : ''; ?>'>
                Old Password:
                <div class="ui fluid left icon input">
                  <input required type='password' name='oldpass' id='oldpass' value="<?php echo $oldpassword; ?>"></input>
                  <i class="lock icon"></i>
                </div>
                <span class="help-block"><?php echo $old_password_err; ?></span>
              </div>

              <div class='form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>'>
                New Password:
                <div class="ui fluid left icon input">
                  <input required type='password' name='newpass' id='newpass' value="<?php echo $newpassword; ?>"></input>
                  <i class="lock icon"></i>
                </div>
                <span class="help-block"><?php echo $password_err; ?></span>
              </div>

              <div class='form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>'>
                Confirm New Password:
                <div class="ui fluid left icon input">
                  <input required type='password' name='confirm' id='confirm' value="<?php echo $confirm; ?>"></input>
                  <i class="lock icon"></i>
                </div>
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
              </div>

            <button class="ui fluid primary submit button" name="submit_button2" id="submit_button2">Change Password</button>
          </div>
          </form>
          </div>
            </div>
          </div>
        </div>
      </div>
	</body>
</html>
