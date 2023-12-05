<?php
include '../process/connection.php';
session_start();
if($_SESSION["id"] === null && $_SESSION["user_name"] === null){
    echo '<script>window.location.href = "index.html?sessiontoken=undefined"</script>';
    exit;
  }
$uid = $_SESSION['id'];
$uname = $_SESSION['user_name'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SportStock User Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="website icon" type="png" href="../pictures/logos.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../styles/user-styles.css">
    <style>
        /* Common styles */
        .card-container,
        .card,
        .pagination,
        .form-group,
        input,
        select,
        #toaster {
            border-radius: 5px;
        }

        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto;
        }

        .card {
            max-width: 500px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            text-align: justify;
            padding: 10px 8% 10px 5%;
            display: flex;
            flex-direction: column;
        }

        .card button {
            margin-top: 10px;
        }

        .pagination-container {
            position: relative;
        }

        .pagination {
            list-style: none;
            display: flex;
            position: absolute;
            bottom: 0;
            right: 0;
            margin: 5px;
        }

        .pagination ul {
            display: flex;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 5px;
            padding: 5px 10px;
            background-color: #22B14C;
            color: lime;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px;
        }

        .pagination li:hover {
            background-color: #14662C;
        }

        .pagination a {
            color: #fff;
            text-decoration: none;
            display: inline-block;
        }

        /* Styles for specific modals */
        .modal-containers {
            border: none;
            border-radius: 10px;
            background: rgba(88, 182, 88, 0.5); /* Glass color with 50% opacity */
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 95%;
            z-index: 2;
        }

        #borrowModal, #returnModal, #editInfoModal {
            background-color: none;
            border-radius: 10px;
            max-width: 400px;
            box-shadow: 0px 0px 10px rgba(88, 182, 88, 0.5);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
            height: auto; /* Updated to auto height */
            flex-direction: column;
            justify-content: space-between; /* Updated for justified content */
        }

        #borrowModal, #returnModal, #editInfoModal h2 {
            font-size: 20px;
            margin: 0;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group label {
            position: absolute;
            top: 5px;
            left: 5px;
            font-size: 10px;
            color: black;
            pointer-events: none;
            transition: color 0.3s;
        }

        .form-group input,
        .form-group select {
            padding-top: 20px;
            padding-left: 15px;
            border: 1px solid #d2d2d2;
        }

        .form-group input,
        .form-group select,
        #toaster p {
            width: calc(100% - 10px); /* Adjusted width to make room for labels */
            padding: 10px;
            margin: 5px 0;
            border-color: #d2d2d2;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent white input background */
        }

        /* Adjusted some styles for consistency */
        .input-group {
            display: flex;
            flex-direction: column;
        }

        /* Updated submit button styles */
        input[type="submit"] {
            width: 100%;
            background-color: #14662C; /* Green submit button background color */
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        /* Styles for the toaster notification here */
        #toaster {
            display: none;
            position: fixed;
            top: 16px;
            right: 16px;
            padding: 16px;
            max-width: 300px;
            background: linear-gradient(to bottom, #F2F2F2, #D3D3D3);
            color: black;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Media query for mobile responsiveness */
        @media screen and (max-width: 768px) {
            .main-content {
                margin-left: 0;
                transition: none !important;
            }

            /* Modal container styles */
            .modal-container {
                width: 100%;
                left: 0;
                top: auto;
                transform: none;
                position: relative;
                height: auto;
                flex-direction: column;
                justify-content: flex-start;
                padding: 10px;
            }

            .modal-content {
                max-width: 100%;
                padding: 10px;
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <header>
        <!-- Button to toggle the sidebar -->
        <button id="toggleSidebarButton" class="toggle-button"><i class="fas fa-bars"></i></button>
        <center><table>
            <tr>
                <td>
                <img src="../pictures/logos.png" style="width: auto; height: auto; max-width: 125px; max-height: 125px;">
                </td>
                <td>
                    <h1>SportStock User Dashboard</h1>
                </td>
            </tr>
        </table></center>
    </header>    
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
                    <li> <strong>Check-out Equipment:</strong> You can check all sports equipment here and even borrow them.</li>
                    <li> <strong>Borrow Records:</strong> A Record of borrowed sports equipment that are due for return.</li>
                    <li> <strong>Profile:</strong> Manage your profile and other personal information.</li>
                    <li> <strong>Activity Log:</strong> Maintain comprehensive records of your activities.</li>
                </ul>
                <p>
                    SportStock is designed to make your sports equipment management simpler and more organized. <br />Whether you are running a sports club, gym, or any other sports-related organization, SportStock is the right choice for you.
                </p>
            </div>
            <!-- End of Home Content -->
            <!-- Start of Equipment List -->
            <div id="equipmentsModal" class="modal-container">
                <h2 style="position: relative;">Check-out Equipment</h2>
                <div style="position: absolute; top: 150px; right: 10px;">
                    <div class="search-container">
                        <input type="text" id="equipment-search" style="max-width: 300px;" placeholder="Search for equipment...">
                        <button id="search-button" style="background-color: green; color: white;"><i class="fas fa-search"></i></button>
                    </div>
                </div><br /><br />
                <div class="card-container">
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
                    ?>
                    <div class="card equipment-card" data-ename="<?php echo strtolower($ename); ?>">
                        <div style="width: 115px; height: 115px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                            <img class="img-circle" src="../pictures/equipment<?php echo $row['eid'];?>.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                        </div><br />
                        <div class="card-content">
                            <div class="label-data-pair">
                                <label>Equipment Name:</label> <?php echo $ename; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Sports Category:</label> <?php echo $row['category']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Quantity:</label> <?php echo $row['quantity']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Condition:</label> <?php echo $row['quality']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Last Maintenance:</label> <?php echo $row['last_maintenance_date']; ?>
                            </div><br /><br />
                            <div style="position: absolute; bottom: 0; right: 0; padding: 10px;">
                                <button class="borrow-button btn-primary" data-eid="<?php echo $eid; ?>" data-ename="<?php echo $ename; ?>" data-quantity="<?php echo $row['quantity']; ?>">Borrow</button>
                            </div>
                        </div>
                    </div>
                    <?php
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
                </div><br /><br />
                <div class="pagination-container">
                    <div class="pagination">
                        <ul>
                            <?php
                            // Display previous button
                            if ($currentPage > 1) {
                                echo "<li><a href='?equipment_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                            }

                            // Display pagination buttons
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($totalPages, $startPage + 2);

                            for ($page = $startPage; $page <= $endPage; $page++) {
                                if ($page == $currentPage) {
                                    echo "<li class='active'><span>$page</span></li>";
                                } else {
                                    echo "<li><a href='?equipment_page=$page'>$page</a></li>";
                                }
                            }

                            // Display next button
                            if ($currentPage < $totalPages) {
                                echo "<li><a href='?equipment_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
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
                    <div class="form-group">
                        <!-- Display Equipment Name -->
                        <label for="ename">Equipment Name:</label>
                        <input type="text" id="display-ename" name="display-ename" value="" disabled>
                    </div>
                    <div class="form-group">
                        <!-- Display Quantity -->
                        <label for="quantity">Stock Available:</label>
                        <input type="number" id="display-quantity" name="display-quantity" value="" disabled>
                    </div>
                    <div class="form-group">
                        <!-- Input field for specifying the quantity to borrow -->
                        <label for="quantity-to-borrow">Quantity to Borrow:</label>
                        <input type="number" min="1" id="quantity-to-borrow" name="quantity-to-borrow" value="1" required>
                    </div>
                    <div class="form-group">
                        <!-- Input field for specifying the return date -->
                        <label for="date">Return Date:</label>
                        <input type="date" id="date" name="date" value="" required>
                    </div><br />
                    <div style="position: absolute; bottom: 10px; right: 10px;">
                        <input type="submit" value="Borrow">
                    </div>
                </form>
            </div>
            <!-- End of Borrow Modal -->
            <!-- Start of Borrow Records -->
            <div id="itemsModal" class="modal-container" style="margin-top: -17px;">
                <h2>Record of Borrowed Equipment</h2>
                <div class="card-container">
                    <?php
                    // Sanitize user input to prevent SQL injection
                    $uid = mysqli_real_escape_string($conn, $uid);

                    $sql = "SELECT borrowing.*, equipment.eid AS equipment_id, equipment.ename AS equipment_name, users.name AS user_name FROM borrowing LEFT JOIN equipment ON borrowing.equipment_id = equipment.eid LEFT JOIN users ON borrowing.user_id = users.user_id WHERE users.id='$uid' ORDER BY borrowing.id DESC";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                        $itemsPerPage = 2;
                        $totalItems = count($data);
                        $totalPages = ceil($totalItems / $itemsPerPage);
                        $currentPage = isset($_GET['record_page']) ? $_GET['record_page'] : 1;

                        // Display data for the current page
                        $startIndex = ($currentPage - 1) * $itemsPerPage;
                        $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                        for ($i = $startIndex; $i < $endIndex; $i++) {
                            $row = $data[$i];
                            ?>
                            <div class="card record-card">
                                <div style="width: 125px; height: 125px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                    <a href="#"><img class="img-circle" src="../pictures/equipment<?php echo $row['equipment_id'];?>.jpg" style="width: 100%; height: 100%; object-fit: cover;"></a>
                                </div>
                                <div class="card-content">
                                    <div class="label-data-pair">
                                        <label>Record ID:</label> <?php echo $row['id']; ?>
                                    </div>
                                    <div class="label-data-pair">
                                        <label>Borrower's Name:</label> <?php echo $row['user_name']; ?>
                                    </div>
                                    <div class="label-data-pair">
                                        <label>Equipment Borrowed:</label> <?php echo $row['equipment_name']; ?>
                                    </div>
                                    <div class="label-data-pair">
                                        <label>Quantity:</label> <?php echo $row['quantity']; ?>
                                    </div>
                                    <div class="label-data-pair">
                                        <label>Date Borrowed:</label> <?php echo $row['borrow_date']; ?>
                                    </div>
                                    <div class="label-data-pair">
                                        <label>Return Date:</label> <?php echo $row['return_date']; ?>
                                    </div>
                                    <div class="label-data-pair">
                                        <label>Status:</label> <?php echo $row['status']; ?>
                                    </div><br />
                                    <?php
                                    if ($row['date_returned'] == NULL) {
                                        echo '<br /><div class="label-data-pair" style="position: absolute; bottom: 10px; right: 10px;">
                                                <button class="return-button" style="background-color: green; color: #f2f2f2;" data-eid="' . $row['id'] . '" data-equipment-name="' . $row['equipment_name'] . '">Return Item</button>
                                            </div>';
                                    } else {
                                        echo '<div class="label-data-pair">
                                                <label>Date Returned:</label>' . $row['date_returned'] . '
                                            </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                    </div><br /><br />
                    <div class="pagination-container">
                        <div class="pagination">
                            <ul>
                                <?php
                                $startPage = max(1, $currentPage - 1);
                                $endPage = min($totalPages, $currentPage + 1);

                                if ($currentPage > 1) {
                                    echo "<li><a href='?record_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                                }

                                for ($page = $startPage; $page <= $endPage; $page++) {
                                    if ($page == $currentPage) {
                                        echo "<li><span>$page</span></li>";
                                    } else {
                                        echo "<li><a href='?record_page=$page'>$page</a></li>";
                                    }
                                }

                                if ($currentPage < $totalPages) {
                                    echo "<li><a href='?record_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                                }
                                ?>
                            </ul>
                        </div>
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
                <!-- Form for returning equipment -->
                <form id="returnForm" method="post">
                    <!-- Hidden input field to store the Equipment ID (eid) -->
                    <input type="hidden" id="eid" name="eid" value="">
                    <input type="hidden" id="action" name="action" value=""> <!-- Added an action field -->

                    <h2 id="equipmentName"></h2><br />
                    <div style="display: flex; justify-content: space-between; position: absolute; bottom: 10px; right: 10px;">
                        <button type="button" class="btn btn-success return-yes" style="margin-right: 10px; max-width: 100px; background-color: green; color: #f2f2f2;">Yes</button>
                        <button type="button" class="btn btn-success return-no" style="border: none; max-width: 100px; background-color: green; color: #f2f2f2;">No</button>
                    </div>
                </form>
            </div>
            <!-- End of Return Modal -->
            <!-- Start of Profile Content -->
            <div id="profileModal" class="modal-container">
                <!-- Profile content goes here -->
                <div class="card-container">
                    <?php
                    $sql = "SELECT * FROM users WHERE id='$uid'";
                    $result = mysqli_query($conn, $sql);

                    if ($result->num_rows > 0) {
                        // Fetch user data
                        $row = $result->fetch_assoc();
                        $image_version = time(); // Get a unique version identifier
                    ?>
                        <div class="card profile-card">
                            <center><h2>Personal Data</h2></center>
                            <div style="width: 125px; height: 125px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                                <!-- Display current profile picture with version parameter -->
                                <a href="#"><img class="img-circle" src="../pictures/profile<?php echo $uid;?>.jpg?<?php echo $image_version; ?>" style="width: 100%; height: 100%; object-fit: cover;"></a>

                                <!-- Add form for updating profile picture -->
                                <form action="../process/update_profile_picture.php" method="post" enctype="multipart/form-data">
                                    <input type="file" name="profile_picture" accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                    <button type="submit" style="position: absolute; bottom: 0; left: 50%; transform: translateX(-50%); background-color: transparent; border: none; color: green;"><i class="fas fa-upload" style="color: green;"></i></button>
                                </form>
                            </div>
                            <center><button id="editInfoButton">Edit info <i class="fas fa-pencil"></i></button></center><br />
                            <div class="label-data-pair">
                                <label>Name: </label><?php echo $row['name']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Course & Year Level:</label> <?php echo $row['course']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>User ID:</label> <?php echo $row['user_id']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Username:</label> <?php echo $row['username']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Password:</label> ********
                            </div>
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
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="course">Course & Year Level:</label>
                        <input type="text" id="course" name="course" value="<?php echo $row['course']; ?>">
                    </div>
                    <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>">
                    </div><br />
                    <div style="position: absolute; bottom: 10px; right: 10px;">
                        <input type="submit" value="Save">
                    </div>
                </form>
            </div>
            <!-- End of Edit Info Modal -->
            <!-- Start of Activity Log Content -->
            <div id="logModal" class="modal-container" style="margin-top: -17px; min-height: 73vh;">
                <div class="card-container" style="padding-right: 2%;">
                    <div class="card log-card" style="max-width: 625px;">
                    <center><h2>Activity Log</h2></center>
                        <?php
                        $user_id = $row['user_id'];
                        $sql = "SELECT log.*, users.username AS user_name FROM log LEFT JOIN users ON log.user_id = users.id WHERE log.user_id='$uid' ORDER BY log.timestamp DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            $itemsPerPage = 5; // Display 3 data items per page
                            $totalItems = count($data);
                            $totalPages = ceil($totalItems / $itemsPerPage);
                            $currentPage = isset($_GET['log_page']) ? $_GET['log_page'] : 1;

                            // Display data for the current page
                            $startIndex = ($currentPage - 1) * $itemsPerPage;
                            $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                            for ($i = $startIndex; $i < $endIndex; $i++) {
                                $row = $data[$i];
                                echo '<div style="display: flex; justify-content: space-between;"><img class="img-circle" src="../pictures/profile'.$uid.'.jpg" style="max-width: 50px; max-height: 50px; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"><p>'.$row['user_name'].'</p><center>';
                                echo $row['activity'];
                                echo '</center><center>';
                                echo $row['timestamp'];
                                echo '</center></div><hr />';
                            }
                            ?>
                    </div>
                </div><br /><br />
                <div class="pagination-container">
                    <div class="pagination">
                        <ul>
                            <?php
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($totalPages, $currentPage + 1);

                            if ($currentPage > 1) {
                                echo "<li><a href='?log_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                            }

                            for ($page = $startPage; $page <= $endPage; $page++) {
                                if ($page == $currentPage) {
                                    echo "<li><span>$page</span></li>";
                                } else {
                                    echo "<li><a href='?log_page=$page'>$page</a></li>";
                                }
                            }

                            if ($currentPage < $totalPages) {
                                echo "<li><a href='?log_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <?php
                } else {
                    echo "No logs found";
                }
                ?>
            </div>
            <!-- End of Activity Log Content -->
            <!-- Start of Logout Content -->
            <div class="modal-container" id="logoutModal">
                <div class="modal-content" style="min-height: 73vh;">
                    <!-- Logout Modal Content -->
                    <div class="card-container">
                        <div class="card profile-card">
                            <center><br />
                                <h4 style="position: relative;">Are you sure you want to log out?</h4><br /><br /><br />
                                    <div class="button-container" style="position: absolute; bottom: 10px; right: 10px;">
                                        <button style="background-color: #22B14C; color: #F2F2F2;" id="logout-confirm-button" class="modal-button action-button" onclick="confirmLogout()">Yes</button>
                                        <button style="background-color: #22B14C; color: #F2F2F2;" id="logout-cancel-button" class="modal-button action-button" onclick="confirmLogout()">No</button>
                                    </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Logout Content -->
        </div>
        <!-- Toaster Notification -->
        <div id="toaster">
            <div id="toaster-message"></div>
        </div>
    </main>
    <footer>
        <p>&copy; 2023 SportStock System: ADS | Made by: Group2 @ AY: 2023-2024</p>
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.form-group input, .form-group select').forEach((input) => {
                const label = input.previousElementSibling;

                input.addEventListener('input', () => {
                    if (input.value.trim() !== '') {
                        label.style.color = 'black'; // Ensure label color is set when input has value
                    } else {
                        label.style.color = 'black'; // Keep label color black when input is empty
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("equipment-search");

            searchInput.addEventListener("input", function () {
                const searchTerm = searchInput.value.toLowerCase();

                // Show all equipment cards
                const allCards = document.querySelectorAll('.equipment-card');
                allCards.forEach(card => {
                    card.style.display = 'block';
                });

                // Show only the cards that match the search term
                if (searchTerm) {
                    const nonMatchingCards = document.querySelectorAll(`.equipment-card:not([data-ename*="${searchTerm}"])`);
                    nonMatchingCards.forEach(card => {
                        card.style.display = 'none';
                    });
                }

                // Check if no results are found
                const noResultsMessage = document.getElementById("no-results-message");
                if (document.querySelectorAll('.equipment-card:not([style="display: none;"])').length === 0) {
                    if (noResultsMessage) {
                        noResultsMessage.style.display = 'block';
                    } else {
                        // Create and append a "No Search Results" message
                        const noResultsDiv = document.createElement("div");
                        noResultsDiv.id = "no-results-message";
                        noResultsDiv.innerHTML = "<p style='color: red;'>No Search results found</p>";
                        const cardContainer = document.querySelector(".card-container");
                        cardContainer.appendChild(noResultsDiv);
                    }
                } else {
                    // Hide the "No Search Results" message if it exists
                    if (noResultsMessage) {
                        noResultsMessage.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>
