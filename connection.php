<?php 

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "root" ; 
$dbname = "login_sample_dbs";


//connect to database
if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
	die("Connection Failed");
}

