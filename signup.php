<?php 
session_start();

	include("connection.php");
	include("function.php");

	if ($_SERVER['REQUEST_METHOD'] == "POST") 
	{
		// COLLECT DATA FROM the POST variable
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$email = $_POST['email'];
		$gender = $_POST['gender'];
		$password = $_POST['password'];
		$profile_img = $_POST['profile_img'];
		$cover_img = $_POST['cover_img'];
		$likes = $_POST['p_likes'];
		$about = $_POST['about'];
		//to be genereted by computer
		$url_address = strtolower($first_name).'.'.($last_name);
		$likes = 0;
		
		if (!empty($first_name) && !empty($password) && !is_numeric($first_name) ) 
		{
			// if not !empty, then save to database
			
			$user_id = random_num(20); // first varible for user_id with random numbers
			
			$query = "insert into users (user_id,first_name, last_name, email, gender, password, url_address, profile_img,cover_img,p_likes,about) values ('$user_id','$first_name','$last_name','$email','$gender', '$password', '$url_address', '$profile_img','$cover_img','$likes','$about')";

			//save infos
			mysqli_query($con,$query);

			// after signup, send user to login page
			header("Location: login.php");
			die; 

			
		}
		else
		{
			
			echo "<p style='text-align:center; color:red'>Please Enter Some Valid Information!";

		}
	}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Signup</title>
</head>
<body>

	<style type="text/css">
		
		#text{

			height: 25px;
			border-radius: 5px;
			padding: 4px;
			border: solid thin;
			width: 100%;
		}

		#button{

			padding: 10px;
			width: 100px;
			color: white;
			background-color: black;
			border: none;
		}

		#box{
			background-color: lightblue;
			margin: auto;
			width: 300px;
			padding: 20px;
		}

		#error-txt{
			color: #721c24;
			background-color: #f8d7da;
			margin-bottom: ;
		}
		#dropdown {
  position: relative;
  display: inline-block;
}

	</style>


	<div id="box">

		<form method="post">
			<div style="font-size: 20px; margin: 10px;">Signup</div><br>
			<input id="text" type="text" name="first_name" placeholder="First Name"><br><br>
			<input id="text" type="text" name="last_name" placeholder="Last Name"><br><br>
			<input id="text" type="text" name="email" placeholder="E-mail Address"><br><br>
			<!--<input id="text" type="text" name="gender" placeholder="Gender"><br><br>-->
			<span style="font-weight: normal; text-align: center;">Gender</span>
			<select id="text" name="gender"> 
				<option>Male</option>
				<option>Female</option>
			</select><br><br>
			<input id="text" type="password" name="password" placeholder="Password"><br><br>
			<!--<label>select an image <input type="file" name="file"><br><br> -->

			<input id="button" type="submit" value="Signup" ><br><br>

			<a href="login.php">Already have an account? Login Here</a>

		</form>
		
	</div>

</body>
</html>














