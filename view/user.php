<?php
include '../process/connection.php';
session_start();
if($_SESSION["id"] === null && $_SESSION["user_name"] === null){
    echo '<script>window.location.href = "index.html?sessiontoken=undefined"</script>';
    exit;
  }
$uid = $_SESSION['id'];
$uname = $_SESSION['user_name'] ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SportStock User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../styles/user-styles.css">
    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .card {
            margin: 10px;
            max-width: 300px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            text-align: justify;
            padding: 10px 5% 10px 8%;
        }

        #toaster, #borrowModal, #returnModal, #editInfoModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            padding: 20px;
            z-index: 2;
        }

        #toaster {
            top: 16px;
            right: 16px;
            padding: 16px;
            background: linear-gradient(to bottom, #F2F2F2, #D3D3D3);
            color: black;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .pagination ul {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #22B14C;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .pagination li:hover {
            background-color: #14662C;
        }

        .pagination a {
            text-decoration: none;
            color: #fff;
        }

        .pagination span {
            color: #fff;
        }

        .pagination .current-page {
            background-color: #14662C;
        }

        #borrowForm, #returnForm, #editInfoForm {
            display: flex;
            flex-direction: column;
        }

        #borrowForm label, #editInfoForm label {
            margin-top: 10px;
        }

        #borrowForm input, #editInfoForm input {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #borrowForm input[type="submit"], #editInfoForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #borrowForm input[type="submit"]:hover, #editInfoForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #borrowModal h2, #returnModal h2, #editInfoModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #borrowModal .close, #returnModal .close, #editInfoModal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #borrowModal .close:hover, #returnModal .close:hover, #editInfoModal .close:hover {
            color: #000;
        }
    </style>
</head>
<body>
    <nav>
        <!-- Button to toggle the sidebar -->
        <button id="toggleSidebarButton" class="toggle-button"><i class="fas fa-bars"></i></button>
        <div class="nav-content">
            <img src="../pictures/IT.png" class="logo" alt="Logo 1">
            <h1>SportStock User Dashboard</h1>
            <img src="../pictures/logos.png" class="logo" alt="Logo 2">
        </div>
    </nav>    
    <!-- Sidebar -->
    <div class="sidebar">
        <div style="width: 125px; height: 125px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <img class="img-circle" src="../pictures/profile<?php echo $uid;?>.jpg" style="width: 100%; height: 100%; object-fit: cover;">
        </div>
        <center><p style="position: relative; margin: 0 auto; padding: 5px;">Hi! <?php echo $uname;?></p></center>
        <a id="homeButton" class="active" style=" border-top: 4px solid #80522F;"><i class="fas fa-home"></i> Home</a>
        <a id="equipmentsButton"><i class="fas fa-dumbbell"></i> Check-out Equipment</a>
        <a id="itemsButton"><i class="fas fa-chart-bar"></i> Borrow Records</a>
        <a id="profileButton"><i class="fas fa-user"></i> Profile</a>
        <a id="logButton"><i class="fas fa-running"></i> Activity Log</a>
        <a id="logoutButton"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        <button id="closeSidebarButton" class="close-button"><i class="fas fa-times"></i></button>
    </div>

    <!-- Main content -->
    <main class="main-content">
        <div class="content">
            <!-- Start of Home Content -->
            <div id="homeModal" class="modal-container">
                <h2>Welcome to SportStock User Dashboard</h2>
                <p>
                    SportStock is your ultimate solution for managing sports equipment borrowing and return. <br />This user-friendly system allows you to easily borrow all sports equipment.
                </p>
                <hr>
                <h3>Key Features</h3>
                <ul>
                    <li> Check-out Equipment: You can check all sports equipment here and even borrow them.</li>
                    <li> Borrow Records: A Record of borrowed sports equipment that are due for return.</li>
                    <li> Profile: Manage your profile and other personal information.</li>
                    <li> Activity Log: Maintain comprehensive records of your activities.</li>
                </ul>
                <p>
                    SportStock is designed to make your sports equipment management simpler and more organized. <br />Whether you are running a sports club, gym, or any other sports-related organization, SportStock is the right choice for you.
                </p>
            </div>
            <!-- End of Home Content -->
           <!-- Start of Equipment List -->
            <div id="equipmentsModal" class="modal-container">
                <h2>Check-out Equipment</h2>
                <div class="equipment-list">
                    <?php
                    // Check for the "equipment_page" parameter in the URL or set it to 1 by default
                    $currentPage = isset($_GET['equipment_page']) ? intval($_GET['equipment_page']) : 1;

                    // Define the number of items per page
                    $itemsPerPage = 3;

                    // Calculate the offset to retrieve the appropriate items from the database
                    $offset = ($currentPage - 1) * $itemsPerPage;

                    // Query to fetch equipment items from the database with pagination
                    $query = "SELECT * FROM equipment LIMIT $itemsPerPage OFFSET $offset"; // Add LIMIT and OFFSET for pagination
                    $results = mysqli_query($conn, $query);

                    // Check if there are results
                    if ($results) {
                        while ($row = mysqli_fetch_assoc($results)) {
                            $eid = $row['eid'];
                            $ename = $row['ename'];
                            echo '<div class="equipment-item">';
                            echo '<img src="../pictures/equipment' . $row['eid'] . '.jpg" style="max-height: 175px; max-width: 175px; width: 100%; height; 100%; object-fit: cover;">'; // Added a missing '/' in the image source
                            echo '<h3>' . $row['ename'] . '</h3>';
                            echo '<p>Stock Available: ' . $row['quantity'] . '</p>';
                            echo '<p>Condition: ' . $row['quality'] . '</p>';
                            echo '<button class="borrow-button" data-eid="' . $row['eid'] . '" data-ename="' . $row['ename'] . '" data-quantity="' . $row['quantity'] . '">Borrow</button>';
                            echo '</div>';
                        }

                        // Free the result set
                        mysqli_free_result($results);

                        // Pagination navigation
                        $totalItemsQuery = "SELECT COUNT(*) AS total FROM equipment";
                        $totalItemsResult = mysqli_query($conn, $totalItemsQuery);
                        $totalItems = mysqli_fetch_assoc($totalItemsResult)['total'];
                        $totalPages = ceil($totalItems / $itemsPerPage);
                    } else {
                        echo "No equipment items found.";
                    }
                    ?>
                </div>
                <div class="pagination">
                    <ul>
                    <?php
                    $startPage = max(1, $currentPage - 1);
                    $endPage = min($totalPages, $currentPage + 1);

                    // Calculate the starting page for displaying
                    $startDisplayPage = $currentPage - 1;
                    if ($startDisplayPage < 1) {
                        $startDisplayPage = 1;
                    } else if ($endPage - $startPage < 2) {
                        $startDisplayPage = max(1, $endPage - 2);
                    }

                    // Calculate the ending page for displaying
                    $endDisplayPage = $startDisplayPage + 2;
                    if ($endDisplayPage > $totalPages) {
                        $endDisplayPage = $totalPages;
                    }

                    // Show the previous button if not on the first page
                    if ($currentPage > 1) {
                        echo '<li><a href="?equipment_page=' . ($currentPage - 1) . '">&laquo;</a></li>';
                    }

                    // Display the pages within the specified range
                    for ($page = $startDisplayPage; $page <= $endDisplayPage; $page++) {
                        echo '<li><a';
                        if ($page == $currentPage) {
                            echo ' class="active"';
                        }
                        echo ' href="?equipment_page=' . $page . '">' . $page . '</a></li>';
                    }

                    // Show the next button if not on the last page
                    if ($currentPage < $totalPages) {
                        echo '<li><a href="?equipment_page=' . ($currentPage + 1) . '">&raquo;</a></li>';
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <!-- End of Equipment List -->
            <!-- Start of Borrow Modal -->
            <div id="borrowModal" class="modal-containers" style="display: none;">
                <span class="close" id="closeBorrowModal">&times;</span> <!-- Close button -->
                <h2>Borrow Equipment</h2>
                <!-- Form for borrowing equipment -->
                <form id="borrowForm" method="post">
                    <!-- Hidden input field to store the Equipment ID (eid) -->
                    <input type="hidden" id="eid" name="eid" value="">
                    
                    <!-- Display Equipment Name -->
                    <label for="ename">Equipment Name:</label>
                    <input type="text" id="display-ename" name="display-ename" value="" disabled>

                    <!-- Display Quantity -->
                    <label for="quantity">Stock Available:</label>
                    <input type="number" id="display-quantity" name="display-quantity" value="" disabled>

                    <!-- Input field for specifying the quantity to borrow -->
                    <label for="quantity-to-borrow">Quantity to Borrow:</label>
                    <input type="number" min="1" id="quantity-to-borrow" name="quantity-to-borrow" value="1" required>
                    
                    <!-- Input field for specifying the return date -->
                    <label for="date">Return Date:</label>
                    <input type="date" id="date" name="date" value="" required>
                    
                    <input type="submit" value="Borrow">
                </form>
            </div>
            <!-- End of Borrow Modal -->
           <!-- Start of Borrow Records -->
            <div id="itemsModal" class="modal-container" style="margin-top: -17px;">
                <h2>Record of Borrowed Equipment</h2>
                <div class="container">
                <?php
                $sql = "SELECT borrowing.*, equipment.ename AS equipment_name, users.name AS user_name FROM borrowing LEFT JOIN equipment ON borrowing.equipment_id = equipment.eid LEFT JOIN users ON borrowing.user_id = users.user_id WHERE users.id='$uid'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                    $itemsPerPage = 3;
                    $totalItems = count($data);
                    $totalPages = ceil($totalItems / $itemsPerPage);
                    $currentPage = isset($_GET['record_page']) ? $_GET['record_page'] : 1;

                    // Display data for the current page
                    $startIndex = ($currentPage - 1) * $itemsPerPage;
                    $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                    for ($i = $startIndex; $i < $endIndex; $i++) {
                        $row = $data[$i];
                        ?>
                        <div class="card profile-card">
                                <label>Record ID:</label><?php echo $row['id']; ?><br />
                                <label>Borrower's Name:</label><?php echo $row['user_name']; ?><br />
                                <label>Equipment Borrowed:</label><?php echo $row['equipment_name']; ?><br />
                                <label>Quantity:</label><?php echo $row['quantity']; ?><br />
                                <label>Date Borrowed:</label><?php echo $row['borrow_date']; ?><br />
                                <label>Return Date:</label><?php echo $row['return_date']; ?><br />
                                <label>Status:</label><?php echo $row['status']; ?><br />
                                <?php
                                if ($row['date_returned'] == NULL) {
                                    echo '<br />';
                                    echo '<center>
                                            <button class="return-button" style="background-color: green; color: #f2f2f2;" data-eid="' . $row['id'] . '">Return Item</button>
                                        </center>';
                                } else {
                                    echo '<label>Date Returned:</label>' . $row['date_returned'] . '<br /><br />';
                                }
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                    </div>
                    <div class="pagination">
                        <ul>
                            <?php
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($totalPages, $currentPage + 1);

                            if ($currentPage > 1) {
                                echo "<li><a href='?equipment_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                            }

                            for ($page = $startPage; $page <= $endPage; $page++) {
                                if ($page == $currentPage) {
                                    echo "<li><span>$page</span></li>";
                                } else {
                                    echo "<li><a href='?equipment_page=$page'>$page</a></li>";
                                }
                            }

                            if ($currentPage < $totalPages) {
                                echo "<li><a href='?equipment_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    } else {
                        echo "No records found";
                    }
                    ?>
                </div>
            </div>
            <!-- End of Borrow Records -->
            <!-- Start of Return Modal -->
            <div id="returnModal" class="modal-containers" style="display: none;">
                <span class="close" id="closeReturnModal">&times;</span>
                <h2>Return Equipment</h2>
                <h2><?php echo $row['equipment_name']; ?> ?</h2>
                <!-- Form for returning equipment -->
                <form id="returnForm" method="post">
                    <!-- Hidden input field to store the Equipment ID (eid) -->
                    <input type="hidden" id="eid" name="eid" value="">
                    <input type="hidden" id="action" name="action" value=""> <!-- Added an action field -->

                    <h2 id="equipmentName"></h2><br />
                    <div style="display: flex; justify-content: space-between;">
                        <button type="button" class="btn btn-success return-yes" style="margin-left: 30px; max-width: 100px; background-color: green; color: #f2f2f2;">Yes</button>
                        <button type="button" class="btn btn-danger return-no" style="margin-right: 30px; max-width: 100px; background-color: green; color: #f2f2f2;">No</button>
                    </div>
                </form>
            </div>
            <!-- End of Return Modal -->
            <!-- Start of Profile Content -->
            <div id="profileModal" class="modal-container">
                <!-- Profile content goes here -->
                <div class="container">
                    <?php
                    $sql = "SELECT * FROM users WHERE id='$uid'";
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        // Fetch user data
                        $row = $result->fetch_assoc();
                    ?>
                    <div class="card profile-card">
                        <center><h2>Personal Data</h2></center>
                        <div style="width: 125px; height: 125px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                            <a href="#"><img class="img-circle" src="../pictures/profile<?php echo $uid;?>.jpg" style="width: 100%; height: 100%; object-fit: cover;"></a>
                        </div><br />
                        <center><button id="editInfoButton">Edit info <i class="fas fa-info-circle"></i></button></center><br />
                        <label>Name: </label><?php echo $row['name']; ?><br />
                        <label>Course & Year Level: </label><?php echo $row['course']; ?><br />
                        <label>User ID: </label><?php echo $row['user_id']; ?><br />
                        <label>Username: </label><?php echo $row['username']; ?><br />
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
            <!-- End of Profile Content -->
            <!-- Start of Edit Info Modal -->
            <div id="editInfoModal" class="modal-containers" style="display: none;">
                <span class="close" id="closeEditInfoModal">&times;</span> <!-- Close button -->
                <h2>Edit Your Information</h2>
                <!-- Form for editing user information -->
                <form id="editInfoForm" method="post">
                    <!-- Input fields for editing user information -->
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>">
                    <label for="course">Course & Year Level:</label>
                    <input type="text" id="course" name="course" value="<?php echo $row['course']; ?>">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>">
                    <input type="submit" value="Save">
                </form>
            </div>
            <!-- End of Edit Info Modal -->
           <!-- Start of Activity Log Content -->
            <div id="logModal" class="modal-container" style="margin-top: -17px; min-height: 73vh;">
                <div class="container">
                    <div class="card profile-card">
                        <h2>Activity Log</h2>
                        <?php
                        $user_id = $row['user_id'];
                        $sql = "SELECT * FROM log WHERE user_id='$uid' ORDER BY timestamp DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            $itemsPerPage = 3; // Display 3 data items per page
                            $totalItems = count($data);
                            $totalPages = ceil($totalItems / $itemsPerPage);
                            $currentPage = isset($_GET['log_page']) ? $_GET['log_page'] : 1;

                            // Display data for the current page
                            $startIndex = ($currentPage - 1) * $itemsPerPage;
                            $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                            for ($i = $startIndex; $i < $endIndex; $i++) {
                                $row = $data[$i];
                                echo '<div style="display: flex; justify-content: space-between;"><img class="img-circle" src="../pictures/profile'.$uid.'.jpg" style="max-width: 50px; max-height: 50px; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"><center>';
                                echo $row['activity'];
                                echo '<br />';
                                echo $row['timestamp'];
                                echo '</center></div><hr />';
                            }
                            ?>
                    </div>
                </div>
                <div class="pagination">
                    <ul>
                    <?php
                    $startPage = max(1, $currentPage - 1);
                    $endPage = min($totalPages, $currentPage + 1);

                    // Calculate the starting page for displaying
                    $startDisplayPage = $currentPage - 1;
                    if ($startDisplayPage < 1) {
                        $startDisplayPage = 1;
                    } else if ($endPage - $startPage < 2) {
                        $startDisplayPage = max(1, $endPage - 2);
                    }

                    // Calculate the ending page for displaying
                    $endDisplayPage = $startDisplayPage + 2;
                    if ($endDisplayPage > $totalPages) {
                        $endDisplayPage = $totalPages;
                    }

                    // Show the previous button if not on the first page
                    if ($currentPage > 1) {
                        echo '<li><a href="?log_page=' . ($currentPage - 1) . '">&laquo;</a></li>';
                    }

                    // Display the pages within the specified range
                    for ($page = $startDisplayPage; $page <= $endDisplayPage; $page++) {
                        echo '<li><a';
                        if ($page == $currentPage) {
                            echo ' class="active"';
                        }
                        echo ' href="?log_page=' . $page . '">' . $page . '</a></li>';
                    }

                    // Show the next button if not on the last page
                    if ($currentPage < $totalPages) {
                        echo '<li><a href="?log_page=' . ($currentPage + 1) . '">&raquo;</a></li>';
                    }
                    ?>
                    </ul>
                </div>
                <?php
                } else {
                    echo "No logs found";
                }
                ?>
            </div>
            <!-- End of Activity Log Content -->
        </div>
        <!-- Start of Logout Content -->
        <div class="modal-container" id="logoutModal">
            <div class="modal-content">
                <!-- Logout Modal Content -->
                <div class="card-container" style="display: flex; justify-content: center; align-items: center; height: auto; border-radius: 5px;">
                    <div class="card profile-card" style="max-width: 500px; width: 100%; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); text-align: justify; padding: 10px 8% 10px 5%; display: flex; flex-direction: column; border-radius: 5px;">
                        <center><br />
                            <h4 style="position: relative;">Are you sure you want to log out?</h4><br /><br /><br />
                            <div class="button-container" style="display: flex; justify-content: flex-end;">
                                <button id="logout-confirm-button" class="modal-button action-button" style="margin-right: 5px; padding: 10px 20px; border-radius: 15px; border: none; background-color: green; color: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">Yes</button>
                                <button id="logout-cancel-button" class="modal-button action-button" style="padding: 10px 20px; border-radius: 15px; border: none; background-color: green; color: white; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);">No</button>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Logout Content -->
        <!-- Toaster Notification -->
        <div id="toaster">
            <div id="toaster-message"></div>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 SportStock</p>
    </footer>
    <script src="../scripts/user-scripts.js"></script>
    <script src="../scripts/user-sidebar-scripts.js"></script>
    <script>
        // Function to show toaster message
        function showToast(message) {
            var toaster = document.getElementById('toaster-message');
            toaster.innerHTML = message;
            toaster.parentElement.style.display = 'block';

            // Hide the toaster after 5 seconds
            setTimeout(function() {
                toaster.parentElement.style.display = 'none';
                toaster.innerHTML = '';
            }, 5000);
        }

        // Check if there is a toaster message in the URL
        var urlParams = new URLSearchParams(window.location.search);
        var toasterMessage = urlParams.get('toasterMessage');

        if (toasterMessage) {
            // Display the toaster message
            showToast(toasterMessage);

            // Update the URL without the toaster message
            history.replaceState({}, document.title, window.location.pathname);
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarLinks = document.querySelectorAll('.sidebar a');

            // Check if there's an active button stored in localStorage
            const storedActiveButtonId = localStorage.getItem('activeButtonId');

            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    // Check if the clicked link is the logoutButton and skip adding/removing the 'active' class
                    if (link.id === 'logoutButton') {
                        return;
                    }

                    // Remove the 'active' class from all links
                    sidebarLinks.forEach(function (l) {
                        l.classList.remove('active');
                    });

                    // Add the 'active' class to the clicked link
                    link.classList.add('active');

                    // Store the active button's id in localStorage
                    localStorage.setItem('activeButtonId', link.id);
                });
            });

            if (storedActiveButtonId) {
                const storedActiveButton = document.getElementById(storedActiveButtonId);
                const defaultButton = document.getElementById('homeButton');

                // Check if the stored active button exists in the sidebar
                if (storedActiveButton && storedActiveButtonId !== 'logoutButton') {
                    defaultButton.classList.remove('active');
                    storedActiveButton.classList.add('active');
                } else {
                    // If the stored active button doesn't exist or is the logoutButton, remove the 'active' class from all links
                    sidebarLinks.forEach(function (l) {
                        l.classList.remove('active');
                    });
                }
            }
        });
    </script>
    <script>
        // Get the modal and button elements
        const borrowModal = document.getElementById("borrowModal");
        const borrowButtons = document.querySelectorAll('.borrow-button');
        const closeBorrowModal = document.getElementById("closeBorrowModal");
        const eidInput = document.getElementById("eid");
        const enameInput = document.getElementById("display-ename");
        const quantityInput = document.getElementById("display-quantity");

        // Function to show the "Borrow Equipment" modal and populate it with data
        function showBorrowModal(eid, ename, quantity) {
            borrowModal.style.display = "block";
            eidInput.value = eid;
            enameInput.value = ename;
            quantityInput.value = quantity;
        }

        // Function to send data to borrow-item.php using AJAX
        function submitBorrowForm() {
            // Get the form data
            const formData = new FormData(document.getElementById("borrowForm"));

            // Make a POST request to borrow-item.php
            fetch("../process/borrow-item.php", {
                method: "POST",
                body: formData
            })
            .then((response) => {
                if (response.ok) {
                    return response.json(); // Parse the JSON response
                } else {
                    throw new Error("Error in fetch request.");
                }
            })
            .then((data) => {
                if (data.success) {
                    // Update the UI or show a success message
                    console.log("Equipment Borrowed successfully!");
                    // Close the "Borrow Equipment" modal
                    borrowModal.style.display = "none";
                    setTimeout(function() {
                        window.location.href = "user.php?toasterMessage=Equipment%20Borrowed%20Successfully!";
                    }, 500);
                } else {
                    // Handle the case where the update was not successful
                    console.error("Update failed.");
                }
            })
            .catch((error) => {
                // Handle any errors that occurred during the fetch
                console.error(error);
            });
        }

        // Add a submit event listener to the "Borrow Equipment" form
        document.getElementById("borrowForm").addEventListener("submit", (event) => {
            event.preventDefault(); // Prevent the default form submission
            submitBorrowForm(); // Call the function to send data via AJAX
        });

        // Close the "Borrow Equipment" modal when the user clicks outside or presses 'Esc'
        window.addEventListener("click", (event) => {
            if (event.target === borrowModal) {
                borrowModal.style.display = "none";
            }
        });

        document.addEventListener("keyup", (event) => {
            if (event.key === "Escape") {
                borrowModal.style.display = "none";
            }
        });

        // Close the "Borrow Equipment" modal when the close button is clicked
        closeBorrowModal.addEventListener("click", () => {
            borrowModal.style.display = "none";
        });

        // Add event listeners to "Borrow" buttons
        borrowButtons.forEach((button) => {
            button.addEventListener("click", () => {
                const eid = button.getAttribute("data-eid");
                const ename = button.getAttribute("data-ename");
                const quantity = button.getAttribute("data-quantity");
                showBorrowModal(eid, ename, quantity);
            });
        });
    </script>
    <script>
        // Get the modal and button elements
        const returnModal = document.getElementById("returnModal");
        const returnButtons = document.querySelectorAll(".return-button");
        const returnYesButton = document.querySelector(".return-yes");
        const returnNoButton = document.querySelector(".return-no");
        const equipmentNameElement = document.getElementById("equipmentName");

        // Show the "Return" modal when a button is clicked
        returnButtons.forEach(button => {
            button.addEventListener("click", () => {
                returnModal.style.display = "block";
                const eid = button.getAttribute("data-eid");
                const equipmentName = button.getAttribute("data-equipment-name");
                document.getElementById("eid").value = eid;
                equipmentNameElement.innerText = equipmentName;
            });
        });

        // Close the "Return" modal when the user clicks outside of it or presses the 'Esc' key
        window.addEventListener("click", (event) => {
            if (event.target === returnModal) {
                returnModal.style.display = "none";
            }
        });

        document.addEventListener("keyup", (event) => {
            if (event.key === "Escape") {
                returnModal.style.display = "none";
            }
        });

        const closeReturnModal = document.getElementById("closeReturnModal");

        // Close the "Return" modal when the close button is clicked
        closeReturnModal.addEventListener("click", () => {
            returnModal.style.display = "none";
        });

        // AJAX function for form submission
        returnYesButton.addEventListener("click", () => {
            const eid = document.getElementById("eid").value;
            const action = "return-yes";
            const formData = new FormData();
            formData.append("eid", eid);
            formData.append("action", action);

            // Send an AJAX request to return-item.php
            fetch("../process/return-item.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json()) // Assuming the response from return-item.php is in JSON format
            .then(data => {
                 // Update the UI or show a success message
                 console.log("Equipment return successful!");
                    // Close the modal
                    editInfoModal.style.display = "none";
                    setTimeout(function() {
                        window.location.href = "user.php?toasterMessage=Return%20Borrowed%20Equipment%20Successfully!";
                    }, 500);
            })
            .catch(error => {
                console.error("Error:", error);
            });

            returnModal.style.display = "none"; // Close the modal
        });

        returnNoButton.addEventListener("click", () => {
            returnModal.style.display = "none"; // Close the modal
        });
    </script>
    <script>
        // Get the modal and button elements
        const editInfoModal = document.getElementById("editInfoModal");
        const editInfoButton = document.getElementById("editInfoButton");

        // Show the "Edit Info" modal when the button is clicked
        editInfoButton.addEventListener("click", () => {
            editInfoModal.style.display = "block";
        });

        // Close the "Edit Info" modal when the user clicks outside of it or presses the 'Esc' key
        window.addEventListener("click", (event) => {
            if (event.target === editInfoModal) {
                editInfoModal.style.display = "none";
            }
        });

        document.addEventListener("keyup", (event) => {
            if (event.key === "Escape") {
                editInfoModal.style.display = "none";
            }
        });

        const closeEditInfoModal = document.getElementById("closeEditInfoModal");

        // Close the "Edit Info" modal when the close button is clicked
        closeEditInfoModal.addEventListener("click", () => {
            editInfoModal.style.display = "none";
        });

        // Form submission - Handle it with AJAX
        const editInfoForm = document.getElementById("editInfoForm");
        editInfoForm.addEventListener("submit", (event) => {
            event.preventDefault();

            // Serialize the form data into a URL-encoded string
            const formData = new URLSearchParams(new FormData(editInfoForm));

            // Send an AJAX request using the Fetch API
            fetch("../process/update-user-info.php", {
                method: "POST",
                body: formData,
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
            })
            .then(response => {
                if (response.ok) {
                    // The request was successful, handle the response here
                    return response.json(); // If the server returns JSON data
                } else {
                    // Handle errors, e.g., display an error message
                    throw new Error("Request failed.");
                }
            })
            .then(data => {
                // Handle the response data (if applicable)
                if (data.success) {
                    // Update the UI or show a success message
                    console.log("Update successful!");
                    // Close the modal
                    editInfoModal.style.display = "none";
                    setTimeout(function() {
                        window.location.href = "user.php?toasterMessage=Personal%20Data%20Updated%20Successfully!";
                    }, 500);
                } else {
                    // Handle the case where the update was not successful
                    console.error("Update failed.");
                }
            })
            .catch(error => {
                // Handle network errors or other exceptions
                console.error("Error: " + error.message);
            });
        });
    </script>
</body>
</html>
