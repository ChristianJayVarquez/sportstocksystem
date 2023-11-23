<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    // Get data from the form
    $ename = $_POST['eName'];
    $category = $_POST['category'];
    $quantity = $_POST['quantity'];
    $condition = $_POST['condition'];
    $maintenance = $_POST['maintenance'];

    // Get the equipment ID
    $eid = $_POST['eid'];

    // Create the SQL query to update the equipment
    $sql = "UPDATE equipment SET ename=?, category=?, quantity=?, quality=?, last_maintenance_date=? WHERE eid=?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssisss", $ename, $category, $quantity, $condition, $maintenance, $eid);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Code for Inserting data to Activity Log
            $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Updated Equipment', NOW())";
            mysqli_query($conn, $sqla);
            // Respond with a success message
            echo json_encode(['status' => 'success']);
        } else {
            // Respond with an error message
            echo json_encode(['status' => 'error', 'message' => mysqli_stmt_error($stmt)]);
        }

        mysqli_stmt_close($stmt);
    } else {
        // Respond with an error message
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
