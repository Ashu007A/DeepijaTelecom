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

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete Account</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        body {
            justify-content: center;
            align-items: center;
        }
        h1 {
            font-size: larger;
            float: left;
            color: #ff9a9e;
        }
        h2, p {
            text-align: center;
        }
        form {
        margin: 30px auto;
        width: 15%;
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
            <li><a href="change_user_password.php" class="<?php echo $current_page == 'change_user_password.php' ? 'active' : ''; ?>">Change Password</a></li>
            <li><a href="edit_profile.php" class="<?php echo $current_page == 'edit_profile.php' ? 'active' : ''; ?>">Edit Profile</a></li>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
        </ul>
    </nav>
    <h2>Delete Account</h2>
    <br><br><br><br><br><br><br>
    <p>Are you sure you want to delete your account?</p>
    <form action="delete_account_process.php" method="post">
        <input type="submit" value="Yes, delete my account" style="background-color: red; color: white;">
    </form>
</body>
</html>
