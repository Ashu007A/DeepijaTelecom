<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
include "db_connect.php";

// Timeout duration
$timeout_duration = 60;

// Check if the timeout variable is set and has passed
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Time Entry</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        h1 {
            font-size: larger;
            float: left;
            color: #ff9a9e;
        }
        h2 {
            text-align: center;
        }
        .active {
            color: black;
            font-weight: bold;
            background-color: lightgray;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script>
        function punchIn() {
            fetch('punch.php?action=in')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.createElement("tr");
                        row.setAttribute("data-id", data.entryId);
                        row.innerHTML = `
                            <td>${data.entryId}</td>
                            <td>${data.username}</td>
                            <td>${data.punchIn}</td>
                            <td></td>
                        `;
                        document.getElementById('punchInOutTable').querySelector('tbody').appendChild(row);
                    }
                });
        }

        function punchOut() {
            fetch('punch.php?action=out')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-id='${data.entryId}']`);
                        row.querySelector('td:nth-child(4)').textContent = data.punchOut;
                    }
                });
        }

        document.addEventListener('DOMContentLoaded', updateDateTime);
    </script>
</head>
<body>
    <nav>
        <ul>
            <h1>Deepija Telecom Pvt. Ltd.</h1>
            <li><a href="logout.php" class="<?php echo $current_page == 'logout.php' ? 'active' : ''; ?>" onclick="confirmLogout(event)">Logout</a></li>
            <li><a href="contact.php" class="<?php echo $current_page == 'contact.php' ? 'active' : ''; ?>">Contact</a></li>
            <li><a href="delete_account.php" class="<?php echo $current_page == 'delete_account.php' ? 'active' : ''; ?>">Delete Account</a></li>
            <li><a href="change_user_password.php" class="<?php echo $current_page == 'change_user_password.php' ? 'active' : ''; ?>">Change Username/Password</a></li>
            <li><a href="edit_profile.php" class="<?php echo $current_page == 'edit_profile.php' ? 'active' : ''; ?>">Edit Profile</a></li>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
            <li><a href="time_entry.php" class="<?php echo $current_page == 'time_entry.php' ? 'active' : ''; ?>">Daily Entry</a></li>
        </ul>
    </nav>
    <div class="container mt-5 text-center">
        <h2 class="text-center">Date Time Entry</h2>
        <p id="currentDateTime"></p>
        <button onclick="punchIn()" class="btn btn-primary">Punch In</button>
        <button onclick="punchOut()" class="btn btn-secondary">Punch Out</button>
    </div>
    
    <div class="container mt-5 text-center">
        <h2 class="text-center">Daily Time Entry Report</h2>
        <table class="table table-bordered" id="punchInOutTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Punch In</th>
                    <th>Punch Out</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows will be populated here -->
            </tbody>
        </table>
    </div>
</body>
</html>