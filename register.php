
<!DOCTYPE html>

<head>
  <!--Sematic-->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.14/semantic.min.css" integrity="sha256-FpjP45Pz019159CFCReBCsZtVeCvGawN2Om1w+SIi0A="
    crossorigin="anonymous" />

</head>

<body>

<div class="ui raised text container segment">
    <div class="ui horizontal divider">Student Signup</div>
    <form method='POST'>
        <div class="ui form segment">
            <input type='hidden' name='csrfmiddlewaretoken' value='Gy4ZzOxEKRFlNBCzVMAKNkFQKWFHrkgPk6pftFGl4dKHXyXPze93bZCrDj0HY4EN' />
            <!-- EMAIL -->
            <div class="required field">
                School Email <input type="email" name="email" autofocus placeholder="example@example.com" required id="id_email" />
            </div>
            <!-- FIRST AND LAST NAME -->
            <div class="two fields">
                <div class="field">
                    First name <input type="text" name="first_name" maxlength="30" placeholder="First Name" id="id_first_name" />
                </div>
                <div class="field">
                    Last name <input type="text" name="last_name" maxlength="30" placeholder="Last Name" id="id_last_name" />
                </div>
            </div>
            <!-- PASSWORD -->
            <div class="two fields">
                <div class="field">
                    Password <input type="password" name="password1" placeholder="Password" required id="id_password1" />
                </div>
                <div class="field">
                    Password confirmation <input type="password" name="password2" placeholder="Password" required id="id_password2" />
                </div>
            </div>
            <div class="ui divider"></div>

            <button class="ui primary submit button" name="submit_button" id="submit_button" type="submit">Sign up</button>
        </div>
    </form>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.14/semantic.js" integrity="sha256-tOBb/zwykDTtxBetaVNjEQdtFiGje+ggf849N3dpNJY="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>



</body>

</html>
