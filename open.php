<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study budy login/signup</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
  
<div class="row">

        <h2>Study buddy</h2>


</div>


<div class="img">

     <div class="img"><img src="81a6ebe1328e3217a57f4d690d0af2a8.jpg"  title="logo">  </div>


     <div class="buttons">

        <button class="b" onclick="window.location.href='signUp.php';" style="background-color: #FFB4C2; height: 70px; width: 100px; border: none;">Sign Up</button>

        <button class="b" onclick="window.location.href='login.php';" style="background-color: #FFB4C2;height: 70px;width: 100px;border: none;">login</button>
     </div>


</div>

<div class="info">


    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Eum obcaecati minima quasi magnam voluptatem iure facere! Asperiores suscipit exercitationem in esse fugit totam harum dolore quis vel. Impedit, laboriosam illum.</p>
</div>

<?php
					if(isset($_POST['signup'])){
						echo "<script>window.open('signUp.php','_self')</script>";
					}
				?>
				<button id="login" class="btn btn-info btn-lg" name="login">Login</button><br><br>
				<?php
					if(isset($_POST['login'])){
						echo "<script>window.open('login.php','_self')</script>";
					}
				?>


</body>
</html>
