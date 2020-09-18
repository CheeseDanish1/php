<?php 

include_once 'dbh.inc.php';

if (isset($_POST['delete'])) {
session_start();
$conn = mysqli_connect("localhost", "root", "", "loginsystem");
$id = $_SESSION['userId'];

if (isset($_SESSION['userId'])) {
    $sql = "SELECT * FROM profileimg WHERE userid='".$id."';";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        $status= $row['status'];
        if ($status == 1) {
            unset($_SESSION['ran']);

$filename = "../ProfileImages/".$id."*";
$fileinfo = glob($filename);
$fileExt = explode(".", $fileinfo[0]);
$fileActualExt = $fileExt[3];

$file = "../ProfileImages/".$id."."."$fileActualExt";

if (!unlink($file)) {
    echo "File was not deleted";
    header("Location: ../index?delete=failed");
}

$sql = "UPDATE profileimg SET status=2 WHERE userid='$id';";
mysqli_query($conn, $sql);

unset($_SESSION['ran']);

header("Location: ../index?delete=success");
exit();
        } else {
            header("Location: ../index?delete=image");
            exit();
        }
    }
}    
} else {
    header("Location: ../index?delete=error");
}