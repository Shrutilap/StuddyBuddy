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

// Initialize result variable
$result = null;

// Handle new post submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_post'])) {
    $username = $_SESSION['username'];
    $post_content = htmlentities(mysqli_real_escape_string($conn, $_POST['post_content']));
    
    // Insert new post into the database
    $sql = "INSERT INTO posts (username, content, created_at) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $post_content);

    if ($stmt->execute()) {
        header("Location: community.php");
        exit();
    } else {
        echo "<script>alert('Error submitting post.');</script>";
    }

    $stmt->close();
}

// Handle post deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id'];
    $username = $_SESSION['username'];
    
    // Delete post only if it belongs to the logged-in user
    $sql = "DELETE FROM posts WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $post_id, $username);
    
    if ($stmt->execute()) {
        header("Location: community.php");
        exit();
    } else {
        echo "<script>alert('Error deleting post.');</script>";
    }

    $stmt->close();
}

// Fetch posts from the database
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Tab</title>
    <link rel="stylesheet" href="comm.css?v=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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

    
    
<div class="community-container">
    <h1>Community Tab</h1>

    <!-- Post Submission Form -->
    <form action="community.php" method="post" class="post-form">
        <textarea name="post_content" placeholder="What's on your mind?" required></textarea>
        <button type="submit" name="submit_post">Post</button>
    </form>

    <!-- Display Posts -->
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="post">
                <p>
                    <a href="userprofile.php?username=<?php echo urlencode($row['username']); ?>" class="post-username">
                        <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                    </a> - <?php echo htmlspecialchars($row['created_at']); ?>
                </p>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <!-- Display delete button if the post belongs to the logged-in user -->
                <?php if ($row['username'] == $_SESSION['username']): ?>
                    <form action="community.php" method="post" class="delete-form">
                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_post">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts available.</p>
    <?php endif; ?>
</div>

</body>
</html>
