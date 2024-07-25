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

// Handle form submission for new blog post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_blog'])) {
    $title = htmlentities(mysqli_real_escape_string($conn, $_POST['title']));
    $content = htmlentities(mysqli_real_escape_string($conn, $_POST['content']));
    $author = $_SESSION['username'];

    $sql = "INSERT INTO blogs (title, content, author, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $content, $author);

    if ($stmt->execute()) {
        echo "<script>alert('Blog posted successfully.');</script>";
    } else {
        echo "<script>alert('Error posting blog.');</script>";
    }

    $stmt->close();
}

// Handle blog post deletion
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_blog'])) {
    $post_id = $_POST['post_id'];
    $username = $_SESSION['username'];
    
    // Delete blog post only if it belongs to the logged-in user
    $sql = "DELETE FROM blogs WHERE id = ? AND author = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $post_id, $username);
    
    if ($stmt->execute()) {
        header("Location: blog.php");
        exit();
    } else {
        echo "<script>alert('Error deleting blog.');</script>";
    }

    $stmt->close();
}

// Fetch all published blogs
$sql = "SELECT * FROM blogs ORDER BY created_at DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs</title>
    <link rel="stylesheet" href="blog.css">
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
                <input type="text" name="search" placeholder="Search..." class="search-input">
                <button type="submit" class="search-button">Search</button>
            </form>
        </ul>
    </div>
</nav>

<div class="blog-container">
    <h1>Write a New Blog</h1>
    <form action="blog.php" method="post">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <label for="content">Content:</label>
        <textarea id="content" name="content" rows="10" required></textarea>
        <button type="submit" name="submit_blog">Post Blog</button>
    </form>

    <h1>Published Blogs</h1>
    <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="blog-post">
                <h2><a href="view_blog.php?id=<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['title']); ?></a></h2>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($row['author']); ?></p>
                <?php if ($row['author'] == $_SESSION['username']): ?>
                    <form action="blog.php" method="post" class="delete-form">
                        <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="delete_blog">Delete</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No blogs have been published yet.</p>
    <?php endif; ?>
</div>
</body>
</html>

