<?php
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

include "db_connect.php";

$username = $_SESSION['username'];

$punch_sql = "SELECT * FROM time_entries WHERE username = '$username'";
$punch_result = $conn->query($punch_sql);

$sql = "SELECT * FROM users WHERE username = '$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        #upper {
            padding-top: 40px;
        }
        .clock {
            height: 65px;
        }
        #currentDateTime {
            font-size: xx-large;
            font-weight: bold;
        }
        h1 {
            font-size: larger;
            float: left;
            color: #ff9a9e;
        }
        h2 {
            text-align: center;
        }
        .picture {
            height: 400px;
            width: 300px;
            object-fit: cover;
        }
        .active {
            color: black;
            font-weight: bold;
            background-color: lightgray;
        }
        #exportBtn {
            margin-bottom: 60px;
            margin-left: 815px;
        }
    </style>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script>
        function updateDateTime() {
            setInterval(() => {
                const now = new Date();
                const formattedTime = now.toLocaleTimeString();
                const formattedDate = now.toLocaleDateString();
                document.getElementById('currentDateTime').innerText = formattedDate + ' ' + formattedTime;
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', updateDateTime);

        document.addEventListener('DOMContentLoaded', function() {
            updateDateTime();

            // Fetch previous punch-in status
            fetch('punch_status.php')
                .then(response => response.json())
                .then(data => {
                    if (data.punchedIn) {
                        document.getElementById('punchInBtn').disabled = true;
                        document.getElementById('punchOutBtn').disabled = false;
                    } else {
                        document.getElementById('punchInBtn').disabled = false;
                        document.getElementById('punchOutBtn').disabled = true;
                    }
                });

            // Fetch and populate punch details
            fetch('fetch_todays_punch_details.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('punchInOutTable').querySelector('tbody');
                    data.forEach(entry => {
                        const row = document.createElement("tr");
                        row.setAttribute("data-id", entry.id);
                        row.innerHTML = `
                            <td>${entry.punchIn}</td>
                            <td>${entry.punchOut || ''}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                });
        });

        function punchIn() {
            fetch('punch.php?action=in')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.createElement("tr");
                        row.setAttribute("data-id", data.entryId);
                        const localDateTime = new Date(data.punchIn).toLocaleString();
                        row.innerHTML = `
                            <td>${localDateTime}</td>
                            <td></td>
                        `;
                        document.getElementById('punchInOutTable').querySelector('tbody').appendChild(row);
                        document.getElementById('punchInBtn').disabled = true;
                        document.getElementById('punchOutBtn').disabled = false;
                    } else {
                        alert(data.message);
                    }
                });
        }

        function punchOut() {
            fetch('punch.php?action=out')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const row = document.querySelector(`tr[data-id='${data.entryId}']`);
                        const localDateTime = new Date(data.punchOut).toLocaleString();
                        row.querySelector('td:nth-child(2)').textContent = localDateTime;
                        document.getElementById('punchInBtn').disabled = false;
                        document.getElementById('punchOutBtn').disabled = true;
                    } else {
                        alert(data.message);
                    }
                });
        }

        function toggleUploadButton() {
            const fileInput = document.getElementById('profilePictureInput');
            const uploadButton = document.getElementById('uploadButton');
            if (fileInput.files.length > 0) {
                uploadButton.disabled = false;
            } else {
                uploadButton.disabled = true;
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
</head>
<body>
    <div class="navigation">
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
    </div>
    <div id="upper" class="container mt-5 text-center">
        <h2 class="text-center">Date Time Entry</h2>
        <div class="clock">
            <p id="currentDateTime"></p>
        </div>
        <button onclick="punchIn()" id="punchInBtn" class="btn btn-info">
            Punch In  <i class="fa fa-sign-in" style="font-size:20px;color:green"></i>
        </button>
        <button onclick="punchOut()" id="punchOutBtn" class="btn btn-info">
            Punch Out <i class="fa fa-sign-out" style="font-size:20px;color:red"></i>
        </button>
    </div>
    
    <div class="container mt-5 text-center">
        <h2 class="text-center">Daily Time Entry Report</h2>
        <table class="table table-bordered" id="punchInOutTable">
            <thead>
                <tr>
                    <th width="50%">Punch In</i></th>
                    <th width="50%">Punch Out</th>
                </tr>
            </thead>
            <tbody>
                <!-- Rows -->
            </tbody>
        </table>
    </div>


    <div class="container mt-5">
        <h2 class="text-center">User Dashboard</h2>
        <div class="d-flex justify-content-center align-items-start">
            <!-- Profile Picture Section -->
            <div class="profile-pic-container mr-5 picture">
                <?php
                $profile_pic_path = "profile_pics/" . $username . ".jpg";
                $cache_bust = isset($_GET['cache_bust']) ? $_GET['cache_bust'] : time();  // Use cache-busting parameter
                if (file_exists($profile_pic_path)): ?>
                    <img src="<?php echo $profile_pic_path; ?>" alt="Profile Picture" class="img-thumbnail picture" style="height: 400px; width: 300px; object-fit: cover;">
                    <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
                        <input type="file" id="profilePictureInput" name="profile_picture" class="form-control-file mt-2" onchange="toggleUploadButton()">
                        <button type="submit" id="uploadButton" class="btn btn-dark mt-2" disabled>Change Profile Picture</button>
                    </form>
                <?php else: ?>
                    <img src="default_profile.png" alt="Default Profile Picture" class="img-thumbnail picture" style="height: 400px; width: 300px; object-fit: cover;">
                    <form action="upload_profile_picture.php" method="post" enctype="multipart/form-data">
                        <input type="file" id="profilePictureInput" name="profile_picture" class="form-control-file mt-2" onchange="toggleUploadButton()">
                        <button type="submit" id="uploadButton" class="btn btn-dark mt-2" disabled>Upload Profile Picture</button>
                    </form>
                <?php endif; ?>
            </div>
            
            <!-- User Data Table Section -->
            <div>
                <?php if ($result->num_rows > 0): ?>
                    <?php $user = $result->fetch_assoc(); ?>
                    <table class="table table-bordered" id="userDashboardTable">
                        <tr>
                            <th width="200px">ID</th>
                            <td width="400px"><?php echo $user['id']; ?></td>
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
        </div>
    </div>

    <div class="container mt-5 text-center">
        <button id="exportBtn" class="btn btn-success">Download CSV</button>
    </div>

    <script>
        function toggleUploadButton() {
            const fileInput = document.getElementById('profilePictureInput');
            const uploadButton = document.getElementById('uploadButton');
            if (fileInput.files.length > 0) {
                uploadButton.disabled = false;
            } else {
                uploadButton.disabled = true;
            }
        }

        document.getElementById("exportBtn").addEventListener("click", function () {
            let csvContent = "data:text/csv;charset=utf-8,";
            let table = document.getElementById("userDashboardTable");
            let rows = table.querySelectorAll("tr");
            rows.forEach(row => {
                let cols = row.querySelectorAll("th, td");
                let rowContent = Array.from(cols).map(col => col.textContent).join(",");
                csvContent += rowContent + "\r\n";
            });

            const now = new Date();
            const formattedDate = now.toLocaleDateString('en-GB').replace(/\//g, '-');
            const formattedTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false }).replace(':', '-');

            const username = "<?php echo $_SESSION['username']; ?>";

            let encodedUri = encodeURI(csvContent);
            let link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `${username}_${formattedDate}_${formattedTime}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    </script>
</body>
</html>