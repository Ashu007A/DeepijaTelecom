<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);

include "db_connect.php";

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        h1 {
            font-size: larger;
            float: left;
            color: yellow;
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
            <li><a href="edit_profile.php" class="<?php echo $current_page == 'edit_profile.php' ? 'active' : ''; ?>">Edit Profile</a></li>
            <li><a href="dashboard.php" class="<?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a></li>
        </ul>
    </nav>
    <div class="container mt-5">
        <h2 class="text-center">User Dashboard</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php $user = $result->fetch_assoc(); ?>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td><?php echo $user['id']; ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo $user['name']; ?></td>
                </tr>
                <tr>
                    <th>Username</th>
                    <td><?php echo $user['username']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $user['email']; ?></td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td><?php echo $user['phone']; ?></td>
                </tr>
                <tr>
                    <th>State</th>
                    <td><?php echo $user['state']; ?></td>
                </tr>
                <tr>
                    <th>District</th>
                    <td><?php echo $user['district']; ?></td>
                </tr>
                <tr>
                    <th>City</th>
                    <td><?php echo $user['city']; ?></td>
                </tr>
                <tr>
                    <th>DOB</th>
                    <td><?php echo $user['dob']; ?></td>
                </tr>
                <tr>
                    <th>Gender</th>
                    <td><?php echo $user['gender']; ?></td>
                </tr>
                <tr>
                    <th>Course</th>
                    <td><?php echo $user['course']; ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo $user['address']; ?></td>
                </tr>
            </table>
        <?php else: ?>
            <p>No data available</p>
        <?php endif; ?>
    </div>
</body>
</html>
