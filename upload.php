<?php 
	session_start();
	$conn = mysqli_connect("localhost", "root", "", "loginsystem"); $id =
	$_SESSION['userId'];

	if (!isset($_SESSION['userId'])) {
		header("Location: index");
	}
	?>
<!DOCTYPE html>
<html>

<head>
    <title>Upload a Profile Picture</title>
    <link rel="stylesheet" href="CSS/upload.css">
</head>

<body>
    <a href="index"><img class="arrow" src="images/arrow.svg"></a>

    <div class="container"><br>
        <h1>Upload A Profile Picture</h1><br><br>
        <?php 
	$sql = "SELECT * FROM users";
	$result = mysqli_query($conn, $sql);
	echo "<div>";
    if (mysqli_num_rows($result) > 0) {
      $sqlImg = "SELECT * FROM profileimg WHERE userid='".$id."'";
      $resultImg = mysqli_query($conn, $sqlImg); 
      $rowImg = mysqli_fetch_assoc($resultImg);
        if ($rowImg['status'] == 1) {
          $filename = "ProfileImages/profile".$id."*";
          $fileinfo = glob($filename);
          $fileExt = explode(".", $fileinfo[0]);
          $fileActualExt = $fileExt[1];
          echo "<img class='pfp' src='ProfileImages/profile".$id.".".$fileActualExt."?".mt_rand()."'>";

           echo '<div class="help-me"><form action="includes/delete.inc.php" method="post">
  <button name="delete" type="submit" class="delete">Delete Profile Image</button>
  </form></div>';
        } else {
          echo "<img class='pfp' src='images/user.png'>";
          echo "<br><br>";
           echo '<form action="includes/upload.inc.php" method="POST" enctype="multipart/form-data">
    <div class="br">
    <label for="files" class="btn"><b>Select an Image</b></label>
    </div>
      <input id="files" type="file" name="file"><br>
      <button id="submit" type="submit" name="submit">Upload Image</button>
  </form>';
        }
        echo "</div>";
			
	} ?><br />
        <?php 
	if (isset($_GET['upload'])) {
	$upload = $_GET['upload'];

	  if ($upload == "large") {
		echo "<p id='upload' class='error'>File is too large</p>";
	} elseif ($upload == "error") {
		echo "<p id='upload' class='error'>Error uploading file</p>";
	} elseif ($upload == "badfile") {
		echo "<p id='upload' class='error'>File type not supported</p>";
	} elseif ($upload == "nope") {
		echo "<p id='upload' class='error'>Nice try!</p>";
	} elseif ($upload == "image") {
		echo "<p id='upload' class='error'>You already have an image uploaded</p>";
	} elseif ($upload == "success") {
		echo "<p id='upload' class='success'>Image uploaded successfully</p>";
	}
} 
if ($rowImg['status'] == 1) {
	header("Location: index");
}
	 ?>
    </div>
</body>

</html>