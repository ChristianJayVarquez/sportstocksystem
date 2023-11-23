<?php
include 'connection.php';
session_start();
$user_id = $_SESSION['id'];
if (isset($_POST['borrow'])) {
    // Retrieve form data
    $equipment_id = $_POST['eID'];
    $quantityToBorrow = $_POST['quantity'];
    $user_id = $_POST['bname'];
    $return_date = $_POST['rdate'];

    $sqls = "SELECT quantity FROM equipment WHERE eid='$equipment_id'";
    $results = mysqli_query($conn, $sqls);
    $row = mysqli_fetch_assoc($results);
    $quantity = $row['quantity'];
    $newQuantity = ($quantity - $quantityToBorrow);
    //Update the quantity on the equipment table
    $updateQuery = "UPDATE equipment SET quantity='$newQuantity' WHERE eid='$equipment_id'";
    mysqli_query($conn, $updateQuery);

    // Insert the data into the "borrowing" table
    $sql = "INSERT INTO borrowing (equipment_id, quantity, user_id, status, borrow_date, return_date)
            VALUES ('$equipment_id', '$quantity', '$user_id', 'Borrowing', CURRENT_DATE(), '$return_date')";

    if (mysqli_query($conn, $sql)) {
        // Code for Inserting data to Activity Log
        $sqla = "INSERT INTO log (user_id, activity, timestamp) VALUES ('$user_id', 'Equipment Borrowed!', NOW())";
        mysqli_query($conn, $sqla);
        echo '<script>
            window.alert("Borrowing record has been successfully added.");
            setTimeout(function() {
                window.location.href = "../view/admin.php?toasterMessage=Equipment%20Borrowed%20Successfully!%20Created%20Borrow%20Record!";
            }, 500);
          </script>';
    } else {
        // Insertion failed
        echo "Error: " . mysqli_error($conn);
    }
}

// Close the database connection when done.
mysqli_close($conn);
?>
