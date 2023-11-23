<?php
include 'connection.php'; // Include your database connection script

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["userId"]) && isset($_GET["page"])) {
    $userId = $_GET["userId"];
    $page = $_GET["page"];
    $itemsPerPage = 4;

    // Validate $userId and $page to prevent SQL injection
    // You may use prepared statements or other validation methods

    $startIndex = ($page - 1) * $itemsPerPage;

    $sql = "SELECT * FROM log WHERE user_id='$userId' ORDER BY timestamp DESC LIMIT $startIndex, $itemsPerPage";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $logs = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Return the logs and total pages as JSON
        header("Content-Type: application/json");
        echo json_encode(["success" => true, "logs" => $logs, "totalPages" => ceil(mysqli_num_rows($result) / $itemsPerPage)]);
    } else {
        // Query execution failed
        echo json_encode(["success" => false, "message" => "Failed to fetch user logs"]);
    }
} else {
    // Invalid request
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
