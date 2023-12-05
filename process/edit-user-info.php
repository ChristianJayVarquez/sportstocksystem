<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $uid = $_POST['userId'];
    $name = $_POST['name'];
    $course = $_POST['course'];
    $username = $_POST['username'];

    // Check if a file is selected
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        // Additional checks for file type and size
        $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
        $max_size = 10 * 1024 * 1024; // 10 MB

        if (in_array($_FILES["profile_picture"]["type"], $allowed_types) && $_FILES["profile_picture"]["size"] <= $max_size) {
            $target_dir = "../pictures/"; // Adjust the directory path as needed
            $target_file = $target_dir . "profile" . $uid . ".jpg";

            // Check if the file already exists and delete it
            if (file_exists($target_file)) {
                unlink($target_file);
            }

            // Upload the new file
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                // File uploaded successfully
            } else {
                // Error uploading file
                $response = ["success" => false];
                header("Content-Type: application/json");
                echo json_encode($response);
                exit(); // Exit script to avoid further execution
            }
        } else {
            // Invalid file type or size
            $response = ["success" => false];
            header("Content-Type: application/json");
            echo json_encode($response);
            exit(); // Exit script to avoid further execution
        }
    }

    // Continue with updating user information
    $updateQuery = "UPDATE Users SET name=?, course=?, username=? WHERE id=?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssi", $name, $course, $username, $uid);

    if ($stmt->execute()) {
        $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Updated User', NOW())";
        mysqli_query($conn, $sqla);
        $response = ["success" => true];
    } else {
        $response = ["success" => false];
    }

    header("Content-Type: application/json");
    echo json_encode($response);
} else {
    header("HTTP/1.0 403 Forbidden");
    echo "Access Denied";
}
?>
