<?php
include 'connection.php';
session_start();
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the user ID from the session
    $uid = $_SESSION['id'];

    $sql = "SELECT user_id FROM users WHERE id='$uid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];

    // Retrieve form data
    $eid = $_POST["eid"];
    $quantityToBorrow = $_POST["quantity-to-borrow"];
    $returnDate = $_POST["date"];
    $status = 'Borrowing';

    $sqls = "SELECT quantity FROM equipment WHERE eid='$eid'";
    $results = mysqli_query($conn, $sqls);
    $row = mysqli_fetch_assoc($results);
    $quantity = $row['quantity'];
    $newQuantity = ($quantity - $quantityToBorrow);
    //Update the quantity on the equipment table
    $updateQuery = "UPDATE equipment SET quantity='$newQuantity' WHERE eid='$eid'";
    $resulta = mysqli_query($conn, $updateQuery);

    // Insert the user information in the database to the borrowing table
    $insertQuery = "INSERT INTO borrowing (equipment_id, user_id, quantity, status, borrow_date, return_date, date_returned) VALUES ('$eid', '$user_id', '$quantityToBorrow', '$status', CURRENT_DATE(), '$returnDate', NULL)";
    
    if (mysqli_query($conn, $insertQuery)) {
        // Code for Inserting data to Activity Log
        $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$uid', 'Borrowed Equipment', NOW())";
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
    // Handle non-POST requests or other errors
    http_response_code(400); // Bad Request
    echo "Invalid request.";
}
?>
