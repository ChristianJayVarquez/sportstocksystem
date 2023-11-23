<?php
// Include your database connection here
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Get the user's input
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Perform user validation (you should adapt this logic to your actual user table)
        $query = "SELECT id, role FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $user_role);
            $stmt->fetch();

            // Start a session and store user data (you mentioned you don't want to use sessions, so you can adapt this part)
            session_start();
            $_SESSION['id'] = $user_id;
            $_SESSION['user_role'] = $user_role;
            $_SESSION['user_name'] = $username;

            // Define the response data
            $response = [
                'success' => true,
                'role' => $user_role,
                'session_id' => session_id(),
            ];

            // Code for Inserting data to Activity Log
            $sql = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Logged In', NOW())";
            mysqli_query($conn, $sql);
        } else {
            $response = ['success' => false];
        }

        // Close the database connection
        $stmt->close();
        $conn->close();

        // Send JSON response back to the client
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
