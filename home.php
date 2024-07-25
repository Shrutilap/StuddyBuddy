<?php
session_start();

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

// Fetch the logged-in user's profile
$current_user = $_SESSION['username'];
$sql_user = "SELECT firstname FROM users WHERE username = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("s", $current_user);
$stmt->execute();
$result_user = $stmt->get_result();

if ($result_user->num_rows > 0) {
    $profile = $result_user->fetch_assoc();
} else {
    $profile = ['firstname' => 'User'];
}

// Fetch 6 random user profiles
$sql = "SELECT username, university, firstname, lastname, country FROM users ORDER BY RAND() LIMIT 6";
$result = $conn->query($sql);

$profiles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $profiles[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Social Network</title>
    <link rel="stylesheet" href="home.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>

 <!--navbar-->
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




    <main>
        <div class="content">
            <!--Text slider-->
           <div class = "slider">
                <div class = "slides">
                     <!--radio buttonss-->
                     <input type = "radio" name = "radio-btn" id = "radio1">
                     <input type = "radio" name = "radio-btn" id = "radio2">
                     <input type = "radio" name = "radio-btn" id = "radio3">
                     <input type = "radio" name = "radio-btn" id = "radio4">
                    <!--texts-->
                    <div class = "slide first">
                        <h1>Collaborate, Elevate, Celebrate</h1>
                    </div>
                    <div class = "slide second">
                        <h1>Find, Connect, Achieve</h1>
                    </div>
                    <div class = "slide third">
                        <h1>Collaborative Learning Made Easy</h1>
                    </div>
                    <div class = "slide fourth">
                        <h1>Your Study Synergy Awaits</h1>
                    </div>
                    <!--auto-navigation-->
                    <div class = "navigation-auto">
                        <div class = "auton-btn1"></div>
                        <div class = "auton-btn2"></div>
                        <div class = "auton-btn3"></div>
                        <div class = "auton-btn4"></div>
                    </div>
                    <div class = "manual-navigation">
                        <label for = "radio1" class = "manual-btn"></label>
                        <label for = "radio2" class = "manual-btn"></label>
                        <label for = "radio3" class = "manual-btn"></label>
                        <label for = "radio4" class = "manual-btn"></label>
                    </div>
                    
                </div>

         
    </main>












<div class="a">

<p>Hello, <?php echo isset($profile['firstname']) ? htmlspecialchars($profile['firstname']) : 'User'; ?>! Welcome back.</p>

<div class="illustration">

                <img src="maindesign5.png" alt="Collaboration Illustration">
            </div>

</div>



    






<div class="home-container">

    <div class="profiles-section">
        <h2>Some of our Members</h2>
        <div class="profiles-grid">
            <?php foreach ($profiles as $profile): ?>
                <div class="profile-card">
                    <h3><?php echo htmlspecialchars($profile['firstname']) . " " . htmlspecialchars($profile['lastname']); ?></h3>
                    <p><strong></strong> <?php echo htmlspecialchars($profile['country']); ?></p>
                    <p><strong></strong> <?php echo htmlspecialchars($profile['university']); ?></p>

                    <a href="userprofile.php?username=<?php echo htmlspecialchars($profile['username']); ?>">View Profile</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<div class="foo">

        <H2>CONNECT WITH US</H2>
<div class="i">

    <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook-f"></i></a>
    <a href="https://www.twitter.com" target="_blank"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>


</div>
    </div>

            
        

<script src = "index.js"></script>

</body>
</html>
