<?php
include '../process/connection.php';

// Start the session
session_start();
$user_id = $_SESSION['id'];
// Code for Inserting data to Activity Log
$sql = "INSERT INTO log (user_id, activity, timestamp) VALUES (?, 'Logged Out', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->close();
// Destroy the session
session_destroy();

// JavaScript function to clear browser cache and history
echo '<script>
    function clearCacheAndHistory() {
        // Clear local storage
        localStorage.clear();

        // Clear session storage
        sessionStorage.clear();

        // Clear cookies
        document.cookie.split(";").forEach(function(c) {
            document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/");
        });

        // Clear browser history
        window.history.replaceState(null, null, window.location.href);

        // Force reload to clear cache
        location.reload(true);
    }

    // Call the function to clear cache and history
    clearCacheAndHistory();
</script>';

// Redirect the user to the logout page or any other desired location
header("Location: ../view/index.html?toasterMessage=You%20have%20Logged%20Out%20Successfully");
exit;
?>
