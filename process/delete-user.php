<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];

    $sql = "DELETE FROM users WHERE id=$uid";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Code for Inserting data to Activity Log
        $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Deleted User', NOW())";
        mysqli_query($conn, $sqla);
        $response = array("status" => "success", "message" => "User Account Deleted Successfully.");
        echo json_encode($response);
    } else {
        $response = array("status" => "error", "message" => "Error deleting user account: " . mysqli_error($conn));
        echo json_encode($response);
    }
} else {
    // Handle invalid requests
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
?>
