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

// Validate and get the blog ID from the URL
$blogId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($blogId <= 0) {
    echo "Invalid blog ID.";
    exit();
}

// Fetch the blog post data
$sql = "SELECT * FROM blogs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $blogId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Blog post not found.";
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
    <title><?php echo htmlspecialchars($row['title']); ?></title>
    <link rel="stylesheet" href="view_blog.css">
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

<div class="blog-container">
    <h1><?php echo htmlspecialchars($row['title']); ?></h1>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
    <p><strong>Published on:</strong> <?php echo htmlspecialchars($row['created_at']); ?></p>
    <div class="blog-content">
        <?php echo nl2br(htmlspecialchars($row['content'])); ?>
    </div>
</div>
</body>
</html>

