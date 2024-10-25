<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="styles.css">
  <style>
    body {
        background-image: url('background.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
    }
    form {
      margin: 30px auto;
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
  <script src="script.js" defer></script>
</head>
<body>
<div class="navigation">
  <nav>
    <ul>
      <h1>Deepija Telecom Pvt. Ltd.</h1>
      <li><a href="admin_login.php" class="<?php echo $current_page == 'admin_login.php' ? 'active' : ''; ?>">Admin Login</a></li>
      <li><a href="login.php" class="<?php echo $current_page == 'login.php' ? 'active' : ''; ?>">User Login</a></li>
      <li><a href="register.php" class="<?php echo $current_page == 'register.php' ? 'active' : ''; ?>">Register New User</a></li>
    </ul>
  </nav>
</div>
  <div class="heading">
  <h2 style="text-align: center;">REGISTRATION FORM</h2>
  </div>
  <form action="process_form.php" method="post">
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
    <input type="radio" id="male" name="gender" value="male" required>
    <label for="male">Male</label>
    <input type="radio" id="female" name="gender" value="female" required>
    <label for="female">Female</label><br><br>
    <label for="course">Course Selection:</label><br>
    <input type="checkbox" id="course1" name="course[]" value="MERN Stack">
    <label for="course1">MERN Stack</label><br>
    <input type="checkbox" id="course2" name="course[]" value="Mean Stack">
    <label for="course2">Mean Stack</label><br>
    <input type="checkbox" id="course3" name="course[]" value="Full Stack">
    <label for="course3">Full Stack</label><br><br>
    <label for="address">Address:</label><br>
    <textarea id="address" name="address" rows="4" cols="50" required></textarea><br><br>
    <!-- <label for="file">Upload Profile Image:</label>
    <input type="file" id="file" name="file"><br><br> -->
    <input type="reset" value="Reset" style="float: left; margin-left: 70px;">
    <input type="submit" value="Register" style="float: right; margin-right: 70px;">
  </form>
</body>
</html>
