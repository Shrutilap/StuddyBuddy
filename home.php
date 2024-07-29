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
                    <div class = "front">

                    </div>
                    <div class = "back">
                    <h3><?php echo htmlspecialchars($profile['firstname']) . " " . htmlspecialchars($profile['lastname']); ?></h3>
                    <p><strong></strong> <?php echo htmlspecialchars($profile['country']); ?></p>
                    <p><strong></strong> <?php echo htmlspecialchars($profile['university']); ?></p>
                    <a href="userprofile.php?username=<?php echo htmlspecialchars($profile['username']); ?>">View Profile</a>
                    </div>
                   
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>


<div class="foo">

        <p><p>Copyright &copy; 2024. All rights reserved.</p></p>
       <hr>
<div class="i">

    <a href="https://www.facebook.com" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="" fill="black" class="bi bi-facebook" viewBox="0 0 16 16">
  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
</svg></a>
    <a href="https://www.twitter.com" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="" fill="black" class="bi bi-twitter-x" viewBox="0 0 16 16">
  <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
</svg></a>
    <a href="https://www.instagram.com" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" width="1.5rem" height="" fill="black" class="bi bi-instagram" viewBox="0 0 16 16">
  <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
</svg></i></a>


</div>
    </div>

            
        

<script src = "index.js"></script>

</body>
</html>
