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
  if(isset($_SESSION["student"])&& $_SESSION["student"] !== true){
    header("location: teacher.php");
    exit;
  }
  if(isset($_SESSION["admin"])&& $_SESSION["admin"] === true){
    header("location: teacher.php");
    exit;
  }
}

// Include config file
require_once "config.php";
// require_once __DIR__ . '/db_connect.php';
// $db = new DB_CONNECT();
// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";
$login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $sql = "SELECT studentID, email, password FROM student WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            // Set parameters
            $param_email = $email;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                // Check if email exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $studentID, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["email"] = $email;
                            $_SESSION["student"] = true;
                            $_SESSION["head"] = false;
                            $_SESSION["id"] = $studentID;
                            $_SESSION["admin"] = false;

                            // Redirect user to welcome page
                            header("location: student.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                }

                else{

                  $sql = "SELECT teacherID,email, password, isHead,active,adminVerified FROM teacher WHERE email = ?";
                      if($stmt = mysqli_prepare($link, $sql)){
                          // Bind variables to the prepared statement as parameters
                          mysqli_stmt_bind_param($stmt, "s", $param_email);
                          // Set parameters
                          $param_email = $email;
                          // Attempt to execute the prepared statement
                          if(mysqli_stmt_execute($stmt)){
                              // Store result
                              mysqli_stmt_store_result($stmt);
                              // Check if email exists, if yes then verify password
                              if(mysqli_stmt_num_rows($stmt) == 1){
                                  // Bind result variables
                                  mysqli_stmt_bind_result($stmt, $teacherID, $email, $hashed_password, $isHead,$active,$adminVerified);
                                  if(mysqli_stmt_fetch($stmt)){
                                      if(password_verify($password, $hashed_password)){
                                          // Password is correct, so start a new session
                                          if($active == 1){
                                            if($adminVerified == 1){

                                            session_start();
                                            // Store data in session variables
                                            $_SESSION["loggedin"] = true;
                                            $_SESSION["email"] = $email;
                                            $_SESSION["student"] = false;
                                            $_SESSION["id"] = $teacherID;
                                            $_SESSION["admin"] = false;


                                            if($isHead == 1){
                                              $_SESSION["head"] = true;
                                              header("location: headteacher.php");
                                            }
                                            else{
                                              $_SESSION["head"] = false;
                                              header("location: teacher.php");
                                            }
                                          }
                                          else{
                                            $login_err = "This account has not been verified by the school admin yet";
                                          }
                                        }else{
                                          $login_err = "This account has been rejected by the school admin";
                                        }

                                          // Redirect user to welcome page
                                      }
                                      else{
                                          // Display an error message if password is not valid
                                          $password_err = "The password you entered was not valid.";
                                      }
                                  }
                              }

                    // Display an error message if email doesn't exist
                    // $email_err = "No account found with that email.";

                else{

                  $sql = "SELECT adminID,username, password FROM admin WHERE username = ?";
                      if($stmt = mysqli_prepare($link, $sql)){
                          // Bind variables to the prepared statement as parameters
                          mysqli_stmt_bind_param($stmt, "s", $param_username);
                          // Set parameters
                          $param_username = $email;
                          // Attempt to execute the prepared statement
                          if(mysqli_stmt_execute($stmt)){
                              // Store result
                              mysqli_stmt_store_result($stmt);
                              // Check if email exists, if yes then verify password
                              if(mysqli_stmt_num_rows($stmt) == 1){
                                  // Bind result variables
                                  mysqli_stmt_bind_result($stmt, $adminID, $username, $hashed_password);
                                  if(mysqli_stmt_fetch($stmt)){
                                      if(password_verify($password, $hashed_password)){
                                          // Password is correct, so start a new session
                                          session_start();
                                          // Store data in session variables
                                          $_SESSION["loggedin"] = true;
                                          $_SESSION["email"] = $username;
                                          $_SESSION["student"] = false;
                                          $_SESSION["id"] = $adminID;
                                          $_SESSION["admin"] = true;

                                          header("location: admin.php");


                                          // Redirect user to welcome page
                                      }
                                      else{
                                          // Display an error message if password is not valid
                                          $password_err = "The password you entered was not valid.";
                                      }
                                  }
                              }

                    // Display an error message if email doesn't exist
                    // $email_err = "No account found with that email.";
                }
                else{
                  $email_err = "The email/username or password you entered is incorrect";
                }
                }
              }
            }
          }
        }
      }
    }
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Student Sign Up</title>

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
            <div class="ui horizontal divider">Login</div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="ui form segment">
                    <!-- EMAIL -->
                    <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                      School Email / Username
                      <br>
                      <div class="ui fluid left icon input">
                        <input type="text" name="email" autofocus placeholder="example@dubaicollege.org" required id="email" value="<?php echo $email; ?>"/>
                        <i class="user icon"></i>
                      </div>
                      <div class="help-block"><?php echo $email_err; ?></div>
                    </div>
                    <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                        Password
                        <div style="float:right">
                          <a href='resetPassword.php'>Forgot Password</a>
                        </div>
                        <br>
                        <div class="ui fluid left icon input">
                          <input type="password" name="password" placeholder="Password" required id="password" value="<?php echo $password; ?>"/>
                          <i class="lock icon"></i>
                        </div>
                        <div class="help-block"><?php echo $password_err; ?></div>


                    </div>
                    <br>
                    <button class="ui fluid primary submit button" name="submit_button" id="submit_button" type="submit">Login</button>
                    <br>
                    <div class="form-group <?php echo (!empty($login_err)) ? 'has-error' : ''; ?>">
                      <div class="help-block"><?php echo $login_err; ?></div>
                    <br>
            <div class="ui horizontal divider">New to Engage Me?</div>
            <br>
            <div class='two fields'>
              <div class='field'>
                <div class="fluid ui button" onclick="location.href = 'studentregister.php';">
                  <i class="signup icon"></i>
                  Student Sign Up
                </div>
              </div>
              <div class='field'>
                <div class="fluid ui button" onclick="location.href = 'teachersignup.php';">
                  <i class="signup icon"></i>
                  Teacher Sign Up
                </div>
              </div>
            </div>

          </div>

        </form>

      </div>
    </div>
  </div>
</div>

</body>
</html>
