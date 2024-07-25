<?php
session_start();

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

// Get the username from the query parameter or default to logged-in user
$profileUsername = isset($_GET['username']) ? $_GET['username'] : $_SESSION['username'];

// Validate and sanitize the username
$profileUsername = htmlspecialchars($profileUsername, ENT_QUOTES, 'UTF-8');

// Fetch the user data
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $profileUsername);
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
    <title><?php echo htmlspecialchars($row['username']); ?>'s Profile</title>
    <link rel="stylesheet" href="profile.css?v=1.0">
    </head>
<body>


<nav>
        <div class="nav-links">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="community.php">Community</a></li>
                <li><a href="profile.php">Your Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
                <li><a href="blog.php">Blog</a></li>
    
                <li><a href="thrift_score.php">Thrift</a></li>
                <form action="search.php" method="get" class="search-form">
                    <input type="text" name="search" value="" placeholder="Search" class="search-input">
                    <button type="submit" class="search-button"><svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                      </svg></button>
                </form>
            </ul>
        </div>
    </nav>


<div class="profile-container">
    <h1><?php echo htmlspecialchars($row['username']); ?>'s Profile</h1>
    <p><strong>First Name:</strong> <?php echo htmlspecialchars($row['firstname']); ?></p>
    <p><strong>Last Name:</strong> <?php echo htmlspecialchars($row['lastname']); ?></p>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($row['username']); ?></p>
    <p><strong>Country:</strong> <?php echo htmlspecialchars($row['country']); ?></p>
    <p><strong>University:</strong> <?php echo htmlspecialchars($row['university']); ?></p>
    <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($row['qualifications']); ?></p>
    <p><strong>Degree:</strong> <?php echo htmlspecialchars($row['degree']); ?></p>
    <p><strong>Other Information:</strong> <?php echo htmlspecialchars($row['other']); ?></p>
    <p><strong>Exam:</strong> <?php echo htmlspecialchars($row['exam']); ?></p>
    <p><strong>PhD:</strong> <?php echo htmlspecialchars($row['phd']); ?></p>
    <p><strong>Masters:</strong> <?php echo htmlspecialchars($row['masters']); ?></p>
</div>

<?php if ($_SESSION['username'] === $profileUsername): ?>
    <div class="chat">
        <form action="edit.php" method="get">
            <button type="submit" class="chatb">EDIT PROFILE</button>
        </form>
    </div>
<?php endif; ?>

</body>
</html>
