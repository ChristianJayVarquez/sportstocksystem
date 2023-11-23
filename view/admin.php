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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SportStock Admin Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../styles/admin-styles.css">
    <style>
        .card-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: auto; /* Adjust as needed to center vertically */
        }

        .card {
            max-width: 500px;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            text-align: justify;
            padding: 10px 8% 10px 5%; /* Adjust padding as needed */
            display: flex;
            flex-direction: column;
        }

        .card button {
            margin-top: 10px; /* Adjust as needed for spacing between buttons */
            /* Your button styles go here */
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .pagination li {
            margin: 5px;
            padding: 5px 10px;
            background-color: #22B14C;
            color: lime;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .pagination li:hover {
            background-color: #14662C;
        }

        .pagination a {
            color: #fff;
        }

        /* Common style for modals */
        .modal-containers {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 95%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent background */
        }

        /* Style for AddEModal */
        #AddEModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            max-height: 60vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
        }

        #AddEModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #AddEForm {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 0 0 48%; /* Adjust the width as needed */
            margin: 1%;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #AddEForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #AddEForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #closeAddEModal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #closeAddEModal:hover {
            color: #000;
        }
        
        /* Style for EditEModal */
        #EditEModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
        }

        #EditEModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #EditEForm {
            display: flex;
            flex-direction: column;
        }

        #EditEForm label {
            margin-top: 10px;
        }

        #EditEForm input {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #EditEForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #EditEForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #closeEditEModal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #closeEditEModal:hover {
            color: #000;
        }

        /* Style for delEModal */
        #delEModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 250px;
            height: 30vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            padding: 20px;
            z-index: 2;
        }

        #delEModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #DeleteForm {
            display: flex;
            flex-direction: column;
        }

        #delEModal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #delEModal .close:hover {
            color: #000;
        }

        /* Style for viewUAModal */
        #viewUAModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            max-height: 60vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
        }

        #viewUAModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #viewUAForm {
            display: flex;
            flex-wrap: wrap;
        }

        #closeViewUAModal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #closeViewUAModal:hover {
            color: #000;
        }

        /* Style for AddNModal */
        #AddNModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            max-height: 60vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
        }

        #AddNModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #AddNForm {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 0 0 48%; /* Adjust the width as needed */
            margin: 1%;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #AddNForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #AddNForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #closeAddNModal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #closeAddNModal:hover {
            color: #000;
        }

        /* Style for RequestModal */
        #RequestModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
        }

        #RequestModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #RequestForm {
            display: flex;
            flex-direction: column;
        }

        #RequestForm label {
            margin-top: 10px;
        }

        #RequestForm input {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #RequestForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #RequestForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #closeRequestModal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #closeRequestModal:hover {
            color: #000;
        }

        /* Style for Edit Info Modal*/
        #editInfoModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            height: 375px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            padding: 20px;
            z-index: 2;
        }

        #editInfoModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #editInfoForm {
            display: flex;
            flex-direction: column;
        }

        #editInfoForm label {
            margin-top: 10px;
        }

        #editInfoForm input {
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #editInfoForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #editInfoForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #editInfoModal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #editInfoModal .close:hover {
            color: #000;
        }

        /* Style for DeleteUserModal */
        #DeleteUserModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 250px;
            height: 30vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
            padding: 20px;
            z-index: 2;
        }

        #DeleteUserModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #DeleteUserForm {
            display: flex;
            flex-direction: column;
        }

        #DeleteUserModal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #DeleteUserModal .close:hover {
            color: #000;
        }

        /* Styles for BorrowingModal */
        #BorrowingModal {
            background-color: #fff;
            border-radius: 10px;
            max-width: 400px;
            max-height: 50vh;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            z-index: 2;
        }

        #BorrowingModal h2 {
            font-size: 20px;
            margin: 0;
        }

        #BorrowingForm {
            display: flex;
            flex-wrap: wrap;
        }

        .form-group {
            flex: 0 0 48%; /* Adjust the width as needed */
            margin: 1%;
        }

        .form-group label {
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        #BorrowingForm input[type="submit"] {
            background-color: #4CAF50; /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
        }

        #BorrowingForm input[type="submit"]:hover {
            background-color: #45a049; /* Slightly darker green */
        }

        #closeBorrowingModal {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            cursor: pointer;
        }

        #closeBorrowingModal:hover {
            color: #000;
        }
        /*Styles for the toaster notification here */
        #toaster {
            display: none;
            position: fixed;
            top: 16px;
            right: 16px;
            padding: 16px;
            max-width: 300px;
            background: linear-gradient(to bottom, #F2F2F2, #D3D3D3);
            color: black;
            border-radius: 4px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #toaster p {
            margin: 0;
        }
    </style>

</head>

<body>
    <header>
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
    <nav class="nav-container">
        <ul>
            <li class="nav-button"><a href="#" class="active" id="home-button"><i class="fas fa-home"></i> Home</a></li>
            <li class="nav-button"><a href="#" id="equipment-button"><i class="fas fa-dumbbell"></i> Equipment Management</a></li>
            <li class="nav-button"><a href="#" id="user-button"><i class="fas fa-users"></i> User Management</a></li>
            <li class="nav-button"><a href="#" id="borrowing-button"><i class="fas fa-chart-bar"></i> Borrowing Records</a></li>
            <li class="nav-button"><a href="#" id="settings-button"><i class="fas fa-running"></i> Activity Log</a></li>
            <li class="nav-button"><a href="#" id="logout-button"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
        </ul>
    </nav>

    <main>
        <!-- Content for each dashboard section goes here -->
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
                <div class="float-right">
                    <button id="addE-button" class="addE-button btn-success" style="padding: 5px;">Add Equipment</button>
                </div>
                <div class="search-container">
                    <input type="text" id="equipment-search" style="max-width: 300px" placeholder="Search for equipment...">
                    <button id="search-button" style="background-color: green;"><i class="fas fa-search"></i></button>
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
                <div class="card equipment-card">
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
                    </div>
                    <center>
                        <button type="button" class="edit-button btn-success" data-eid="<?php echo $equipment['eid']; ?>" data-ename="<?php echo $equipment['ename']; ?>" data-category="<?php echo $equipment['category']; ?>" data-quantity="<?php echo $equipment['quantity']; ?>" data-condition="<?php echo $equipment['quality']; ?>" data-maintenance="<?php echo $equipment['last_maintenance_date']; ?>" onclick="showEditModal(this)">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button type="button" class="delete-button btn-danger" onclick="showDeleteModal('<?php echo $equipment['eid']; ?>', '<?php echo $equipment['ename']; ?>')">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </center>
                </div>
                <?php
                    }
                ?>
                </div>
                <div class="pagination">
                    <?php
                    // Pagination links
                    for ($page = 1; $page <= $totalPages; $page++) {
                        if ($page == $currentPage) {
                            echo "<li><span>$page</span></li>";
                        } else {
                            echo "<li><a href='?equipment_page=$page'>$page</a></li>";
                        }
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
                </div>
                <button class="btn btn-success" name="add" style="margin-left: 80%;">Add</button>
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

                <label for="editEName">Equipment Name:</label>
                <input type="text" id="editEName" name="editEName" required>

                <label for="editCategory">Sports Category:</label>
                <input type="text" id="editCategory" name="editCategory" required>

                <label for="editQuantity">Quantity:</label>
                <input type="number" id="editQuantity" name="editQuantity" min="1" required>

                <label for="editCondition">Condition:</label>
                <input type="text" id="editCondition" name="editCondition">

                <label for="editMaintenance">Last Maintenance:</label>
                <input type="date" id="editMaintenance" name="editMaintenance">
                <br />
                <button type="button" class="btn btn-success update-yes" onclick="updateEquipment()" style="margin-left: 250px; max-width: 100px;">Update</button>
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
                <div style="display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-danger delete-yes" onclick="deleteEquipment()" style="margin-left: 30px; max-width: 100px;">Yes</button>
                    <button type="button" class="btn btn-success delete-no" onclick="closeDelEModal()" style="margin-right: 30px; max-width: 100px;">No</button>
                </div>
            </form>
        </div>
        <!-- End of Delete Equipment Modal -->
        <!-- Start of User Content -->
        <div class="modal-container" id="user-modal">
            <div class="modal-content">
                <h2>User Accounts</h2>
                <div class="float-right">
                    <button id="addN-button" class="addN-button btn-success" style="padding: 5px;">Add New User</button>
                    <button id="request-button" class="request-button btn-success" style="padding: 5px;">Registration Requests</button>
                </div>
                <div class="search-container">
                    <input type="text" id="user-search" style="max-width: 300px" placeholder="Search for users...">
                    <button id="search-button" style="background-color: green;"><i class="fas fa-search"></i></button>
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
                    ?>
                    <div class="card profile-card">
                        <div style="width: 115px; height: 115px; overflow: hidden; border-radius: 50%; position: relative; margin: 0 auto; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                            <img class="img-circle" src="../pictures/profile<?php echo $user['id'];?>.jpg" style="width: 100%; height: 100%; object-fit: cover;">
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
                        </div>
                        <center>
                            <button type="button" class="view-userA-button btn-success" data-userid="<?php echo $user['id']; ?>">
                                <i class="fas fa-eye"></i> View Activity
                            </button>
                            <button class="edit-user-button btn-success editInfoButton" data-user='<?php echo json_encode($user); ?>'>
                                <i class="fas fa-info-circle"></i> Edit info
                            </button>
                            <button type="button" class="delete-user-button btn-danger" onclick="showDeleteUserModal('<?php echo $user['id']; ?>', '<?php echo $user['username']; ?>')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </center>
                    </div>
                    <?php
                        }
                    ?>
                </div>
                <div class="pagination">
                    <?php
                        // Pagination links
                        for ($page = 1; $page <= $totalPages; $page++) {
                            if ($page == $currentPage) {
                                echo "<li><span>$page</span></li>";
                            } else {
                                echo "<li><a href='?user_page=$page'>$page</a></li>";
                            }
                        }
                    ?>
                </div>
                <?php
                    } else {
                        echo "No users found";
                    }
                ?>
            </div>
        </div>
        <!-- End of User Content -->
        <!-- Start of View User Activity Modal -->
        <div id="viewUAModal" class="modal-container" style="display: none;">
            <span class="close" id="closeViewUAModal">&times;</span>
            <h2>User Activity Log</h2>
            <!-- Log content goes here -->
            <div id="logContent"></div>
            <div class="pagination" id="logPagination"></div>
        </div>
        <!-- End of View User Activity Modal -->
        <!-- Start of Edit User Info Modal -->
        <div id="editInfoModal" class="modal-containers" style="display: none;">
            <span class="close" id="closeEditInfoModal">&times;</span>
            <h2>Edit Your Information</h2>
            <form id="editInfoForm" method="post">
                <!-- Add a hidden input field for user ID -->
                <input type="hidden" id="editUserId" name="userId" value="">
                
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="">
                <label for="course">Course & Year Level:</label>
                <input type="text" id="course" name="course" value="">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="">
                <button type="button" id="updateButton" class="updateButton">Update</button>
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
                <div style="display: flex; justify-content: space-between;">
                    <button type="button" class="btn btn-danger deleteU-yes" onclick="deleteUser()" style="margin-left: 30px; max-width: 100px;">Yes</button>
                    <button type="button" class="btn btn-success deleteU-no" onclick="closeDeleteUserModal()" style="margin-right: 30px; max-width: 100px;">No</button>
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
                </div>
                <button class="btn btn-success" name="add">Add</button>
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
                            echo '<div class="float-right"><button class="btn btn-success" type="submit" name="accept">Accept</button>';
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
                <h2>Borrowing History</h2>
                <div class="float-right">
                    <button id="borrowing-button" class="borrowing-button btn-success" style="padding: 5px;">Borrow Equipment</button>
                </div><br />
                <div class="card-container" id="borrowing-card-container">
                    <!-- Borrowing Cards -->
                    <?php
                    // Determine the current page
                    $currentPage = isset($_GET['borrowing_page']) ? $_GET['borrowing_page'] : 1;

                    // Set the number of records per page
                    $recordsPerPage = 3;

                    // Calculate the starting point for the results
                    $startIndex = ($currentPage - 1) * $recordsPerPage;

                    // Query to retrieve a limited set of records
                    $sql = "SELECT borrowing.*, equipment.ename AS equipment_name, users.name AS user_name FROM borrowing LEFT JOIN equipment ON borrowing.equipment_id = equipment.eid LEFT JOIN users ON borrowing.user_id = users.user_id LIMIT $startIndex, $recordsPerPage";

                    $result = mysqli_query($conn, $sql);

                    // Query to get the total number of records
                    $totalRecordsQuery = "SELECT COUNT(*) as total FROM borrowing";
                    $totalRecordsResult = mysqli_query($conn, $totalRecordsQuery);
                    $totalRecordsRow = mysqli_fetch_assoc($totalRecordsResult);
                    $totalRecords = $totalRecordsRow['total'];

                    while ($row = $result->fetch_assoc()): 
                    ?>
                    <div class="card borrowing-card">
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
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <!-- Pagination -->
                <div class="pagination" id="borrowing-pagination">
                    <?php
                    // Calculate the total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Pagination links
                    for ($page = 1; $page <= $totalPages; $page++) {
                        if ($page == $currentPage) {
                            echo "<li><span>$page</span></li>";
                        } else {
                            echo "<li><a href='?borrowing_page=$page'>$page</a></li>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- End of Borrowing Content -->
        <!-- Start of Borrowing Modal -->
        <div id="BorrowingModal" class="modal-containers">
            <span class="close" id="closeBorrowingModal">&times;</span>
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
                <div class="card-container">
                    <div class="card log-card">
                    <h2>Activity Log</h2>
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
                            echo '<div style="display: flex; justify-content: space-between;"><p>Administrator</p><center>';
                            echo $row['activity'];
                            echo '<br />';
                            echo $row['timestamp'];
                            echo '</center></div><hr />';
                        }
                    ?>
                    </div>
                </div>
                <div class="pagination">
                    <?php
                    // Pagination links
                    for ($page = 1; $page <= $totalPages; $page++) {
                        if ($page == $currentPage) {
                            echo "<li><span>$page</span></li>";
                        } else {
                            echo "<li><a href='?log_page=$page'>$page</a></li>";
                        }
                    }
                    ?>
                </div>
                <?php
                    } else {
                        echo "No logs found";
                    }
                ?>
            </div>
        </div>
        <!-- Start of Logout Content -->
        <div class="modal-container" id="logout-modal">
            <div class="modal-content">
                <!-- Logout Modal Content -->
                <div class="card-container">
                    <div class="card profile-card">
                        <center><h2>Log Out</h2>
                        <p>Are you sure you want to log out?</p>
                        <div class="button-container">
                            <button id="logout-confirm-button" class="modal-button action-button" onclick="confirmLogout()">Yes</button>
                            <button id="logout-cancel-button" class="modal-button action-button" onclick="confirmLogout()">No</button>
                        </div></center>
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
    <script src="../scripts/jquery.min.js"></script>
    <script src="../scripts/popper.min.js"></script>
    <script src="../scripts/bootstrap.min.js"></script>
    <script src="../scripts/admin-modal-scripts.js"></script>
    <script src="../scripts/admin-scripts.js"></script>
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
        // Function to perform search across all equipment cards
        function searchEquipment() {
            // Get the trimmed lowercase user input
            var searchTerm = equipmentInput.value.trim().toLowerCase();

            // Get all equipment cards
            var equipmentCards = document.getElementsByClassName('card equipment-card');

            // Loop through each card and hide/show based on the search input
            for (var i = 0; i < equipmentCards.length; i++) {
                var equipmentName = equipmentCards[i].querySelector('.label-data-pair:nth-child(2)').innerText.toLowerCase(); // Equipment Name
                var sportsCategory = equipmentCards[i].querySelector('.label-data-pair:nth-child(4)').innerText.toLowerCase(); // Sports Category
                var equipmentId = equipmentCards[i].querySelector('.label-data-pair:nth-child(6)').innerText.toLowerCase(); // Equipment ID

                // Check if the search term matches the equipment name or sports category
                if (equipmentName.includes(searchTerm) || sportsCategory.includes(searchTerm) || equipmentId.includes(searchTerm)) {
                    equipmentCards[i].style.display = '';
                } else {
                    equipmentCards[i].style.display = 'none';
                }
            }
        }

        // Get the user input element
        var equipmentInput = document.getElementById('equipment-search');

        // Add event listener to detect changes in the input field
        equipmentInput.addEventListener('input', function () {
            searchEquipment();
        });

        // Call the search function on initial load
        searchEquipment();
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
                fetchUserLogs(userId, 1);
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

            function fetchUserLogs(userId, page) {
                fetch(`../process/fetch-user-logs.php?userId=${userId}&page=${page}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            displayLogs(data.logs, userId, page, data.totalPages);
                        } else {
                            console.error("Failed to fetch user logs");
                        }
                    })
                    .catch(error => {
                        console.error("Error: " + error.message);
                    });
            }

            function displayLogs(logs, userId, page, totalPages) {
                const logContent = document.getElementById("logContent");
                logContent.innerHTML = "";
                const itemsPerPage = 4; // Set the number of items per page

                const startIndex = (page - 1) * itemsPerPage;
                const endIndex = Math.min(startIndex + itemsPerPage, logs.length);

                if (startIndex < logs.length) {
                    for (let i = startIndex; i < endIndex; i++) {
                        const log = logs[i];
                        const logEntry = document.createElement("div");
                        logEntry.innerHTML = `<div style="display: flex; justify-content: space-between;"><img class="img-circle" src="../pictures/profile${userId}.jpg" style="max-width: 50px; max-height: 50px; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;"><center>${log.activity}<br />${log.timestamp}</center></div><hr />`;
                        logContent.appendChild(logEntry);
                    }
                } else {
                    logContent.innerHTML = "No logs found";
                }

                const logPagination = document.getElementById("logPagination");
                logPagination.innerHTML = "";
                
                for (let i = 1; i <= totalPages; i++) {
                    if (i === page) {
                        logPagination.innerHTML += `<li><span>${i}</span></li>`;
                    } else {
                        logPagination.innerHTML += `<li><a href='#' onclick='fetchUserLogs(${userId}, ${i})'>${i}</a></li>`;
                    }
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
        // Get the user input element
        var userInput = document.getElementById('user-search');

        // Add event listener to detect changes in the input field
        userInput.addEventListener('input', function () {
            // Get the trimmed lowercase user input
            var searchTerm = userInput.value.trim().toLowerCase();

            // Get all user cards
            var userCards = document.getElementsByClassName('card profile-card');

            // Check if the input is blank or contains only spaces
            if (searchTerm === "") {
                // If input is blank, show all cards
                for (var i = 0; i < userCards.length; i++) {
                    userCards[i].style.display = '';
                }
            } else {
                // Loop through each card and hide/show based on the search input
                for (var i = 0; i < userCards.length; i++) {
                    var userName = userCards[i].querySelector('.label-data-pair:nth-child(2)').innerText.toLowerCase(); // Change selector based on your label order
                    if (userName.includes(searchTerm)) {
                        userCards[i].style.display = '';
                    } else {
                        userCards[i].style.display = 'none';
                    }
                }
            }
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
</body>
</html>