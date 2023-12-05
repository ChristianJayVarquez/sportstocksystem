<?php
include '../process/connection.php';
session_start();
if ($_SESSION["id"] === null && $_SESSION["user_name"] === null) {
    echo '<script>window.location.href = "index.html?sessiontoken=undefined"</script>';
    exit;
}
$uid = $_SESSION['id'];
$uname = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SportStock Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../styles/admin-styles.css">
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

        .pagination {
            list-style: none;
            display: flex;
            position: absolute;
            bottom: 0;
            right: 0;
            margin: 5px;
        }

        .pagination li {
            margin: 0 5px;
            padding: 5px 10px; /* Adjust padding to control the spacing around the number */
            background-color: #22B14C;
            color: lime;
            cursor: pointer;
            transition: background-color 0.3s;
            border-radius: 5px; /* Adding border-radius for a rounded look */
        }

        .pagination li:hover {
            background-color: #14662C;
        }

        .pagination a {
            color: #fff;
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

        #AddEModal,
        #EditEModal,
        #delEModal,
        #viewUAModal,
        #AddNModal,
        #RequestModal,
        #editInfoModal,
        #DeleteUserModal,
        #BorrowingModal {
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

        #AddEModal h2,
        #EditEModal h2,
        #delEModal h2,
        #viewUAModal h2,
        #AddNModal h2,
        #RequestModal h2,
        #editInfoModal h2,
        #DeleteUserModal h2,
        #BorrowingModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #RequestForm label,
        #DeleteUserForm label,
        #BorrowingForm label {
            margin-top: 10px;
            display: block;
            color: black;
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
            
            /* Sidebar Styles */
            .sidebar {
            border: 4px solid #80522F; /* Add a border */
            height: auto;
            min-height: 100vh;
            width: 225px;
            position: fixed;
            top: 0;
            left: -250px; /* Start with sidebar hidden */
            background: #f2f2f2;
            color: #795548; /* Brown */
            padding-top: 50px;
            }

            .sidebar a {
            border-bottom: 4px solid #80522F; /* Add a border */
            padding: 15px;
            text-align: center;
            text-decoration: none;
            font-size: 18px;
            color: #795548; /* Brown */
            display: block;
            }

            .sidebar a:hover {
            background: linear-gradient(135deg, #8b4513, #f5d0a9); /* Change the gradient from brown to light brown */
            color: #fff; /* Text color on hover */
            }

            .sidebar a.active {
            background: linear-gradient(135deg, #8b4513, #f5d0a9); 
            color: #fff; /* Text color on hover */
            }
            /* Add this CSS to make the main content and modals move responsively */


            /* Button Styles */
            .toggle-button {
            background: #14662C;
            color: #fff;
            border: none;
            padding: 10px;
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            }

            .toggle-button:hover {
            background: #795548; /* Brown */
            }

            .close-button {
            background: #f2f2f2; /* Biege */
            color: #000;
            border: none;
            padding: 10px;
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            display: none;
            }

            .close-button:hover {
            background: #795548; /* Brown */
            }
            /* Main content styles */
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

            /* Updated styles for card container on mobile */
            .card-container {
                flex-direction: column;
                align-items: center;
            }

            .card {
                max-width: 100%; /* Adjusted to full width on mobile */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                text-align: justify;
                padding: 10px;
                margin-bottom: 10px; /* Added margin between cards */
            }

            .card button {
                margin-top: 10px;
            }
        }
    </style>
<body>
    <header>
        <!-- Button to toggle the sidebar -->
        <button id="toggleSidebarButton" class="toggle-button"><i class="fas fa-bars"></i></button>
        <center><table>
            <tr>
                <td>
                    <img src="../pictures/IT.png" style="width: auto; height: auto; max-width: 95px; max-height: 95px;">
                </td>
                <td>
                    <h1>SportStock Admin Dashboard</h1>
                </td>
                <td>
                    <img src="../pictures/logos.png" style="width: auto; height: auto; max-width: 125px; max-height: 125px;">
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
        <a id="home-button" class="active" style=" border-top: 4px solid #80522F;"><i class="fas fa-home"></i> Home</a>
        <a id="equipment-button"><i class="fas fa-dumbbell"></i> Manage Equipment</a>
        <a id="user-button"><i class="fas fa-users"></i> User Management</a>
        <a id="borrowing-button"><i class="fas fa-chart-bar"></i> Borrowing Records</a>
        <a id="settings-button"><i class="fas fa-running"></i> Activity Log</a>
        <a id="logout-button"><i class="fas fa-sign-out-alt"></i> Log Out</a>
        <button id="closeSidebarButton" class="close-button"><i class="fas fa-times"></i></button>
    </div>
    <main class="main-content">
        <!-- Start of Home Content -->
        <div class="modal-container" id="home-modal">
            <div class="modal-content">
                <h2>Welcome to SportStock Admin Dashboard</h2>
                <p>
                    SportStock is your ultimate solution for managing sports equipment borrowing and return. <br />This user-friendly system allows you to efficiently track, organize, and manage all sports equipment, users, and borrowing records.
                </p>
                <p>
                    With SportStock, you can keep your sports equipment inventory in check, manage user profiles, and maintain detailed records of equipment borrowing and returns. <br />It's the perfect tool to streamline your sports equipment management process and enhance your overall sports facility experience.
                </p>
                <hr>
                <h3>Key Features</h3>
                <ul>
                    <li><i class="fas fa">Equipment Management:</i> Keep track of all sports equipment with ease.</li>
                    <li><i class="fas fa">User Management:</i> Manage user profiles and access permissions effortlessly.</li>
                    <li><i class="fas fa">Borrowing Records:</i> Maintain comprehensive records of equipment borrowing and returns.</li>
                    <li><i class="fas fa">Activity Log:</i> Check your activities.</li>
                </ul>
                <p>
                    SportStock is designed to make your sports facility management simpler and more organized. <br />Whether you are running a sports club, gym, or any other sports-related organization, SportStock is the right choice for you.
                </p>
            </div>
        </div>
        <!-- End of Home Content -->
        <!-- Start of Equipment Content -->
        <div class="modal-container" id="equipment-modal">
            <div class="modal-content">
                <div class="header-container"><br />
                    <h2 style="position: relative;">Equipment</h2>
                    <div class="buttons" style="position: absolute; top: 0; right: 0; padding: 10px;">
                        <button id="addE-button" class="addE-button btn-success" style="padding: 5px;">Add Equipment</button>
                    </div>
                    <div style="position: absolute; top: 0; left: 0; padding: 10px;">
                        <div class="search-container">
                            <input type="text" id="equipment-search" style="max-width: 125px;" placeholder="Search for equipment...">
                            <button id="search-button" style="background-color: green;"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="card-container">
                <!-- Equipment Table -->
                <?php
                $sqls = "SELECT * FROM Equipment";
                $results = mysqli_query($conn, $sqls);

                if (mysqli_num_rows($results) > 0) {
                    $data = mysqli_fetch_all($results, MYSQLI_ASSOC);
                    $itemsPerPage = 3; // You can adjust this value based on your design
                    $totalItems = count($data);
                    $totalPages = ceil($totalItems / $itemsPerPage);
                    $currentPage = isset($_GET['equipment_page']) ? $_GET['equipment_page'] : 1;

                    // Display data for the current page
                    $startIndex = ($currentPage - 1) * $itemsPerPage;
                    $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                    for ($i = $startIndex; $i < $endIndex; $i++) {
                        $equipment = $data[$i];
                ?>
                <div class="card equipment-card" data-ename="<?php echo strtolower($equipment['ename']); ?>">
                    <div style="width: 115px; height: 115px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <img class="img-circle" src="../pictures/equipment<?php echo $equipment['eid'];?>.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                    </div><br />
                    <div class="card-content">
                        <div class="label-data-pair">
                            <label>Equipment ID:</label> <?php echo $equipment['eid']; ?>
                        </div>
                        <div class="label-data-pair">
                            <label>Equipment Name:</label> <?php echo $equipment['ename']; ?>
                        </div>
                        <div class="label-data-pair">
                            <label>Sports Category:</label> <?php echo $equipment['category']; ?>
                        </div>
                        <div class="label-data-pair">
                            <label>Quantity:</label> <?php echo $equipment['quantity']; ?>
                        </div>
                        <div class="label-data-pair">
                            <label>Condition:</label> <?php echo $equipment['quality']; ?>
                        </div>
                        <div class="label-data-pair">
                            <label>Last Maintenance:</label> <?php echo $equipment['last_maintenance_date']; ?>
                        </div>
                    </div><br /><br />
                    <div style="position: absolute; bottom: 0; right: 0; padding: 10px;">
                        <button type="button" class="edit-button btn-success" data-eid="<?php echo $equipment['eid']; ?>" data-ename="<?php echo $equipment['ename']; ?>" data-category="<?php echo $equipment['category']; ?>" data-quantity="<?php echo $equipment['quantity']; ?>" data-condition="<?php echo $equipment['quality']; ?>" data-maintenance="<?php echo $equipment['last_maintenance_date']; ?>" onclick="showEditModal(this)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="delete-button btn-danger" onclick="showDeleteModal('<?php echo $equipment['eid']; ?>', '<?php echo $equipment['ename']; ?>')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                </div>
                <?php
                    }
                ?>
                </div><br/><br/>
                <div class="pagination">
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
                </div>
                <?php
                } else {
                    echo "No equipment found";
                }
                ?>
            </div>
        </div>
        <!-- End of Equipment Content -->
        <!-- Start of Add Equipment Modal -->
        <div id="AddEModal" class="modal-containers">
            <span class="close" id="closeAddEModal">&times;</span>
            <h2>Add Equipment</h2>
            <!-- Form for adding equipment -->
            <form id="AddEForm" method="post" action="../process/add-equipment.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for='eName'>Equipment Name:</label>
                    <input type='text' id='eName' name='eName' required>
                </div>
                <div class="form-group">
                    <label for='category'>Sports Category:</label>
                    <input type='text' id='category' name='category' required>
                </div>
                <div class="form-group">
                    <label for='quantity'>Quantity:</label>
                    <input type='number' id='quantity' name='quantity' min=1 required>
                </div>
                <div class="form-group">
                    <label for='condition'>Condition:</label>
                    <input type='text' id='condition' name='condition'>
                </div>
                <div class="form-group">
                    <label for='maintenance'>Last Maintenance:</label>
                    <input type='date' id='maintenance' name='maintenance'>
                </div>
                <div class="form-group">
                    <label for='file'>Upload Photo:</label>
                    <input type="file" name="file">
                </div><br/>
                <button type="reset" class="reset-user-button btn-danger" style="position: absolute; bottom: 8px; padding: 5px; right: 70px;">
                    <i class="fas fa-undo"></i> Reset
                <button class="btn btn-success" name="add" style="position: absolute; bottom: 10px; right: 10px;">Add</button>
            </form>
        </div>
        <!-- End of Add Equipment Modal -->
        <!-- Start of Edit Equipment Modal -->
        <div id="EditEModal" class="modal-containers" style="display: none;">
            <span class="close" id="closeEditEModal">&times;</span>
            <h2>Edit Equipment</h2>
            <!-- Form for editing equipment -->
            <form id="EditEForm" method="post" action="../process/edit-equipment.php">
                <input type="hidden" id="editEid" name="editEid">
                <div class="form-group">
                    <label for="editEName">Equipment Name:</label>
                    <input type="text" id="editEName" name="editEName" required>
                </div>
                <div class="form-group">
                    <label for="editCategory">Sports Category:</label>
                    <input type="text" id="editCategory" name="editCategory" required>
                </div>
                <div class="form-group">
                    <label for="editQuantity">Quantity:</label>
                    <input type="number" id="editQuantity" name="editQuantity" min="1" required>
                </div>
                <div class="form-group">
                    <label for="editCondition">Condition:</label>
                    <input type="text" id="editCondition" name="editCondition">
                </div>
                <div class="form-group">
                    <label for="editMaintenance">Last Maintenance:</label>
                    <input type="date" id="editMaintenance" name="editMaintenance">
                </div>
                <br />
                <button type="button" class="btn btn-success update-yes" onclick="updateEquipment()" style="position: absolute; bottom: 10px; right: 10px;">Update</button>
            </form>
        </div>
        <!-- End of Edit Equipment Modal -->
        <!-- Start of Delete Equipment Modal -->
        <div id="delEModal" class="modal-containers" style="display: none;">
            <h2>Delete Equipment</h2>
            <form id="DeleteForm" method="post">
                <input type="hidden" id="delEid" name="eid" value="">
                <input type="hidden" id="delEAction" name="action" value="delete"> <!-- Updated action value -->

                <h2 id="delEquipmentName"></h2><br />
                <div style="display: flex; justify-content: space-between; position: absolute; bottom: 10px; right: 10px;">
                    <button type="button" class="btn btn-danger delete-yes" onclick="deleteEquipment()" style="margin-right: 5px;">Yes</button>
                    <button type="button" class="btn btn-success delete-no" onclick="closeDelEModal()">No</button>
                </div>
            </form>
        </div>
        <!-- End of Delete Equipment Modal -->
        <!-- Start of User Content -->
        <div class="modal-container" id="user-modal">
            <div class="modal-content">
                <div class="header-container"><br />
                    <h2 style="position: relative;">User Accounts</h2>
                    <div class="buttons" style="position: absolute; top: 10px; right: 10px;">
                        <button id="addN-button" class="addN-button btn-success" style="padding: 5px;">Add New User</button>
                        <button id="request-button" class="request-button btn-success" style="padding: 5px;">Registration Requests</button>
                    </div>
                    <div class="search" style="position: absolute; top: 0; left: 0; padding: 10px;">
                        <div class="search-container">
                            <input type="text" id="user-search" style="max-width: 125px;" placeholder="Search for users...">
                            <button id="search-button" style="background-color: green;"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div id="no-results-message" style="display: none; text-align: center; margin-top: 20px;">
                    <p>No search results found</p>
                </div>
                <div class="card-container">
                    <?php
                        $role = "user";
                        $sql = "SELECT * FROM Users WHERE role='$role'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            $itemsPerPage = 3; // You can adjust this value based on your design
                            $totalItems = count($data);
                            $totalPages = ceil($totalItems / $itemsPerPage);
                            $currentPage = isset($_GET['user_page']) ? $_GET['user_page'] : 1;

                            // Display data for the current page
                            $startIndex = ($currentPage - 1) * $itemsPerPage;
                            $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                            for ($i = $startIndex; $i < $endIndex; $i++) {
                                $user = $data[$i];
                                $usersDisplayed = true;
                    ?>
                    <div class="card profile-card" data-uname="<?php echo strtolower($user['name']); ?>">
                    <div style="width: 115px; height: 115px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                        <div style="position: relative; width: 100%; height: 100%;">
                            <img class="img-circle" src="../pictures/profile<?php echo $user['id'];?>.jpg" style="width: 100%; height: 100%; object-fit: cover;">
                            <button type="button" class="view-userA-button btn-success" data-userid="<?php echo $user['id']; ?>" style="position: absolute; bottom: 0; right: 0; border-radius: 50%; background-color: transparent;">
                                <i class="fas fa-eye" style="color: green;"></i>
                            </button>
                        </div>
                    </div><br />
                        <div class="card-content">
                            <input type="hidden" id="viewUid" value="<?php echo $user['user_id']; ?>">
                            <div class="label-data-pair">
                                <label>User ID:</label> <?php echo $user['user_id']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Name:</label> <?php echo $user['name']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Username:</label> <?php echo $user['username']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Course & Year Level:</label> <?php echo $user['course']; ?>
                            </div>
                        </div><br /><br />
                        <center>
                            <div style="position: absolute; bottom: 0; right: 0; padding: 10px;">
                                <button class="edit-user-button btn-success editInfoButton" data-user='<?php echo json_encode($user); ?>' style="margin-right: 5px;">
                                    <i class="fas fa-info-circle"></i> Edit info
                                </button>
                                <button type="button" class="delete-user-button btn-danger" onclick="showDeleteUserModal('<?php echo $user['id']; ?>', '<?php echo $user['username']; ?>')" style="float: right;">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </div>
                        </center>
                    </div>
                    <?php
                        }
                    ?>
                </div><br/><br/>
                <div class="pagination">
                    <?php
                        // Display three buttons at a time
                        $startPage = max(1, $currentPage - 1);
                        $endPage = min($totalPages, $currentPage + 1);

                        // Display previous button
                        if ($currentPage > 1) {
                            echo "<li><a href='?user_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                        }

                        // Pagination links
                        for ($page = $startPage; $page <= $endPage; $page++) {
                            echo "<li" . ($page == $currentPage ? ' class="active"' : '') . "><a href='?user_page=$page'>$page</a></li>";
                        }

                        // Display next button
                        if ($currentPage < $totalPages) {
                            echo "<li><a href='?user_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                        }
                    ?>
                </div>
                <?php
                        if (!$usersDisplayed) {
                            echo '<script>document.getElementById("no-results-message").style.display = "block";</script>';
                        }
                    } else {
                        echo "No users found";
                    }
                ?>
            </div>
        </div>
        <!-- End of User Content -->
        <!-- Start of View User Activity Modal -->
        <div id="viewUAModal" class="modal-containers" style="display: none; max-width: 300px; height: 400px; overflow: auto;">
            <span class="close" id="closeViewUAModal">&times;</span>
            <h2>User Activity Log</h2>
            <!-- Log content goes here -->
            <div id="logContent" style="max-height: 80%; overflow-y: auto;"></div>
        </div>
        <!-- End of View User Activity Modal -->
        <!-- Start of Edit User Info Modal -->
        <div id="editInfoModal" class="modal-containers" style="display: none;">
            <span class="close" id="closeEditInfoModal">&times;</span>
            <h2>Edit User Information</h2>
            <form id="editInfoForm" method="post">
                <!-- Add a hidden input field for user ID -->
                <input type="hidden" id="editUserId" name="userId" value="">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="">
                </div>
                <div class="form-group">
                    <label for="course">Course & Year Level:</label>
                    <input type="text" id="course" name="course" value="">
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="">
                </div><br/>
                <button type="button" id="updateButton" class="updateButton" style="position: absolute; bottom: 10px; right: 10px;">Update</button>
            </form>
        </div>
        <!-- End of Edit User Info Modal -->
        <!-- Start of Delete User Modal -->
        <div id="DeleteUserModal" class="modal-containers" style="display: none;">
            <h2>Delete User Account</h2>
            <form id="DeleteUserForm" method="post">
                <input type="hidden" id="delUid" name="eid" value="">
                <input type="hidden" id="delUAction" name="action" value="delete"> <!-- Updated action value -->

                <h2 id="DeleteUsername"></h2><br />
                <div style="display: flex; justify-content: space-between; position: absolute; bottom: 10px; right: 10px;">
                    <button type="button" class="btn btn-danger deleteU-yes" onclick="deleteUser()" style="margin-right: 5px;">Yes</button>
                    <button type="button" class="btn btn-success deleteU-no" onclick="closeDeleteUserModal()">No</button>
                </div>
            </form>
        </div>
        <!-- End of Delete User Modal -->
        <!-- Start of Add User Modal -->
        <div id="AddNModal" class="modal-containers">
            <span class="close" id="closeAddNModal">&times;</span>
            <h2>Create New User Account</h2>
            <!-- Form for adding User -->
            <form id="AddNForm" method="post" action="../process/add-user.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for='name'>Name:</label>
                    <input type='text' id='name' name='name'>
                </div>
                <div class="form-group">
                    <label for='course'>Course:</label>
                    <input type='text' id='course' name='course'>
                </div>
                <div class="form-group">
                <label for='id_number'>UserID:</label>
                <input type='text' id='id_number' name='id_number'>
                </div>
                <div class="form-group">
                    <label for='username'>Username:</label>
                    <input type='text' id='username' name='username' value=>
                </div>
                <div class="form-group">
                    <label for='password'>Password:</label>
                    <input type='password' id='password'name='password'>
                </div>
                <div class="form-group">
                    <label for='file'>Upload Photo:</label>
                    <input type="file" name="file">
                </div><br/>
                <button type="reset" class="reset-user-button btn-danger " style="position: absolute; bottom: 8px; padding: 5px; right: 70px;">
                    <i class="fas fa-undo"></i> Reset
                <button class="btn btn-success" name="add" style="position: absolute; bottom: 10px; right: 10px;">Add</button>
            </form>
        </div>
        <!-- End of Add User Modal -->
        <!-- Start of User Request Modal -->
        <div id="RequestModal" class="modal-containers">
            <span class="close" id="closeRequestModal">&times;</span>
            <h2>Registration Requests</h2>
            <!-- Form for adding User -->
            <form id="RequestForm" method="post" action="../process/registration_requests.php">
                <?php
                    include '../process/connection.php';
                    // Retrieve and display pending registration requests
                    $sql = "SELECT * FROM pending_registrations WHERE status='pending'";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        echo '<form method="post">';
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Display registration data for approval
                            $name = $row['name'];
                            $course = $row['course'];
                            $username = $row['username'];
                            
                            echo "<center><br>Name: $name<br>";
                            echo "Course: $course<br>";
                            echo "Username: $username<br>";

                            // Add hidden input fields to pass data to the form
                            echo "<input type='hidden' name='name' value='$name'>";
                            echo "<input type='hidden' name='course' value='$course'>";
                            echo "<input type='hidden' name='id_number' value='{$row['id_number']}'>";
                            echo "<input type='hidden' name='username' value='$username'>";
                            echo "<input type='hidden' name='password' value='{$row['password']}'>";

                            // Add Accept and Deny buttons
                            echo '<div class="float-right" style="position: absolute; bottom: 10px; right: 10px;"><button class="btn btn-success" type="submit" name="accept" style="margin-right: 5px;">Accept</button>';
                            echo '<button class="btn btn-danger" type="submit" name="deny">Deny</button></div>';
                            echo '<br/><br/></center>';
                            echo '<hr>';
                        }
                        echo '</form>';
                    } else {
                        echo "<center>No pending registration requests.</center>";
                    }
                ?>
            </form>
        </div>
        <!-- End of User Request Modal -->
        <!-- Start of Borrowing Content -->
        <div class="modal-container" id="borrowing-modal">
            <div class="modal-content">
                <h2 style="position: relative;">Borrowing History</h2>
                <div class="float-right" style="position: absolute; top: 0; right: 0; padding: 10px;">
                    <button id="borrowing-button" class="borrowing-button btn-success" style="padding: 5px;">Borrow Equipment</button>
                </div><br />
                <div class="card-container" id="borrowing-card-container">
                    <!-- Borrowing Cards -->
                    <?php
                    // Query to retrieve all records
                    $allRecordsQuery = "SELECT borrowing.*, equipment.ename AS equipment_name, users.name AS user_name FROM borrowing LEFT JOIN equipment ON borrowing.equipment_id = equipment.eid LEFT JOIN users ON borrowing.user_id = users.user_id ORDER BY borrowing.date_returned DESC";
                    $allRecordsResult = mysqli_query($conn, $allRecordsQuery);
                    $allRecords = mysqli_fetch_all($allRecordsResult, MYSQLI_ASSOC);

                    // Determine the current page
                    $currentPage = isset($_GET['borrowing_page']) ? $_GET['borrowing_page'] : 1;

                    // Set the number of records per page
                    $recordsPerPage = 3;

                    // Calculate the starting point for the results
                    $startIndex = ($currentPage - 1) * $recordsPerPage;

                    // Display data for the current page
                    for ($i = $startIndex; $i < min($startIndex + $recordsPerPage, count($allRecords)); $i++) {
                        $row = $allRecords[$i];
                    ?>
                        <div class="card borrowing-card" style="padding-right: 2%;">
                            <div class="card-content">
                            <div class="label-data-pair">
                                <label>Record ID:</label> <?php echo $row['id']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Equipment Name:</label> <?php echo $row['equipment_name']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Quantity:</label> <?php echo $row['quantity']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Equipment ID:</label> <?php echo $row['equipment_id']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Borrower's Name:</label> <?php echo $row['user_name']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Status:</label> <?php echo $row['status']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Date Borrowed:</label> <?php echo $row['borrow_date']; ?>
                            </div>
                            <div class="label-data-pair">
                                <label>Return Date:</label> <?php echo $row['return_date']; ?>
                            </div>
                            <?php
                            $rdate = $row['date_returned'];
                            if($rdate !== NULL){
                            echo'<div class="label-data-pair">
                                    <label>Date Returned:</label>'.$rdate.'
                                </div>';
                            }?>
                        </div>
                    </div>
                    <?php } ?>
                </div><br /><br />
                <div class="pagination" id="borrowing-pagination">
                    <?php
                    // Calculate total pages
                    $totalPages = ceil(count($allRecords) / $recordsPerPage);

                    // Display previous button
                    if ($currentPage > 1) {
                        echo "<li><a href='?borrowing_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                    }

                    // Display pagination buttons
                    $startPage = max(1, $currentPage - 1);
                    $endPage = min($totalPages, $startPage + 2);

                    for ($page = $startPage; $page <= $endPage; $page++) {
                        if ($page == $currentPage) {
                            echo "<li class='active'><span>$page</span></li>";
                        } else {
                            echo "<li><a href='?borrowing_page=$page'>$page</a></li>";
                        }
                    }

                    // Display next button
                    if ($currentPage < $totalPages) {
                        echo "<li><a href='?borrowing_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- End of Borrowing Content -->
        <!-- Start of Borrowing Modal -->
        <div id="BorrowingModal" class="modal-containers">
            <span class="close" id="closeBorrowingModal">&times;</span><br />
            <h2>Borrow Equipment</h2>
            <br />
            <!-- Form for Borrowing Equipment -->
            <form id="BorrowingForm" method="post" action="../process/borrow-equipment.php">
                <div class="form-group">
                    <label for='eID'>Equipment ID:</label>
                    <input type='text' id='eID' name='eID' required>
                </div>

                <div class="form-group">
                    <label for='quantity'>Quantity:</label>
                    <input type='number' id='quantity' name='quantity' min=1 required>
                </div>

                <div class="form-group">
                    <label for='bname'>Borrower's User ID:</label>
                    <input type='text' id='bname' name='bname'>
                </div>

                <div class="form-group">
                    <label for='rdate'>Return Date:</label>
                    <input type='date' id='rdate' name='rdate'>
                </div>

                <button class="btn btn-success" name="borrow">Borrow</button>
            </form>
        </div>
        <!-- End of Borrowing Modal -->
        <!-- Start of Activity Log Content -->
        <div class="modal-container" id="settings-modal">
            <div class="modal-content">
                <!-- Log content goes here -->
                <div class="card-container" style="display: flex; justify-content: space-around; gap: 10px;">
                    <!-- First Card - Administrator Log -->
                    <div class="card log-card" style="flex-basis: 48%; box-sizing: border-box;">
                        <h2>Administrator Log</h2>
                        <?php
                        $sql = "SELECT * FROM log WHERE user_id='$uid' ORDER BY timestamp DESC";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            $itemsPerPage = 5; // Display 5 data items per page
                            $totalItems = count($data);
                            $totalPages = ceil($totalItems / $itemsPerPage);
                            $currentPage = isset($_GET['log_page']) ? $_GET['log_page'] : 1;

                            // Display data for the current page
                            $startIndex = ($currentPage - 1) * $itemsPerPage;
                            $endIndex = min($startIndex + $itemsPerPage, $totalItems);

                            for ($i = $startIndex; $i < $endIndex; $i++) {
                                $row = $data[$i];
                                echo '<div style="display: flex; align-items: center; justify-content: space-between;"><img class="img-circle" src="../pictures/profile' . $uid. '.jpg" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"><p>Administrator</p><center>';
                                echo $row['activity'];
                                echo '<br />';
                                echo $row['timestamp'];
                                echo '</center></div><hr />';
                            }
                        }
                        ?><br />
                        <!-- Pagination for the first card -->
                        <div class="pagination" style="text-align: right; margin-top: 10px;">
                            <?php
                            // Display previous button
                            if ($currentPage > 1) {
                                echo "<li><a href='?log_page=" . ($currentPage - 1) . "'>&laquo;</a></li>";
                            }

                            // Display pagination buttons
                            $startPage = max(1, $currentPage - 1);
                            $endPage = min($totalPages, $startPage + 2);

                            for ($page = $startPage; $page <= $endPage; $page++) {
                                if ($page == $currentPage) {
                                    echo "<li class='active'><span>$page</span></li>";
                                } else {
                                    echo "<li><a href='?log_page=$page'>$page</a></li>";
                                }
                            }

                            // Display next button
                            if ($currentPage < $totalPages) {
                                echo "<li><a href='?log_page=" . ($currentPage + 1) . "'>&raquo;</a></li>";
                            }
                            ?>
                        </div>
                    </div>
                    <!-- Second Card - All Log Data -->
                    <div class="card log-card" style="flex-basis: 48%; box-sizing: border-box;">
                        <h2>All Activity Log Data</h2>
                        <?php
                        $sqls = "SELECT log.*, users.username AS user_name FROM log LEFT JOIN users ON log.user_id = users.id ORDER BY log.timestamp DESC";
                        $results = mysqli_query($conn, $sqls);

                        if (mysqli_num_rows($results) > 0) {
                            $dataAll = mysqli_fetch_all($results, MYSQLI_ASSOC);
                            $totalItemsAll = count($dataAll);
                            $totalPagesAll = ceil($totalItemsAll / $itemsPerPage);
                            $currentPageAll = isset($_GET['all_log_page']) ? $_GET['all_log_page'] : 1;

                            // Display data for the current page for the second card
                            $startIndexAll = ($currentPageAll - 1) * $itemsPerPage;
                            $endIndexAll = min($startIndexAll + $itemsPerPage, $totalItemsAll);

                            for ($i = $startIndexAll; $i < $endIndexAll; $i++) {
                                $rowAll = $dataAll[$i];
                                echo '<div style="display: flex; align-items: center; justify-content: space-between;"><img class="img-circle" src="../pictures/profile' . $rowAll['user_id'] . '.jpg" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"><p>' . $rowAll['user_name'] . '</p>';
                                echo $rowAll['activity'];
                                echo '<br />';
                                echo $rowAll['timestamp'];
                                echo '</center></div><hr />';
                            }
                        }
                        ?><br />
                        <!-- Pagination for the second card -->
                        <div class="pagination" style="text-align: right; margin-top: 10px;">
                            <?php
                            // Display previous button for the second card
                            if ($currentPageAll > 1) {
                                echo "<li><a href='?all_log_page=" . ($currentPageAll - 1) . "'>&laquo;</a></li>";
                            }

                            // Display pagination buttons for the second card
                            $startPageAll = max(1, $currentPageAll - 1);
                            $endPageAll = min($totalPagesAll, $startPageAll + 2);

                            for ($page = $startPageAll; $page <= $endPageAll; $page++) {
                                if ($page == $currentPageAll) {
                                    echo "<li class='active'><span>$page</span></li>";
                                } else {
                                    echo "<li><a href='?all_log_page=$page'>$page</a></li>";
                                }
                            }

                            // Display next button for the second card
                            if ($currentPageAll < $totalPagesAll) {
                                echo "<li><a href='?all_log_page=" . ($currentPageAll + 1) . "'>&raquo;</a></li>";
                            }
                            ?>
                        </div>
                    </div>
                </div><br />
            </div>
        </div>
        <!-- End of Activity Log Content -->
        <!-- Start of Logout Content -->
        <div class="modal-container" id="logout-modal">
            <div class="modal-content">
                <!-- Logout Modal Content -->
                <div class="card-container">
                    <div class="card profile-card">
                        <center><br />
                            <h4 style="position: relative;">Are you sure you want to log out?</h4><br /><br /><br />
                                <div class="button-container" style="position: absolute; bottom: 10px; right: 10px;">
                                    <button id="logout-confirm-button" class="modal-button action-button" onclick="confirmLogout()">Yes</button>
                                    <button id="logout-cancel-button" class="modal-button action-button" onclick="confirmLogout()">No</button>
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
        <p>&copy; 2023 SportStock System: ADS | Made by: Group2 @ AY: 2023-2024</p>
    </footer>
    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/popper.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../scripts/admin-modal-scripts.js"></script>
    <script src="../scripts/admin-scripts.js"></script>
    <script src="../scripts/admin-sidebar-scripts.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                        noResultsDiv.innerHTML = "<p>No Search results found</p>";
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const AddEButtons = document.querySelectorAll('.addE-button');
            const closeAddEModal = document.getElementById("closeAddEModal");
            const AddEModal = document.getElementById("AddEModal");

            function showAddEModal() {
                AddEModal.style.display = "block";
            }

            function hideAddEModal() {
                AddEModal.style.display = "none";
            }

            window.addEventListener("click", function (event) {
                if (event.target === AddEModal) {
                    hideAddEModal();
                }
            });

            document.addEventListener("keyup", function (event) {
                if (event.key === "Escape") {
                    hideAddEModal();
                }
            });

            closeAddEModal.addEventListener("click", function () {
                hideAddEModal();
            });

            AddEButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    showAddEModal();
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const EditEModal = document.getElementById("EditEModal");
            const editButtons = document.querySelectorAll(".edit-button");
            const updateYesButton = document.querySelector(".update-yes");
            const closeEditEModalButton = document.getElementById("closeEditEModal");

            const editEidElement = document.getElementById("editEid");
            const eNameElement = document.getElementById("editEName");
            const categoryElement = document.getElementById("editCategory");
            const quantityElement = document.getElementById("editQuantity");
            const conditionElement = document.getElementById("editCondition");
            const maintenanceElement = document.getElementById("editMaintenance");

            function showEditModal(button) {
                const eid = button.dataset.eid;
                const ename = button.dataset.ename;
                const category = button.dataset.category;
                const quantity = button.dataset.quantity;
                const condition = button.dataset.condition;
                const maintenance = button.dataset.maintenance;

                editEidElement.value = eid;
                eNameElement.value = ename;
                categoryElement.value = category;
                quantityElement.value = quantity;
                conditionElement.value = condition;
                maintenanceElement.value = maintenance;
                EditEModal.style.display = "block";
            }

            function closeEditEModal() {
                EditEModal.style.display = "none";
            }

            function updateEquipment() {
                const eid = editEidElement.value;
                const ename = eNameElement.value;
                const category = categoryElement.value;
                const quantity = quantityElement.value;
                const condition = conditionElement.value;
                const maintenance = maintenanceElement.value;

                const formData = new FormData();
                formData.append("eid", eid);
                formData.append("eName", ename);
                formData.append("category", category);
                formData.append("quantity", quantity);
                formData.append("condition", condition);
                formData.append("maintenance", maintenance);
                formData.append("edit", true);

                fetch("../process/edit-equipment.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        console.log("Equipment update successful!");
                        EditEModal.style.display = "none";
                        setTimeout(function () {
                            window.location.href = "admin.php?toasterMessage=Equipment:%20Updated%20Successfully";
                        }, 500);
                    } else {
                        console.error("Error updating equipment: ", data.message);
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                });
            }

            // Event listeners for EditEModal
            updateYesButton.addEventListener("click", function () {
                updateEquipment();
            });

            closeEditEModalButton.addEventListener("click", function () {
                closeEditEModal();
            });

            window.addEventListener("click", function (event) {
                if (event.target === EditEModal) {
                    closeEditEModal();
                }
            });

            document.addEventListener("keyup", function (event) {
                if (event.key === "Escape") {
                    closeEditEModal();
                }
            });

            // Event listeners for Edit buttons
            editButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    showEditModal(button);
                });
            });
        });
    </script>
    <script>
        const delEModal = document.getElementById("delEModal");
        const deleteButtons = document.querySelectorAll(".delete-button");
        const deleteYesButton = document.querySelector(".delete-yes");
        const deleteNoButton = document.querySelector(".delete-no");
        const delEquipmentNameElement = document.getElementById("delEquipmentName");
        const delEidElement = document.getElementById("delEid");

        function showDeleteModal(eid, equipmentName) {
            delEModal.style.display = "block";
            delEidElement.value = eid;
            delEquipmentNameElement.innerText = equipmentName;
        }

        function closeDelEModal() {
            delEModal.style.display = "none";
        }

        function deleteEquipment() {
            const eid = delEidElement.value;
            const action = "delete";
            const formData = new FormData();
            formData.append("eid", eid);
            formData.append("action", action);

            fetch("../process/delete-equipment.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("Equipment deletion successful!");
                delEModal.style.display = "none";
                setTimeout(function() {
                    window.location.href = "admin.php?toasterMessage=Equipment:%20Deleted%20Successfully";
                }, 500);
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const AddNButtons = document.querySelectorAll('.addN-button');
            const closeAddNModal = document.getElementById("closeAddNModal");
            const AddNModal = document.getElementById("AddNModal");

            function showAddNModal() {
                AddNModal.style.display = "block";
            }

            function hideAddNModal() {
                AddNModal.style.display = "none";
            }

            window.addEventListener("click", function (event) {
                if (event.target === AddNModal) {
                    hideAddNModal();
                }
            });

            document.addEventListener("keyup", function (event) {
                if (event.key === "Escape") {
                    hideAddNModal();
                }
            });

            closeAddNModal.addEventListener("click", function () {
                hideAddNModal();
            });

            AddNButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    showAddNModal();
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const RequestsButtons = document.querySelectorAll('.request-button');
            const closeRequestModal = document.getElementById("closeRequestModal");
            const RequestModal = document.getElementById("RequestModal");

            function showRequestModal() {
                RequestModal.style.display = "block";
            }

            function hideRequestModal() {
                RequestModal.style.display = "none";
            }

            window.addEventListener("click", function (event) {
                if (event.target === RequestModal) {
                    hideRequestModal();
                }
            });

            document.addEventListener("keyup", function (event) {
                if (event.key === "Escape") {
                    hideRequestModal();
                }
            });

            closeRequestModal.addEventListener("click", function () {
                hideRequestModal();
            });

            RequestsButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    showRequestModal();
                });
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const viewUAButtons = document.querySelectorAll(".view-userA-button");
            const viewUAModal = document.getElementById("viewUAModal");
            const closeViewUAModal = document.getElementById("closeViewUAModal");

            function showViewUAModal(userId) {
                document.getElementById("viewUid").value = userId;
                fetchUserLogs(userId);
                viewUAModal.style.display = "block";
            }

            function hideViewUAModal() {
                viewUAModal.style.display = "none";
            }

            closeViewUAModal.addEventListener("click", hideViewUAModal);

            window.addEventListener("click", function (event) {
                if (event.target === viewUAModal) {
                    hideViewUAModal();
                }
            });

            viewUAButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    const userId = button.getAttribute("data-userid");
                    document.getElementById("viewUid").value = userId;
                    showViewUAModal(userId);
                });
            });

            function fetchUserLogs(userId) {
                fetch(`../process/fetch-user-logs.php?userId=${userId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayLogs(data.logs, userId);
                        } else {
                            console.error("Failed to fetch user logs");
                        }
                    })
                    .catch(error => {
                        console.error("Error: " + error.message);
                    });
            }

            function displayLogs(logs, userId) {
                const logContent = document.getElementById("logContent");
                logContent.innerHTML = "";

                if (logs.length > 0) {
                    logs.forEach(log => {
                        const logEntry = document.createElement("div");
                        logEntry.innerHTML = `<div style="display: flex; justify-content: space-between;"><img class="img-circle" src="../pictures/profile${userId}.jpg" style="max-width: 50px; max-height: 50px; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"><center>${log.activity}<br />${log.timestamp}</center></div><hr />`;
                        logContent.appendChild(logEntry);
                    });
                } else {
                    logContent.innerHTML = "No logs found";
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Get all editInfoButtons and editInfoModals
            const editInfoButtons = document.querySelectorAll(".editInfoButton");
            const editInfoModal = document.getElementById("editInfoModal");
            const editInfoForm = document.getElementById("editInfoForm");
            const updateButton = document.getElementById("updateButton");

            // Show the "Edit Info" modal when a button is clicked
            editInfoButtons.forEach(editInfoButton => {
                editInfoButton.addEventListener("click", () => {
                    editInfoModal.style.display = "block";
                    const userData = JSON.parse(editInfoButton.getAttribute("data-user"));

                    // Set the user ID in the hidden input field
                    editInfoModal.querySelector("#editUserId").value = userData.id;

                    // Populate the modal fields with the user data
                    editInfoModal.querySelector("#name").value = userData.name;
                    editInfoModal.querySelector("#course").value = userData.course;
                    editInfoModal.querySelector("#username").value = userData.username;
                });
            });

            // Close the "Edit Info" modal when clicking outside or pressing 'Esc' key
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

            // AJAX function for form submission
            updateButton.addEventListener("click", () => {
                // Manually trigger the form submission
                editInfoForm.dispatchEvent(new Event("submit"));
            });

            editInfoForm.addEventListener("submit", (event) => {
                event.preventDefault();

                // Serialize the form data into a URL-encoded string
                const formData = new URLSearchParams(new FormData(editInfoForm));

                // Send an AJAX request using the Fetch API
                fetch("../process/edit-user-info.php", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    } else {
                        throw new Error("Request failed.");
                    }
                })
                .then(data => {
                    if (data.success) {
                        console.log("Update successful!");
                        editInfoModal.style.display = "none";
                        setTimeout(function() {
                            window.location.href = "admin.php?toasterMessage=User%20Information%20Updated%20Successfully!";
                        }, 500);
                    } else {
                        console.error("Update failed.");
                    }
                })
                .catch(error => {
                    console.error("Error: " + error.message);
                });
            });
        });
    </script>
    <script>
        const DeleteUserModal = document.getElementById("DeleteUserModal");
        const DeleteUserButtons = document.querySelectorAll(".delete-user-button");
        const DeleteUserYesButton = document.querySelector(".deleteU-yes");
        const DeleteUserNoButton = document.querySelector(".deleteU-no");
        const DeleteUsernameElement = document.getElementById("DeleteUsername");
        const DeleteUidElement = document.getElementById("delUid");

        function showDeleteUserModal(uid, username) {
            DeleteUserModal.style.display = "block";
            DeleteUidElement.value = uid;
            DeleteUsernameElement.innerText = username;
        }

        function closeDeleteUserModal() {
            DeleteUserModal.style.display = "none";
        }

        function deleteUser() {
            const uid = DeleteUidElement.value;
            const action = "delete";
            const formData = new FormData();
            formData.append("uid", uid);
            formData.append("action", action);

            fetch("../process/delete-user.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log("User deletion successful!");
                DeleteUserModal.style.display = "none";
                setTimeout(function() {
                    window.location.href = "admin.php?toasterMessage=User%20Account%20Deleted%20Successfully";
                }, 500);
            })
            .catch(error => {
                console.error("Error:", error);
            });
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById("user-search");

            searchInput.addEventListener("input", function () {
                const searchTerm = searchInput.value.toLowerCase();

                // Show all profile cards
                const allCards = document.querySelectorAll('.profile-card');
                allCards.forEach(card => {
                    card.style.display = 'block';
                });

                // Show only the cards that match the search term
                if (searchTerm) {
                    const nonMatchingCards = document.querySelectorAll(`.profile-card:not([data-uname*="${searchTerm}"])`);
                    nonMatchingCards.forEach(card => {
                        card.style.display = 'none';
                    });
                }

                // Check if no results are found
                const noResultsMessage = document.getElementById("no-results-message");
                if (document.querySelectorAll('.profile-card:not([style="display: none;"])').length === 0) {
                    if (noResultsMessage) {
                        noResultsMessage.style.display = 'block';
                    } else {
                        // Create and append a "No Search Results" message
                        const noResultsDiv = document.createElement("div");
                        noResultsDiv.id = "no-results-message";
                        noResultsDiv.innerHTML = "<p>No Search results found</p>";
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
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const BorrowingButtons = document.querySelectorAll('.borrowing-button');
            const closeBorrowingModal = document.getElementById("closeBorrowingModal");
            const BorrowingModal = document.getElementById("BorrowingModal");

            function showBorrowingModal() {
                BorrowingModal.style.display = "block";
            }

            function hideBorrowingModal() {
                BorrowingModal.style.display = "none";
            }

            window.addEventListener("click", function (event) {
                if (event.target === BorrowingModal) {
                    hideBorrowingModal();
                }
            });

            document.addEventListener("keyup", function (event) {
                if (event.key === "Escape") {
                    hideBorrowingModal();
                }
            });

            closeBorrowingModal.addEventListener("click", function () {
                hideBorrowingModal();
            });

            BorrowingButtons.forEach(function (button) {
                button.addEventListener("click", function () {
                    showBorrowingModal();
                });
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
    </script>
    <script>
        function switchToMobileStyles() {
            const styleSwitch = document.getElementById('styleSwitch');
            const newStyle = `
                /* Media query for mobile responsiveness */
                @media screen and (max-width: 768px) {
                    /* Sidebar styles */
                    .sidebar {
                        /* Existing styles for closed sidebar */
                        border: 4px solid #80522F;
                        height: auto;
                        min-height: 100vh;
                        width: 225px;
                        position: fixed;
                        top: 0;
                        left: -250px;
                        background: #f2f2f2;
                        color: #795548;
                        padding-top: 50px;
                        transition: padding 0.3s ease; /* Transition for padding */

                        /* New styles for open sidebar */
                    }

                    /* Add styles for open sidebar */
                    .sidebar.opened {
                        padding-top: 100px; /* Example: Increased padding when sidebar is open */
                        transition: none; /* Remove transition when sidebar is open */
                    }

                    /* Main content styles */
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

                    /* Updated styles for card container on mobile */
                    .card-container {
                        flex-direction: column;
                        align-items: center;
                    }

                    .card {
                        max-width: 100%; /* Adjusted to full width on mobile */
                        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
                        text-align: justify;
                        padding: 10px;
                        margin-bottom: 10px; /* Added margin between cards */
                    }

                    .card button {
                        margin-top: 10px;
                    }

                    .header-container {
                        display: block;
                        text-align: center;
                        display: flex;
                        flex-direction: column;
                    }

                    .buttons,
                    .search {
                        position: static;
                        margin-top: 10px;
                    }
                }
            `;
            styleSwitch.innerHTML = newStyle;
        }

        function adjustLayoutForMobile() {
            // Function to handle the opening/closing of the sidebar and adding/removing the 'opened' class
        }

        function checkDeviceWidth() {
            const isMobile = window.matchMedia("only screen and (max-width: 768px)").matches;
            if (isMobile) {
                switchToMobileStyles();
                adjustLayoutForMobile();
            }
        }

        // Check device width on page load
        window.onload = checkDeviceWidth;

        // Check device width when the window is resized
        window.onresize = checkDeviceWidth;
    </script>
</body>
</html>
