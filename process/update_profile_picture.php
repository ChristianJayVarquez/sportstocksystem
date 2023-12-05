<?php
session_start();
include 'connection.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_SESSION['id']; // You may need to adjust how you retrieve the user ID

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
                $image_version = time(); // or use any other unique identifier

                // Redirect to user.php with toaster message and version parameter
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "../view/user.php?toasterMessage=Profile%20Picture%20Updated%20Successfully&version=' . $image_version . '";
                        }, 500);
                    </script>';
                exit(); // Ensure that no additional script is executed after redirection
            } else {
                // Error uploading file
                echo '<script>
                        setTimeout(function() {
                            window.location.href = "../view/user.php?toasterMessage=Sorry,%20there%20was%20an%20error%20uploading%20your%20file.";
                        }, 500);
                    </script>';
            }
        } else {
            // Invalid file type or size
            echo '<script>
                    setTimeout(function() {
                        window.location.href = "../view/user.php?toasterMessage=Invalid%20file%20type%20or%20exceeds%20size%20limit.";
                    }, 500);
                </script>';
        }
    } else {
        // No file selected or error in file upload
        echo '<script>
                setTimeout(function() {
                    window.location.href = "../view/user.php?toasterMessage=Please%20select%20a%20valid%20image%20file!";
                }, 500);
            </script>';
    }
} else {
    // Form not submitted
    echo '<script>
            setTimeout(function() {
                window.location.href = "../view/user.php?toasterMessage=Error:%20Unexpected%20try%20again!";
            }, 500);
        </script>';
}
?>
