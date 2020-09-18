<?php

if (isset($_POST['submit-login'])) {

  include_once 'dbh.inc.php';

  $mailuid = mysqli_real_escape_string($conn, $_POST['uid-login']);
  $password = strtolower(mysqli_real_escape_string($conn, $_POST['pwd-login']));

    if (empty($mailuid) || empty($password)) {
      header("Location: ../login?login=empty");
      exit();
    }
    else {
      $sql = "SELECT * FROM users WHERE user_uid=?";
      $stmt = mysqli_stmt_init($conn);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login?login=sqlerror");
        exit();
      }
      else {

        mysqli_stmt_bind_param($stmt, "s", $mailuid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($result)) {
          $pwdCheck = password_verify($password, $row['user_pwd']);
          if ($pwdCheck == false) {
            header("Location: ../login?login=wrongpwd");
            exit();
          }
          else {

           session_start();
           $_SESSION['userId'] = $row['user_id'];
           $_SESSION['userUid'] = $row['user_uid'];
           $_SESSION['userFirst'] = $row['user_first'];
           $_SESSION['userLast'] = $row['user_last'];
           $_SESSION['userEmail'] = $row['user_email'];
           $_SESSION['pwd'] = $row['user_pwd'];
           $_SESSION['userName'] = ucfirst($row['user_first']). " ". ucfirst($row['user_last']);

           header("Location: ../index?login=success");
           exit();
          }
        }
        else {
          header("Location: ../login?login=nousr");
          exit();
        }
      }
    }
  }
  else {
    header("Location: ../login?login=error");
    exit();
  }
