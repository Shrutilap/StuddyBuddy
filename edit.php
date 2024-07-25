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

// Fetch the logged-in user's data
$logged_in_username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logged_in_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>



<div class="profile-container2">
    <h1>Edit Profile</h1>
    <form action="update.php" method="post">
        <label for="firstname">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($row['firstname']); ?>" required>

        <label for="lastname">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($row['lastname']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>

        <label for="country">Country:</label>
        <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($row['country']); ?>" required>

        <label for="university">University:</label>
        <input type="text" id="university" name="university" value="<?php echo htmlspecialchars($row['university']); ?>" required>

        <label for="degree">Degree:</label>
        <input type="text" id="degree" name="degree" value="<?php echo htmlspecialchars($row['degree']); ?>" required>

        <label for="degree">Qualification:</label>
        <input type="text" id="qualifications" name="qualifications" value="<?php echo htmlspecialchars($row['qualifications']); ?>" required>


        <label for="other">Other Information:</label>
        <textarea id="other" name="other"><?php echo htmlspecialchars($row['other']); ?></textarea>

        <button type="submit" name="update">Update Profile</button>
    </form>
</div>




</body>
</html>
