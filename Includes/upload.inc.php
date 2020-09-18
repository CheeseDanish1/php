<?php 

include_once 'dbh.inc.php';

session_start();
$id = $_SESSION['userId'];

if (isset($_SESSION['userId'])) {
    $sql = "SELECT * FROM profileimg WHERE userid='".$id."';";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
    	$status= $row['status'];
    	if ($status == 2) {
    		if (isset($_POST['submit'])) {
		$file = $_FILES['file'];

		$fileName = $file['name'];
		$fileType = $file['type'];
		$fileTmpName = $file['tmp_name'];
		$fileError = $file['error'];
		$fileSize = $file['size'];

		$fileExt = explode('.', $fileName);
		$fileActualExt = strtolower(end($fileExt));

		$allow = array('png', 'jpeg', 'jpg', 'gif');

		if (in_array($fileActualExt, $allow)) {
			if ($fileError === 0) {
				if ($fileSize < 5000000) {
					$fileNameNew = $id . "." . $fileActualExt;

					$fileDestination = '../ProfileImages/'. $fileNameNew;
		move_uploaded_file($fileTmpName, $fileDestination);
             $sql = "UPDATE profileimg SET status=1 WHERE userid ='$id';";
              $result = mysqli_query($conn, $sql);
               header("Location: ../upload?upload=success");
                } else {
                   header("Location: ../upload?upload=large");
                   exit();
                       }
                    } else {
                        header("Location: ../upload?upload=error");
                        exit();
                    }
                } else {
                    header("Location: ../upload?upload=badfile");
                    exit();
                }
            } else {
                header("Location: ../upload?upload=nope");
                exit();
            }
        } else {
            header("Location: ../upload?upload=image");
            exit();
        }
    }
    
}

         