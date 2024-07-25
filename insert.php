<?php

include("includes/connection.php");

if (isset($_POST['sign_up'])) {
    // Code to handle the form submission
    $first_name = htmlentities(mysqli_real_escape_string($con, $_POST['first_name']));
    $last_name = htmlentities(mysqli_real_escape_string($con, $_POST['last_name']));
    $pass = htmlentities(mysqli_real_escape_string($con, $_POST['u_pass']));
    $email = htmlentities(mysqli_real_escape_string($con, $_POST['u_email']));
    $country = htmlentities(mysqli_real_escape_string($con, $_POST['u_country']));
    $gender = htmlentities(mysqli_real_escape_string($con, $_POST['u_gender']));
    $birthday = htmlentities(mysqli_real_escape_string($con, $_POST['u_birthday']));
    $uni = htmlentities(mysqli_real_escape_string($con, $_POST['uni']));
    $qua = htmlentities(mysqli_real_escape_string($con, $_POST['qua']));
    $degree = htmlentities(mysqli_real_escape_string($con, $_POST['degree']));
    $ach = htmlentities(mysqli_real_escape_string($con, $_POST['other']));
    $ee = htmlentities(mysqli_real_escape_string($con, $_POST['et']));
    $phdy = htmlentities(mysqli_real_escape_string($con, $_POST['phdy']));
    $mastersy = htmlentities(mysqli_real_escape_string($con, $_POST['mastersy']));
    $res = htmlentities(mysqli_real_escape_string($con, $_POST['res']));

    $newgid = sprintf('%05d', rand(0, 999999));

    $username = strtolower($first_name . "_" . $last_name . "_" . $newgid);

    $check_email_query = "SELECT * FROM users WHERE email='$email'";
    $run_email = mysqli_query($con, $check_email_query);

    $check = mysqli_num_rows($run_email);

    if ($check == 1) {
        echo "<script>alert('Email already exists, please try using another email')</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
        exit();
    }

    $insert = "INSERT INTO users (
        firstname, lastname, username, password, email, country, dob, university, qualifications, 
        degree, other, exam, phd, masters, gender, regd, restriction
    ) VALUES (
        '$first_name', '$last_name', '$username', '$pass', '$email', '$country', '$birthday', 
        '$uni', '$qua', '$degree', '$ach', '$ee', '$phdy', '$mastersy', '$gender', NOW(), '$res'
    )";

    $query = mysqli_query($con, $insert);

    if ($query) {
        echo "<script>alert('Well done $first_name, you are good to go.')</script>";
        echo "<script>window.open('login.php', '_self')</script>";
    } else {
        echo "<script>alert('Registration failed, please try again!')</script>";
        echo "<script>window.open('signup.php', '_self')</script>";
    }
}

?>
