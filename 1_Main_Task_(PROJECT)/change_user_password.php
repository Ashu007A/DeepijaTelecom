<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        form {
            margin: 0 auto;
            width: 40%;
        }
        h1 {
            font-size: larger;
            float: left;
            color: #ff9a9e;
        }
        .active {
            color: black;
            font-weight: bold;
            background-color: lightgray;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            var userConfirmed = confirm("Are you sure you want to log out?");
            if (userConfirmed) {
                window.location.href = event.target.href;
            }
        }
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
        </ul>
    </nav>
    <div class="container mt-5 text-center">
        <h2 class="text-center">Account Management</h2>
        <br><br><br><br><br>
        <button id="changeUsernameBtn" class="btn btn-primary">Change Username</button>
        <button id="changePasswordBtn" class="btn btn-info">Change Password</button>
        <br><br><br>
        <div id="formContainer"></div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const changePasswordBtn = document.getElementById("changePasswordBtn");
            const changeUsernameBtn = document.getElementById("changeUsernameBtn");
            const formContainer = document.getElementById("formContainer");

            changeUsernameBtn.addEventListener("click", function() {
                formContainer.innerHTML = `
                    <form action="process_username_change.php" method="post">
                        <div class="form-group">
                            <label for="old_username">Old Username:</label>
                            <input type="text" class="form-control" id="old_username" name="old_username" value="<?php echo $_SESSION['username']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label for="new_username">New Username:</label>
                            <input type="text" class="form-control" id="new_username" name="new_username" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Change Username</button>
                    </form>
                `;
            });

            changePasswordBtn.addEventListener("click", function() {
                formContainer.innerHTML = `
                    <form action="process_password_change.php" method="post">
                        <div class="form-group">
                            <label for="old_password">Old Password:</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password">New Password:</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Re-enter New Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Change Password</button>
                    </form>
                `;
            });

        });
    </script>

</body>
</html>
