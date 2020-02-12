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
    if(isset($_SESSION["admin"])&& $_SESSION["admin"] !== true){
      header("location: teacher.php");
      exit;
  }
 }
}


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}

// require_once "config.php";
require_once __DIR__ . '/db_connect.php';
$db = new DB_CONNECT();

$id = $_SESSION['id'];

$sql = "SELECT adminID,username,password FROM admin WHERE adminID = '$id'";
$result = $db->get_con()->query($sql);

$query_arr = mysqli_fetch_assoc($result);
$adminID = $query_arr['adminID'];
$username = $query_arr['username'];
$hashed_password = $query_arr['password'];

$old_password_err = $password_err = $confirm_password_err = $oldpassword = $newpassword = $confirm = '';


if($_SERVER["REQUEST_METHOD"] == "POST"){

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
      $sql = "UPDATE admin SET password = '$param_password' WHERE adminID = '$id'";
      $result = $db->get_con()->query($sql);

      header("location:admin.php");
    }
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Edit Account</title>

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

	<body>

    <script>
        $(function () {
            $('#updateusername').on('submit', function (e) {
              e.preventDefault();
              $.ajax({
                type: 'POST',
                url: 'ajax/update_username.php',
                data: $(this).serialize(),
    						success: function(data){
                  window.location.replace('admin.php');
    						}
              });
            });
          });

    </script>


	<div id="fh5co-page">
		<a href="#" class="js-fh5co-nav-toggle fh5co-nav-toggle"><i></i></a>
		<aside id="fh5co-aside" role="complementary" class="border js-fullheight">

			<h1 id="fh5co-logo">Engage Me</h1>

			<nav id="fh5co-main-menu" role="navigation">
				<ul id='links'>
          <li><a href='admin.php'>Home</a></li>
          <li class='fh5co-active'><a href='editAccountAdmin.php'>My Account</a></li>
          <li><a href="logout.php" class="btn btn-danger">Log Out</a></li>
				</ul>
			</nav>

		</aside>

		<div id="fh5co-main">
      <div class="fh5co-narrow-content">
        <div class="row row-bottom-padded-md">
          <div class="ui raised text container segment">
            <div class="ui horizontal divider">Account Details</div>

            <form id='updateusername'>
              <div class="ui form segment">
                <div class="form-group">
                  Username: <input value='<?php echo $username; ?>' name='username' id='username'></input>
                </div>
                <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Update Username</button>
              </div>
            </form>

            <div class='ui horizontal divider'>OR</div>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <div class="ui form segment">
                  <div class='form-group <?php echo (!empty($old_password_err)) ? 'has-error' : ''; ?>'>
                    Old Password:
                    <input required type='password' name='oldpass' id='oldpass' value="<?php echo $oldpassword; ?>"></input>
                    <span class="help-block"><?php echo $old_password_err; ?></span>
                  </div>

                  <div class='form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>'>
                    New Password:
                    <input required type='password' name='newpass' id='newpass' value="<?php echo $newpassword; ?>"></input>
                    <span class="help-block"><?php echo $password_err; ?></span>
                  </div>

                  <div class='form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>'>
                    Confirm New Password:
                    <input required type='password' name='confirm' id='confirm' value="<?php echo $confirm; ?>"></input>
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
