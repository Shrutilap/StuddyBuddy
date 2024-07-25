<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="login.css?v=1.0">

</head>
<body>
   
<div class="info">
    <form action="" method="post">

 
    <div class="l">

<center><h1> LOG IN</h1></center>
</div>


    <div class="input-group">

    <label for="u_gender">Username:</label>
    <input type="text" id="u_gender" name="username" required>

    </div>



                <div class="input-group">
                   

                   <label for="u_gender">Password:</label>
                   <input type="password" id="u_gender" name="password" required>
               
                 </div>


                               <div class="input-group">
                   

                                <label for="u_gender">email:</label>
                                <input type="text" id="u_gender" name="email" required>
               
                               </div>




                               <a data-toggle="tooltip" title="signin" href="signUp.php">Dont have an account?</a><br><br>


                               <div class="bu">







<button class="sub" name="login">
Submit
</button>




<?php include("insertlog.php"); ?>






</div>


<div class="ss">
    <h4 style="font-size: xx-large;">So good to see you back</h4>
</div>






    <p style="    text-align: center;   font-size:large">Get ready to connect explore mentor fellow study buddies!!</p>




    
    </form>
    </div>

    

    

</body>
</html>