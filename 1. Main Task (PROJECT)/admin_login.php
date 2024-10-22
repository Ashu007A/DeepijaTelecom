<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
  <style>
    body {
        background-image: url('image4.jpg');
        background-size: cover;
        /* display: flex; */
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    form {
      margin: 150px auto;
      width: 20%;
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
</head>
<body>
    <nav>
        <ul>
          <h1>Deepija Telecom Pvt. Ltd.</h1>
          <!-- <li><a href="home.html">Home</a></li> -->
          <li><a href="admin_login.php" class="<?php echo $current_page == 'admin_login.php' ? 'active' : ''; ?>">Admin Login</a></li>
          <li><a href="login.php" class="<?php echo $current_page == 'login.php' ? 'active' : ''; ?>">User Login</a></li>
          <li><a href="register.php" class="<?php echo $current_page == 'register.php' ? 'active' : ''; ?>">Register New User</a></li>
        </ul>
    </nav>

    <?php
      session_start();
      if (isset($_SESSION['error'])) {
          echo '<p class="error">' . $_SESSION['error'] . '</p>';
          unset($_SESSION['error']);
      }
    ?>

    <h2 style="text-align: center">ADMIN LOGIN</h2>

    <form action="admin_login_process.php" method="post">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required><br><br>
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required><br><br>
          <input type="submit" value="Submit" style="margin-left:30%;">
    </form>
</body>
</html>
