<?php
  include_once 'includes/dbh.inc.php';
  session_start();

  if (isset($_SESSION['userId'])) {
    header("Location: index");
  }

 ?>

<!DOCTYPE html>
<html>
<head>
  <title>Log In</title>
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script defer>
    let viewLogin = false;

      function changeType(input, button) {

        let getPwdView = $(`#${input}`);
        let btn = $(`#${button}`);

        if (viewLogin == false) 
        {

          getPwdView.attr("type", "text");
          viewLogin = true;
          btn.text("Hide Password");

        } else if (viewLogin === true) 
        {

          getPwdView.attr("type", "password");
          viewLogin = false;
          btn.text("Show Password");

        }
      }
  </script>
  <link rel="stylesheet" href="CSS/login.css">
</head>

<body>
<a href="index"><img class="img" src="images/arrow.svg" alt="backarow"></a>
<div class="container">
  <h1>Log In</h1>
  <form action="includes/login.inc.php" method="POST">
    <br>
    <input type="text" name="uid-login" placeholder="User Name">
    <br><br>
    <input type="password" id="pwd" name="pwd-login" placeholder="Password">
    <p id="btn" class="noselect" onclick="changeType('pwd', 'btn')">Show Password</p>  
    <button type="submit" id="sub" name="submit-login">Submit</button>
  </form>
</div>
<?php
if (!isset($_GET['login'])) {
  exit();
} else {
  $error = $_GET['login'];
  if ($error == "error") {
    echo "<p class='warning' id='error'>Please fill out form</p>";
    exit();
  } else if ($error == "nousr") {
    echo "<p class='warning' id='error'>User not found</p>";
    exit();
  } else if ($error == "wrongpwd") {
    echo "<p class='warning' id='error'>Incorrect Password</p>";
    exit();
  } else if ($error == "empty") {
    echo "<p class='warning' id='error'>Please fill out all fields</p>";
    exit();
  } else if ($error == "sqlerror") {
    echo "<p class='warning' id='error'>SQL ERROR: Failed to connect</p>";
    exit();
  } else if ($error == "success") {
    echo "<p class='warning' id='success'>Log in successful</p><br>";
    exit();
  }
}
    ?>
</body>
</html>