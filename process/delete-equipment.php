<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['eid']) && isset($_POST['action']) && $_POST['action'] === 'delete') {
        $id = $_POST['eid'];

        // Using prepared statement to prevent SQL injection
        $sql = "DELETE FROM equipment WHERE eid = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                // Code for Inserting data to Activity Log
                $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Deleted Equipment', NOW())";
                mysqli_query($conn, $sqla);
                // Respond with a success message
                echo json_encode(['status' => 'success']);
            } else {
                // Respond with an error message
                echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
            }

            mysqli_stmt_close($stmt);
        } else {
            // Respond with an error message
            echo json_encode(['status' => 'error', 'message' => 'Prepared statement error']);
        }
    } else {
        // Respond with an error message if required parameters are not provided
        echo json_encode(['status' => 'error', 'message' => 'Invalid parameters']);
    }
} else {
    // Redirect to admin.php with an error message if accessed directly
    header("Location: ../view/admin.php?toasterMessage=Error:%20Invalid%20Access");
    exit();
}
?>
