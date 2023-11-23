<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data from the POST request
    $uid = $_POST['userId']; // Corrected field name
    $name = $_POST['name'];
    $course = $_POST['course'];
    $username = $_POST['username'];

    // Update the user information in the database
    $updateQuery = "UPDATE Users SET name=?, course=?, username=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $name, $course, $username, $uid);

    if ($stmt->execute()) {
        // Code for Inserting data to Activity Log
        $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Updated User', NOW())";
        mysqli_query($conn, $sqla);
        // Database update was successful
        $response = ["success" => true];
    } else {
        // Database update failed
        $response = ["success" => false];
    }

    // Return the response in JSON format
    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    // Handle non-POST requests or direct script access
    header("HTTP/1.0 403 Forbidden");
    echo "Access Denied";
}
?>