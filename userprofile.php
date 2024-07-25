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

// Fetch the username from the URL
$profile_username = isset($_GET['username']) ? htmlentities(mysqli_real_escape_string($conn, $_GET['username'])) : '';

// Fetch user data based on the username
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $profile_username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile.css?v=1.0">
</head>
<body>

<nav>
    <div class="nav-links">
        <ul>
            <li><a href="home.php">HOME</a></li>
            <li><a href="community.php">Community tab</a></li>
            <li><a href="profile.php">Your Profile</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="blog.php">Blog</a></li>

            <li><a href="thrift_score.php">Thrift</a></li>
            <form action="search.php" method="get" class="search-form">
                <input type="text" name="search" value="" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">Search</button>
            </form>
        </ul>
    </div>
</nav>

<div class="profile-container">
    <h1>User Profile</h1>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstname']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastname']); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
    <p><strong>University:</strong> <?php echo htmlspecialchars($row['university']); ?></p>
    <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($row['qualifications']); ?></p>
    <p><strong>Degree:</strong> <?php echo htmlspecialchars($row['degree']); ?></p>
    <p><strong>Other Information:</strong> <?php echo htmlspecialchars($row['other']); ?></p>
    <p><strong>Exam:</strong> <?php echo htmlspecialchars($row['exam']); ?></p>
    <p><strong>PhD:</strong> <?php echo htmlspecialchars($row['phd']); ?></p>
    <p><strong>Masters:</strong> <?php echo htmlspecialchars($row['masters']); ?></p>
</div>


<div class="chat">


<button class="chatb">Chat here</button>
</div>

<?php
$stmt->close();
$conn->close();
?>

</body>
</html>

