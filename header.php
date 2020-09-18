<?php  
	session_start();
	require 'includes/dbh.inc.php';
	if (isset($_SESSION['userId'])) {
    $id = $_SESSION['userId'];
  }
  $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($actual_link, "header")) {
    include_once 'error-pages/404.html';
    //header("Location: index");
  } else {
    ?>
<nav>
    <?php 
	if (isset($_SESSION['userUid'])) {
      echo '<form action="includes/logout.inc.php" method="POST">';
      echo '<button class="out" type="submit" name="logout">Log Out</button>';
      echo '</form>';
    } else {
      echo '<button class="sign" type="button" name="button"><a href="signup">Sign Up</a></button>
  <button class="log" type="button" name="button">
    <a href="login">Log In</a>
  </button>';
    }

    if (isset($_SESSION['userId'])) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
      $sqlImg = "SELECT * FROM profileimg WHERE userid='".$id."'";
      $resultImg = mysqli_query($conn, $sqlImg); 
      $rowImg = mysqli_fetch_assoc($resultImg);
        echo "  <div class='idk'>";
        if ($rowImg['status'] == 1) {
          $filename = "ProfileImages/".$id."*";
          $fileinfo = glob($filename);
          $fileExt = explode(".", $fileinfo[0]);
          $fileActualExt = $fileExt[1];
          echo "  <img class='pfp' src='ProfileImages/".$id.".".$fileActualExt."?". mt_rand()."'>";
          echo "<h3>". $_SESSION['userName']. "</h3>";
          echo '<form action="includes/delete.inc.php" method="post">
        <button name="delete" type="submit" class="upload">Delete Profile Image</button>
      </form>';
        } else {
          echo '<button class="upload" type="button"><a href="upload">Upload A Profile Picture</a></button>';
          echo "<img class='pfp' src='images/user.png'>"; 
          echo "<h3>". $_SESSION['userName']. "</h3>";
        }
    }
        echo "</div>";
  }
 ?>
</nav>
<?php
  }
?>