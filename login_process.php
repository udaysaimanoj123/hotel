<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'mysql';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$createTableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($mysqli->query($createTableQuery) !== TRUE) {
    die("Error creating table: " . $mysqli->error);
}

// User Registration Logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    // ... (Existing registration logic from your original code) ...
}

// User Login Logic
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $login_username = $mysqli->real_escape_string($_POST['login_username']);
    $login_password = $mysqli->real_escape_string($_POST['login_password']);

    $loginQuery = "SELECT id, password FROM users WHERE username = '$login_username' LIMIT 1";
    $result = $mysqli->query($loginQuery);

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($login_password, $hashed_password)) {
            echo "Login successful!";
            // You can perform further actions after successful login here (e.g., redirect to a dashboard page).

            // Use an absolute URL for the redirect
            $redirect_url = "http://localhost/webassignment/index.html";
            header("Location: " . $redirect_url);
            exit(); // It's good practice to include an exit call after the header to prevent further execution of the script.
        } else {
            echo "Invalid username or password!";
        }
    } else {
        echo "Invalid username or password!";
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link rel="stylesheet" href="login.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

    </style>
</head>
<body>
    <div class="Header">
       
        <div class="logohead">
            <img class="logo" src="C:\xampp\htdocs\webassignment\images\logo.png" alt="logo">
            <h1>StayJoy</h1>
        </div>
    <div class="navbar">
      <div><a href="index.html">Home</a></div>
      <div><a href ="Aboutus.html">About</a></div>
      <div><a href="Help.html">Help</a></div>
      <div><a href="contact.html">Contact</a></div>
      <div><a href = "D:\logo.png">Login</a></div>
        </div>
    </div>
    <div class="container">
        <h1>Login</h1>
        <form method="post" action="login_process.php"> 
            <div class="form-group">
                <label for="login_username">Username:</label>
                <input type="text" name="login_username" id="login_username" required>
            </div>

            <div class="form-group">
                <label for="login_password">Password:</label>
                <input type="password" name="login_password" id="login_password" required>
            </div>

            <div class="form-group">
                <button type="submit" name="login">Login</button>
            </div>
            <p style="text-align: center;">Click here to <a href="register_process.php">Register</a>
            </p>
        </form>
    </div>
    <footer class="footer">
      
        <div class="About">
            <div><p>About</p></div>
            <div><a href="contact.html">ContactUs</a></div>
            <div><a href="Aboutus.html">Aboutus</a></div>
            <div><a href="Help.html">Help</a></div>
        </div>
        <div class="social">
            <div><p>Social Media</p></div>
            <div><a href="www.facebook.com">facebook</a></div>
            <div><a href="www.instagram.com">instagram</a></div>
            <div><a href="www.twitter.com">twitter</a></div>
        </div>
    </footer>
</body>
</html>
