<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

// Timeout duration
$timeout_duration = 60;

// Check if the timeout variable is set and has passed
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

// Update last activity timestamp
$_SESSION['last_activity'] = time();


$current_page = basename($_SERVER['PHP_SELF']);

include "db_connect.php";

$sql = "SELECT * FROM users";
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
            <li><a href="admin_dashboard.php" class="<?php echo $current_page == 'admin_dashboard.php' ? 'active' : ''; ?>">Admin Dashboard</a></li>
        </ul>
    </nav>

    <h2>All Users Data</h2>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone</th>
                <th>State</th>
                <th>District</th>
                <th>City</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Course</th>
                <th>Address</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['phone'] . "</td>";
                    echo "<td>" . $row['state'] . "</td>";
                    echo "<td>" . $row['district'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "<td>" . $row['dob'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['course'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo '<td><button class="btn btn-primary" onclick="confirmEdit(' . $row['id'] . ')">Edit</button></td>';
                    echo '<td><button class="btn btn-danger" onclick="confirmDelete(' . $row['id'] . ')">Delete</button></td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
    
    <script>
        function confirmEdit(userId) {
            if (confirm("Do you want to edit this user?")) {
                window.location.href = "admin_edit_profile.php?id=" + userId;
            }
        }

        function confirmDelete(userId) {
            if (confirm("Do you want to delete this user?")) {
                window.location.href = "admin_delete_user.php?id=" + userId;
            }
        }

        function confirmLogout(event) {
            event.preventDefault();
            var userConfirmed = confirm("Are you sure you want to log out?");
            if (userConfirmed) {
                window.location.href = event.target.href;
            }
        }
    </script>
</body>
</html>
