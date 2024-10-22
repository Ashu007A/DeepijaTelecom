<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
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

include "db_connect.php";

$username = $_SESSION['username'];

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        form {
            margin: 0 auto;
            width: 40%;
        }
        h1 {
            font-size: larger;
            float: left;
            color: yellow;
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
    <script src="script.js" defer></script>
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
    <h2 style="text-align: center;">Edit Profile</h2>
    <form action="update_profile.php" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $user['name']; ?>" required><br><br>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required><br><br>

        <!-- <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter new password if you want to change it"><br><br> -->

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required><br><br>

        <label for="state">State:</label>
        <input type="text" id="state" name="state" value="<?php echo $user['state']; ?>" required><br><br>

        <label for="district">District:</label>
        <input type="text" id="district" name="district" value="<?php echo $user['district']; ?>" required><br><br>

        <label for="city">City:</label>
        <input type="text" id="city" name="city" value="<?php echo $user['city']; ?>" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" value="<?php echo $user['dob']; ?>" required><br><br>

        <label for="gender">Gender:</label>
        <input type="radio" id="male" name="gender" value="male" <?php echo ($user['gender'] == 'male') ? 'checked' : ''; ?>>
        <label for="male">Male</label>
        <input type="radio" id="female" name="gender" value="female" <?php echo ($user['gender'] == 'female') ? 'checked' : ''; ?>>
        <label for="female">Female</label><br><br>

        <label for="course">Course Selection:</label>
        <?php 
        $courses = explode(", ", $user['course']);
        ?>
        <input type="checkbox" id="course1" name="course[]" value="MERN Stack" <?php echo (in_array('MERN Stack', $courses)) ? 'checked' : ''; ?>>
        <label for="course1">MERN Stack</label>
        <input type="checkbox" id="course2" name="course[]" value="Mean Stack" <?php echo (in_array('Mean Stack', $courses)) ? 'checked' : ''; ?>>
        <label for="course2">Mean Stack</label><br><br>

        <label for="address">Address:</label><br>
        <textarea id="address" name="address" rows="4" cols="50"><?php echo $user['address']; ?></textarea><br><br>

        <input type="submit" value="Update Profile">
    </form>
</body>
</html>
