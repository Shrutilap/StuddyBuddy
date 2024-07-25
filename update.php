<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "userdata";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$logged_in_username = $_SESSION['username'];
$firstname = htmlentities(mysqli_real_escape_string($conn, $_POST['firstname']));
$lastname = htmlentities(mysqli_real_escape_string($conn, $_POST['lastname']));
$email = htmlentities(mysqli_real_escape_string($conn, $_POST['email']));
$country = htmlentities(mysqli_real_escape_string($conn, $_POST['country']));
$university = htmlentities(mysqli_real_escape_string($conn, $_POST['university']));
$degree = htmlentities(mysqli_real_escape_string($conn, $_POST['degree']));
$qualifications = htmlentities(mysqli_real_escape_string($conn, $_POST['qualifications']));

$other = htmlentities(mysqli_real_escape_string($conn, $_POST['other']));

// Update user data
$sql = "UPDATE users SET firstname=?, lastname=?, email=?, country=?, university=?, qualifications=?, degree=?, other=? WHERE username=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $firstname, $lastname, $email, $country, $university, $qualifications, $degree,$other, $logged_in_username);

if ($stmt->execute()) {
    echo "<script>alert('Profile updated successfully.'); window.location.href='profile.php';</script>";
} else {
    echo "<script>alert('Error updating profile.'); window.location.href='edit_profile.php';</script>";
}

$stmt->close();
$conn->close();
?>
