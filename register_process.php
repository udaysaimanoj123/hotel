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

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $mysqli->real_escape_string($_POST['full_name']);
    $email = $mysqli->real_escape_string($_POST['email']);
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);
    $password_confirm = $mysqli->real_escape_string($_POST['password_confirm']);

    if (empty($full_name) || empty($email) || empty($username) || empty($password) || empty($password_confirm)) {
        echo "All fields are required!";
    } elseif ($password !== $password_confirm) {
        echo "Passwords do not match!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
    } else {
       
        $checkQuery = "SELECT id FROM users WHERE username = '$username' OR email = '$email' LIMIT 1";
        $result = $mysqli->query($checkQuery);
        if ($result && $result->num_rows > 0) {
            echo "Username or email already exists!";
        }
         else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insertQuery = "INSERT INTO users (full_name, email, username, password) VALUES ('$full_name', '$email', '$username', '$hashed_password')";
            if ($mysqli->query($insertQuery) === TRUE) {
                echo "Registration successful!";
            } else {
                echo "Error: " . $insertQuery . "<br>" . $mysqli->error;
            }
        }
    }
}

$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="Register.css">
</head>
<body>
    <div class="Header">
        <div class="logohead">
            <div><img class="logo" src="C:\xampp\htdocs\webassignment\images\logo.png" alt="logo"></div>
            <div><h1>StayJoy</h1></div>
        </div>
        <div class="navbar">
        <div><a href="index.html">Home</a></div>
      <div><a href ="Aboutus.html">About</a></div>
      <div><a href="Help.html">Help</a></div>
      <div><a href="contact.html">Contact</a></div>
      <div><a href = "http://localhost/webassignment/login_process.php">Login</a></div>
        </div>
    </div>

    <div class="container">
        <h1>Registration</h1>
        <form method="post" action="">
            <table>
                <tr>
                    <td><label for="full_name">Full Name:</label></td>
                    <td><input type="text" name="full_name" id="full_name" required></td>
                </tr>
                <tr>
                    <td><label for="email">Email:</label></td>
                    <td><input type="email" name="email" id="email" required></td>
                </tr>
                <tr>
                    <td><label for="username">Username:</label></td>
                    <td><input type="text" name="username" id="username" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" name="password" id="password" required></td>
                </tr>
                <tr>
                    <td><label for="password_confirm">Confirm Password:</label></td>
                    <td><input type="password" name="password_confirm" id="password_confirm" required></td>
                </tr>
            </table>
            
            <button type="submit">Register</button>
            <a href = "http://localhost/webassignment/login_process.php">Login</a>
        </form>
    </div>

    <footer class="footer">
        <div class="footer-align">
            <div class="About">
                <div><p>About</p></div>
                <div><a href="contact.html">ContactUs</a></div>
                <div><a href="Aboutus.html">Aboutus</a></div>
                <div><a href="Help.html">Help</a></div>
            </div>
            <div class="social">
                <div><p>Social Media</p></div>
                <div><a href="www.facebook.com">Facebook</a></div>
                <div><a href="www.instagram.com">Instagram</a></div>
                <div><a href="www.twitter.com">Twitter</a></div>
            </div>
        </div>
    </footer>
</body>
</html>
