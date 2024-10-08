<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Contact</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <style>
    h2 {
      margin-top: 20%;
    }
    h2, p {
      text-align: center;
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
    <h2>Contact Us</h1>
    <p>Ashish Kumar Ram</p>
    <p>Software Engineer Intern</p>
    <p>Deepija Telecom Pvt. Ltd.</p>
    <p>+91 xxxxx-xxxxx</p>
    <p>ashishkumar_r@dev.deepijatel.com</p>
</body>
</html>
