<?php
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

// Get search query
$search = isset($_GET['search']) ? htmlentities(mysqli_real_escape_string($conn, $_GET['search'])) : '';

// Initialize results
$result = null;

// Perform search only if the search query is not empty
if (!empty($search)) {
    // Search for users by multiple fields
    $sql = "SELECT * FROM users 
            WHERE firstname LIKE ? 
               OR lastname LIKE ? 
               OR university LIKE ? 
               OR degree LIKE ?
               OR country LIKE ?";

    $stmt = $conn->prepare($sql);

    // Prepare search parameters
    $searchParam = '%' . $search . '%';
    $stmt->bind_param("sssss", $searchParam, $searchParam, $searchParam, $searchParam, $searchParam);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="search.css">

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




<div class="profile-container1">
    <h1>Search Results for: <?php echo htmlspecialchars($search); ?></h1>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($user = $result->fetch_assoc()): ?>
            <div class="profile-box">
                <a href="userprofile.php?username=<?php echo urlencode($user['username']); ?>">
                    <?php echo htmlspecialchars($user['firstname']) . ' ' . htmlspecialchars($user['lastname']); ?>
                </a>
            </div>
        <?php endwhile; ?>
    <?php elseif (empty($search)): ?>
        <p>Please enter in the search bar.</p>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>
</div>



</body>
</html>
