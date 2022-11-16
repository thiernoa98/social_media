<?php 

session_start();

// check if user_id is set or logedin, then we unset it
if (isset($_SESSION['user_id']))
{
	unset($_SESSION['user_id']);
} 

//send it back to the login page
header("Location: login.php");
die;