<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="sign.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="container">
    
    <div class="main-content">
        <div class="header">
            <h3><strong>Join the community now</strong></h3>
            <hr>
        </div>
        <div class="l-part">
            <form action="" method="post">
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    <input type="text" placeholder="First Name" name="first_name" required="required">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    <input type="text" placeholder="Last Name" name="last_name" required="required">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-lock"></i></span>
                    <input id="password" type="password" placeholder="Password" name="u_pass" required="required">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-user"></i></span>
                    <input id="email" type="email" placeholder="Email" name="u_email" required="required">
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-chevron-down"></i></span>
                    <select name="u_country" required="required">
                        <option disabled>Select your Country</option>
                        <option>Ireland</option>
                        <option>United States of America</option>
                        <option>India</option>
                        <option>Japan</option>
                        <option>UK</option>
                        <option>France</option>
                        <option>Germany</option>
                        <option>Australia</option>
                        <option>South Korea</option>


                    </select>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-chevron-down"></i></span>
                    <select name="u_gender" required="required">
                        <option disabled>Select your Gender</option>
                        <option>Male</option>
                        <option>Female</option>
                        <option>Others</option>
                    </select>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-calendar-alt"></i></span>
                    <input type="date" placeholder="Birthday" name="u_birthday" required="required">
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    <input type="text" placeholder="current University" name="uni" required="required">
                </div>

				<div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-chevron-down"></i></span>
                    <select name="qua" required="required">
                        <option disabled>Highest Qualification</option>
                        <option>Highshool</option>
                        <option>Graduation</option>
                        <option>Post-Graduation</option>
						<option>Masters</option>
                        <option>Diploma</option>
						<option>PHD</option>


                    </select>
                </div>

                
                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    <input type="text" placeholder="Degree" name="degree" required="required">
                </div>


                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-pencil-alt"></i></span>
                    <input type="text" placeholder="Acheivements" name="other" >
                </div>

                <div class="input-group">
                    <span class="input-group-addon"><i class="fas fa-chevron-down"></i></span>
                    <select name="et" >
                        <option disabled>Entrance exams</option>
                        <option>Gre</option>
                        <option>Jee</option>
                        <option>Neet</option>
                    </select>
                </div>



                <div class="form-group">
                    <label for="agree"><i class="fas fa-check"></i> Phd</label>
                    <select id="agree" name="phdy">
                        <option value="" disabled>PHD</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                        <option value="no">Pursuing</option>

                    </select>
                </div>


                <div class="form-group">
                    <label for="agree"><i class="fas fa-check"></i> Masters Abroad</label>
                    <select id="agree" name="mastersy">
                        <option value="" disabled>Masters</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                        <option value="no">Pursuing</option>

                    </select>
                </div>


                <div class="form-group">
                    <label for="agree"><i class="fas fa-check"></i> restrictioins</label>
                    <select id="agree" name="res">
                        <option value="" disabled>Chatting restricted to </option>
                        <option value="yes">Females</option>
                        <option value="no">Males</option>
                        <option value="no">No</option>

                    </select>
                </div>




                <br><br> <a data-toggle="tooltip" title="Signin" class="oo" href="login.php">Already have an account?</a><br><br>
                <center><button id="signup" name="sign_up">Signup</button></center>
                <?php include("insert.php"); ?>
            </form>
        </div>
    </div>
</div>
</body>
</html>
