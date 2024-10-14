<?php
session_start();
if (!isset($_SESSION['admin_username'])) {
    header("Location: admin_login.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);

$timeout_duration = 300;

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: admin_login.php");
    exit();
}

$_SESSION['last_activity'] = time();


$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
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
  <script src="script.js" defer></script>
</head>
<body>
  <nav>
    <ul>
      <h1>Deepija Telecom Pvt. Ltd.</h1>
      <li><a href="logout.php" class="<?php echo $current_page == 'logout.php' ? 'active' : ''; ?>" onclick="confirmLogout(event)">Logout</a></li>
      <li><a href="admin_dashboard.php" class="<?php echo $current_page == 'admin_dashboard.php' ? 'active' : ''; ?>">Admin Dashboard</a></li>
    </ul>
  </nav>
  <form action="admin_process_form.php" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <label for="repassword">Re-enter Password:</label>
    <input type="password" id="repassword" name="repassword" required><br><br>
    <label for="phone">Phone Number:</label>
    <input type="tel" id="phone" name="phone" required><br><br>
    <label for="state">State:</label>
    <select id="state" name="state" required>
      <option value="" disabled selected>Select a State</option>
    </select><br><br>
    <label for="district">District:</label>
    <select id="district" name="district" required>
      <option value="" disabled selected>Select a District</option>
    </select><br><br>
    <label for="city">City:</label>
    <select id="city" name="city" required>
      <option value="" disabled selected>Select a City</option>
    </select><br><br>
    <label for="dob">Date of Birth:</label>
    <input type="date" id="dob" name="dob" required><br><br>
    <label for="gender">Gender:</label>
    <input type="radio" id="male" name="gender" value="male">
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female">
    <label for="female">Female</label><br><br>
    <label for="course">Course Selection:</label>
    <input type="checkbox" id="course1" name="course" value="course1">
    <label for="MERN">MERN Stack</label>
    <input type="checkbox" id="course2" name="course" value="course2">
    <label for="MEAN">Mean Stack</label><br><br>
    <label for="address">Address:</label><br>
    <textarea id="address" name="address" rows="4" cols="50"></textarea><br><br>
    <input type="reset" value="Reset" style="float: left; margin-left: 70px;">
    <input type="submit" value="Register" style="float: right; margin-right: 70px;">
  </form>
</body>
</html>