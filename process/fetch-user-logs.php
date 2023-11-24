<?php
include 'connection.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["userId"])) {
    $userId = $_GET["userId"];
    $itemsPerPage = 4;

    // Validate $userId to prevent SQL injection
    // You may use prepared statements or other validation methods

    $sql = "SELECT * FROM log WHERE user_id='$userId' ORDER BY timestamp DESC";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $logs = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Return the logs as JSON
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "logs" => $logs]);
    } else {
        // Query execution failed
        echo json_encode(["success" => false, "message" => "Failed to fetch user logs"]);
    }
} else {
    // Invalid request
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
