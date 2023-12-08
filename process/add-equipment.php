<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];
if (isset($_POST['add'])) {
    $ename = $_POST['eName'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity']; 
    $condition = $_POST['condition'];
    $maintenance = $_POST['maintenance'];

    // Insert the data into your equipment table
    $insertSql = "INSERT INTO equipment (ename, category, quantity, quality, last_maintenance_date) VALUES ('$ename', '$category', '$quantity', '$condition', '$maintenance')";
    
    // Execute the SQL query
    if (mysqli_query($conn, $insertSql)) {
        // Get the ID of the inserted equipment
        $equipmentId = mysqli_insert_id($conn);

        // Set the target directory
        $targetDir = "../pictures/";
        $targetFile = $targetDir . 'equipment' . $equipmentId . '.jpg';

        // Check file extension
        $originalExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif'); // Add more if needed

        if (in_array(strtolower($originalExtension), $allowedExtensions)) {
            // Convert image to JPG using GD library
            if ($originalExtension == 'jpg' || $originalExtension == 'jpeg') {
                copy($_FILES['file']['tmp_name'], $targetFile);
            } else {
                $image = imagecreatefromstring(file_get_contents($_FILES['file']['tmp_name']));
                imagejpeg($image, $targetFile, 85);
                imagedestroy($image);
            }

             // Code for Inserting data to Activity Log
            $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Added Equipment', NOW())";
            mysqli_query($conn, $sqla);
            // Show toaster notification after successful insert
            $toasterMessage = "Equipment added successfully!";
            header("Location: ../view/admin.php?toasterMessage=$toasterMessage");
            exit();
        } else {
            // Show error toaster notification if the file has an unsupported extension
            $toasterMessage = "Error: Unsupported file extension.";
            header("Location: ../view/admin.php?toasterMessage=$toasterMessage");
            exit();
        }
    } else {
        // Show error toaster notification after an error
        $toasterMessage = "Error: " . mysqli_error($conn);
        header("Location: ../view/admin.php?toasterMessage=$toasterMessage");
        exit();
    }
} else {
    mysqli_close($conn);
}
?>
