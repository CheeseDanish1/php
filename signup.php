<?php
include_once 'includes/dbh.inc.php';
session_start();

if (isset($_SESSION['userId']))
{
    header("Location: index");
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/signup.css">
    <title>Sign Up</title>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script defer>
    let viewLogin = false

    function changeTwoTypes(input12, input22, button2) {

        let input1 = $(`#${input12}`);
        let input2 = $(`#${input22}`);
        let btn = $(`#${button2}`);

        if (viewLogin == false) {

            input1.attr("type", "text");
            input2.attr("type", "text");
            viewLogin = true;
            btn.text("Hide Passwords");

        } else if (viewLogin === true) {

            input1.attr("type", "password");
            input2.attr("type", "password");
            viewLogin = false;
            btn.text("Show Passwords");

        }
    }
    </script>
</head>

<body>
    <a href="index"><img class="img" src="images/arrow.svg" alt="backarow"></a>
    <div class="container">
        <h1>Sign up</h1>
        <form action="includes/signup.inc.php" method="POST">
            <?php
if (isset($_GET['first']))
{
    $first = $_GET['first'];
    echo "<input type='text' name='first' placeholder='First name' value='$first'>";
}
else
{
    echo '<input type="text" name="first" placeholder="First name">';
}
echo "<br>";
if (isset($_GET['last']))
{
    $last = $_GET['last'];
    echo "<input type='text' name='last' placeholder='Last name' value='$last'>";
}
else
{
    echo '<input type="text" name="last" placeholder="Last name">';
}
?>
            <br>
            <input type="text" name="email" placeholder="E-mail"><br>
            <?php
if (isset($_GET['uid']))
{
    $uid = $_GET['uid'];
    echo "<input type='text' name='uid' placeholder='User name' value='$uid'>";
}
else
{
    echo '<input type="text" name="uid" placeholder="User name">';
}
?>
            <br>
            <input type="password" id="pwd1" name="pwd" placeholder="Password"><br>
            <input type="password" id="pwd2" name="pwdcon" placeholder="Confirm Password"><br>
            <p id="changePwdType" class="noselect" onclick="changeTwoTypes('pwd1', 'pwd2', 'changePwdType')">Show
                Passwords</p>
            <button type="submit" name="submit"><b>Submit</b></button>
        </form>
    </div>
    <?php
if (!isset($_GET['signup']))
{
    exit();
}
else
{
    $error = $_GET['signup'];
    if ($error == "error")
    {
        echo "<p class='warning' id='error'>Please fill out form</p>";
        exit();
    }
    else if ($error == "email")
    {
        echo "<p class='warning' id='error'>Your email is invalid</p>";
        exit();
    }
    else if ($error == "char")
    {
        echo "<p class='warning' id='error'>Invalid characters detected</p>";
        exit();
    }
    else if ($error == "empty")
    {
        echo "<p class='warning' id='error'>Fill out all fields</p>";
        exit();
    }
    else if ($error == "success")
    {
        echo "<p class='warning' id='success'>Sign in successful</p><br>";
        exit();
    }
    else if ($error == "uidtaken")
    {
        echo '<p class="warning" id="error">User name already taken</p>';
        exit();
    }
    else if ($error == "pwdcon")
    {
        echo "<p class='warning' id='error'> Passwords don't match up</p>";
        exit();
    }
    else if ($error == "emailtaken")
    {
        echo "<p class='warning' id='error'> Email is already in use</p>";
        exit();
    }
}
?>

</body>

</html>