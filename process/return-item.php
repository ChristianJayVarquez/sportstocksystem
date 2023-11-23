<?php
include 'connection.php';
session_start();
// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID from the session
    $uid = $_SESSION['id'];
    $sql = "SELECT user_id FROM users WHERE id='$uid'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $user_id = $row['user_id'];

    // Check if the action is "return-yes"
    if (isset($_POST['action']) && $_POST['action'] === 'return-yes') {
        // Retrieve the equipment ID from the POST data
        $eid = $_POST['eid'];
        $status = 'Returned';
        // Perform your actions to process the return
        //Update the quantity on the equipment table
        $updateQuery = "UPDATE borrowing SET status='$status', date_returned=CURRENT_DATE() WHERE id='$eid'";
        $resulta = mysqli_query($conn, $updateQuery);
        // For example, you can update the database or perform any other necessary tasks here.
        $sqls = "SELECT equipment_id, quantity FROM borrowing WHERE id='$eid'";
        $results = mysqli_query($conn, $sqls);
        $row = mysqli_fetch_assoc($results);
        $equipment_id = $row['equipment_id'];
        $quantity = $row['quantity'];
        
        $sqlz = "SELECT quantity FROM equipment WHERE eid='$equipment_id'";
        $resultz = mysqli_query($conn, $sqlz);
        $row = mysqli_fetch_assoc($resultz);
        $Equantity = $row['quantity'];
        $newQuantity = ($quantity + $Equantity);
        //Update the quantity on the equipment table
        $updateEQuery = "UPDATE equipment SET quantity='$newQuantity' WHERE eid='$equipment_id'";
        $resultas = mysqli_query($conn, $updateEQuery);
        // Code for Inserting data to Activity Log
        $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$uid', 'Returned Equipment', NOW())";
        mysqli_query($conn, $sqla);
        $response = [
            'status' => 'success',
            'message' => 'Equipment returned successfully.',
            'equipment_id' => $eid
        ];

        // Return the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
}

// Handle other cases, or return an error response if needed
$response = [
    'status' => 'error',
    'message' => 'Invalid request.'
];

// Return the error response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>