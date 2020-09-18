<?php 
   if (isset($_SESSION['userId'])) {
      $sqlImg = "SELECT * FROM profileimg WHERE userid='".$id."'";
      $resultImg = mysqli_query($conn, $sqlImg); 
      $rowImg = mysqli_fetch_assoc($resultImg);
      $_SESSION['status'] = $rowImg['status'];
   }
 ?>
<!DOCTYPE html>
<html>

<style>
.info {
    position: absolute;
    left: 50%;
    top: 15%;
    transform: translate(-50%, -15%);
    font-size: 50px;
    width: 900px;
    text-align: center;
    background-color: white;
    //margin-top: 155px;
}
</style>

<head>
    <link rel="stylesheet" href="CSS/header.css">
    <link rel="stylesheet" href="CSS/footer.css">
    <title>Home Page</title>
</head>

<body>
    <?php
  include 'header.php'
  ?>

    <?php
    if (isset($_SESSION['userId'])) {
      echo "<p class='info'>You are logged in</p>";
   } else {
      echo "<p class='info'>You are logged out</p>";
    }
    ?>

</body>

<?php
      include_once 'footer.php';
    ?>

</html>