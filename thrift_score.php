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

// Handle new item submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_item'])) {
    $username = $_SESSION['username'];
    $item_name = htmlentities(mysqli_real_escape_string($conn, $_POST['item_name']));
    $description = htmlentities(mysqli_real_escape_string($conn, $_POST['description']));
    $price = htmlentities(mysqli_real_escape_string($conn, $_POST['price']));
    $image_url = htmlentities(mysqli_real_escape_string($conn, $_POST['image']));

    // Insert new item into the database
    $sql = "INSERT INTO items (username, item_name, description, price, image, createdat) VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssds", $username, $item_name, $description, $price, $image_url);

    if ($stmt->execute()) {
        echo "<script>alert('Item submitted successfully.'); window.location.href='thrift_score.php';</script>";
    } else {
        echo "<script>alert('Error submitting item.');</script>";
    }

    $stmt->close();
}

// Handle item deletion
if (isset($_GET['delete_item'])) {
    $item_id = intval($_GET['delete_item']);
    $sql = "DELETE FROM items WHERE id = ? AND username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $item_id, $_SESSION['username']);

    if ($stmt->execute()) {
        echo "<script>alert('Item deleted successfully.'); window.location.href='thrift_score.php';</script>";
    } else {
        echo "<script>alert('Error deleting item.');</script>";
    }

    $stmt->close();
}

// Fetch items from the database
$sql = "SELECT * FROM items ORDER BY createdat DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thrift Store</title>
    <link rel="stylesheet" href="thrift.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="profile.css?v=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

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



<div class="store-container">
    <h1>Thrift Store</h1>

    <!-- Item Submission Form -->
    <form action="thrift_score.php" method="post" class="item-form">
        <input type="text" name="item_name" placeholder="Item Name" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="number" step="0.01" name="price" placeholder="Price" required>
        <input type="text" name="image" placeholder="Image URL" required>
        <button class="j" type="submit" name="submit_item">Post Item</button>
    </form>

    </div>

   <!-- Display Items -->
<div class="items-grid">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="item-box">
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Item Image">
                <div class="item-info">
                    <p><strong><?php echo htmlspecialchars($row['item_name']); ?></strong></p>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <p><strong>Price:</strong> Rs<?php echo htmlspecialchars($row['price']); ?></p>
                    <p><strong>Posted by:</strong> 
                    <p>
                    <a href="userprofile.php?username=<?php echo urlencode($row['username']); ?>" class="post-username">
                        <strong><?php echo htmlspecialchars($row['username']); ?></strong>
                    </a> - <?php echo htmlspecialchars($row['createdat']); ?>
                </p>          </div>
                <!-- Delete Button -->
                <?php if ($row['username'] == $_SESSION['username']): ?>
                    <a href="thrift_score.php?delete_item=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No items available.</p>
    <?php endif; ?>
</div>





</body>
</html>
