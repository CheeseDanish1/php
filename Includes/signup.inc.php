<?php
if (isset($_POST['submit'])) {
  include_once 'dbh.inc.php';

  $first = mysqli_real_escape_string($conn, $_POST['first']);
  $last = mysqli_real_escape_string($conn, $_POST['last']);
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $pwd = strtolower(mysqli_real_escape_string($conn, $_POST['pwd']));
  $pwdCon = strtolower(mysqli_real_escape_string($conn, $_POST['pwdcon']));
  $key = generateKey($conn);


  $sql = "SELECT user_email FROM users WHERE user_email=?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("Location: ../signup?signup=sqlerror");
    exit();
  } else {
     mysqli_stmt_bind_param($stmt, "s", $email);
     mysqli_stmt_execute($stmt);
     mysqli_stmt_store_result($stmt);
     $resultCheck = mysqli_stmt_num_rows($stmt);
     if ($resultCheck > 0) {
       header("Location: ../signup?signup=emailtaken&first=$first&last=$last");
       exit();
     }
    }

  if ($pwd !=  $pwdCon) {
    header("Location: ../signup?signup=pwdcon&first=$first&last=$last&uid=$uid");
    exit();
  }
  else {
    if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd) || empty($pwdCon)) {
      header("Location: ../signup?signup=empty");
      exit();
    } else {
      if (
      !preg_match(
        "/^[a-zA-Z\.'\-%\\\\]*$/", $first) || 
        !preg_match("/^[a-zA-Z\.'\-%\\\\]*$/", $last) || 
        !preg_match("/^[\w \-_%\\\\]*$/", $uid)
      ) {
        header("Location: ../signup?signup=char");
        exit();
      } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          header("Location: ../signup?signup=email&first=$first&last=$last&uid=$uid");
          exit();
        } else {
          $sql = "SELECT user_uid FROM users WHERE user_uid=?";
          $stmt = mysqli_stmt_init($conn);
          if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup?signup=sqlerror");
            exit();
          } else {
             mysqli_stmt_bind_param($stmt, "s", $uid);
             mysqli_stmt_execute($stmt);
             mysqli_stmt_store_result($stmt);
             $resultCheck = mysqli_stmt_num_rows($stmt);
             if ($resultCheck > 0) {
               header("Location: ../signup?signup=uidtaken&first=$first&last=$last");
               exit();
             }
             else {
              if (strpos($first, '\\') != false) {
                $idk = explode('\\', $first);
                $first = implode('', $idk);
              }
              if (strpos($last, '\\') != false) {
                $idk = explode('\\', $last);
                $last = implode('', $idk);
              }
              if (strpos($uid, '\\') != false) {
                $idk = explode('\\', $first);
                $uid = implode('', $uid);
              }
              
               $sql = "INSERT INTO users (user_id, user_first, user_last, user_email, user_uid, user_pwd)
               VALUES (?, ?, ?, ?, ?, ?);";
               $stmt = mysqli_stmt_init($conn);

               if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../signup?signup=sqlerror");
                exit();
               } else {
                 $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

                mysqli_stmt_bind_param($stmt, "ssssss", $key ,$first, $last, $email, $uid, $hashedPwd);
                mysqli_stmt_execute($stmt);

                $sql = "SELECT * FROM users WHERE user_uid='$uid'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    $userid = $row['user_id'];
                    $sql = "INSERT INTO profileimg (userid, status) VALUES ('$userid', 2);";
                    mysqli_query($conn, $sql);
                    session_start();

           $_SESSION['userId'] = $row['user_id'];
           $_SESSION['userUid'] = $row['user_uid'];
           $_SESSION['userFirst'] = nameize($row['user_first']);
           $_SESSION['userLast'] = nameize($row['user_last']);
           $_SESSION['userEmail'] = $row['user_email'];
           $_SESSION['pwd'] = $hashedPwd;
           $_SESSION['userName'] = nameize($row['user_first']. " ". $row['user_last']);

               header("Location: ../index?signup=success");
                exit();
                  }
                } else {
                  header("Location: ../signup");
                }
               }
             }
          }

          }
        }
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
  }

 }
 else {
  header("Location: ../signup?signup=error");
}

function nameize($str,$a_char = array("'","-"," ",".")){   
    //$str contains the complete raw name string
    //$a_char is an array containing the characters we use as separators for capitalization. If you don't pass anything, there are three in there as default.
    $string = strtolower($str);
    foreach ($a_char as $temp){
        $pos = strpos($string,$temp);
        if ($pos){
            //we are in the loop because we found one of the special characters in the array, so lets split it up into chunks and capitalize each one.
            $mend = '';
            $a_split = explode($temp,$string);
            foreach ($a_split as $temp2){
                //capitalize each portion of the string which was separated at a special character
                $mend .= ucfirst($temp2).$temp;
                }
            $string = substr($mend,0,-1);
            }   
        }
    return ucfirst($string);
    }

function checkKeys($conn, $randStr) {
  $sql = "SELECT  * FROM users";
  $result = mysqli_query($conn, $sql);
  $keyExists = false;
  while ($row = mysqli_fetch_assoc($result)) {
    if ($row['user_id'] == $randStr) {
      $keyExists = true;
    break;
    } else {
      $keyExists = false;
    }
  }

  return $keyExists;
}

function generateKey($conn) {
  $keylen = "12";
  $str = "1234567890abcdefghijklmnopqrstuvwxyz$-_";
  $randStr = substr(str_shuffle($str), 0, $keylen);

  $checkKeys = checkKeys($conn, $randStr);

  while ($checkKeys == true) {
    $randStr = substr(str_shuffle($str), 0, $keylen);
    $checkKeys = checkKeys($conn, $randStr);
  }

  return $randStr;
}