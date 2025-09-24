<?php
 
if(isset($_REQUEST['login'])) {

// get username from form
$username = clean_input($dbconnect, $_REQUEST['username']);
$options = ['cost' => 9,];

// Get username and hashed password from database
$login_sql="SELECT * FROM `users` WHERE `username` = '$username'";
$login_query=mysqli_query($dbconnect,$login_sql);
$login_rs = mysqli_fetch_assoc($login_query);

// Hash password and compare with password in database
if (password_verify($_REQUEST['password'], $login_rs['password'])) {

// password matches
echo 'password is valid';
$_SESSION['admin'] = $login_rs['username'];
header("Location: index.php?page=add_movie");

} // end valid password if

else {

   echo 'password is invalid';
   unset($_SESSION);
   $login_error = "Incorrect username or password";
   header("Location: index.php?page=login&error=$login_error");

} // end invalid password else

} // end if login button has been pushed


?>