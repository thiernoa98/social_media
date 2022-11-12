<?php 
session_start();

	include("connection.php");
	include("function.php");

	if ($_SERVER['REQUEST_METHOD'] == "POST") 
	{
		// COLLECT DATA FROM the POST variable
		$email = $_POST['email'];
		$password = $_POST['password'];

		if (!empty($email) && !empty($password) ) 
		{
			// if not !empty, then read from database
			//we use query to retrive data from the database
			$query = "select * from users where email = '$email' limit 1"; //we check if email is correct
			
			//get results
			$result = mysqli_query($con,$query);

			
			if ($result) 
			{
				if ($result && mysqli_num_rows($result) > 0) 
				{
					$user_data = mysqli_fetch_assoc($result);


					if ($user_data['password'] === $password)
					{
						// now that we are logged in, we confirm it by assigning $_SESSION (the login checker)
						$_SESSION['user_id'] = $user_data['user_id'];

						// after login, send user to main page, profile.php
						header("Location: profile.php");
						die; 
					}
				}
			}

			echo "<p style='text-align:center; color:red;'>Wrong username or password! </p>";
		}
		else
		{
			
			echo "<p style='text-align:center; color:red'> Please Enter Some Valid Information! </p>";

		}
	}


?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
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
			background-color: greenyellow;
			margin: auto;
			width: 300px;
			padding: 20px;
		}

	</style>

	<div id="box">

		<form method="post">
			<div style="font-size: 20px; margin: 10px;">Login</div><br>

			<input id="text" type="text" name="email" placeholder="E-mail"><br><br>
			<input id="text" type="password" name="password" placeholder="Password"><br><br>

			<input id="button" type="submit" value="Login" ><br><br>

			<a href="signup.php">Don't have an account? Signup Here</a>

		</form>
		
	</div>

</body>
</html>














