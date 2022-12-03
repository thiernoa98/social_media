<?php 
session_start();

	include("connection.php");
	include("function.php");
	
	$user_data = check_login($con);
	$curent_user = $user_data;

	$row = get_one_post($_GET,$con,$_SESSION);
	
	$error = "";
	if (!$row) 
	{
		 $error = "error, no file found";
	}

	if (isset($_SERVER['HTTP_REFERER'])&& !strstr($_SERVER['HTTP_REFERER'], "delete.php")) 
	{
		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];

	}


	if ($_SERVER['REQUEST_METHOD']== "POST") 
	{
		$content = delete_post($_POST['content_id'], $con);

		header("Location: ".$_SESSION['return_to']);
		die;
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Timeline | rush</title>
</head>

<style type="text/css">

	#grey_bar {
		height: 50px;
		background-color: lightgrey;
		color: black;

	}

	#search_box{

		width: 400px;
		height: 20px;
		border-radius: 5px;
		padding: 4px;
		background-image: url(search.png);
		background-repeat: no-repeat;
		background-size: 20px;
		background-position: right center;
	}

	#profil_pic{
		width: 150px;
		border-radius: 50%;
		border: solid 2px white;
	}

	#menu_buttons{

		width: 100px;
		display: inline-block;
		margin: 2px;

	}

	#friend_img{
		width: 75px;
		float: left;
		margin: 2px;

	}

	#friends_bar{
		background-color: white;
		min-height: 400px;
		margin-top: 20px;
		padding: 8px;

	}

	#friends{

		clear: both;
		padding: 8px;
		color: darkblue;
	}

	textarea{
		width: 100%;
		border: none;
		font-family: tahoma;
		font-size: 14px;
		height: 70px;
	}

	#share_button{
		float: right;
		background-color: darkblue;
		border: none;
		color: whitesmoke;
		padding: 4px;
		font-size: 14px;
		border-radius: 2px;
		width: 50px;
	}

	#post_bar{
		margin-top: 20px;
		background-color: lightgrey;
		padding: 10px;
	}

	#post{
		padding: 4px;
		font-size: 16px;
		display: flex;
		margin-bottom: 25px;
		
	}

</style>

<body>
	<!-- top bar -->
	<?php

	include("header.php");

	?>


	<div style="width: 800px; margin: auto; min-height: 500px;">


<!-- side profile area-->

		<div style="display: flex;">



<!-- post area-->
			<div style=" min-height:400px; flex:3; padding: 20px;" id="friends_bar" >
				
				<div style="border: solid thin #aaa;padding: 10px;">
					
			
					<form method="post"> 
						
						
						<?php 
						 
						 //who can delete the post
						if ($row['user_id'] != $_SESSION['user_id']) 
						{
							echo "<h2 style='color:red; text-align:center'> Access Denied! You Cannot Delete this Post! </h2>";
						}
						 else
						 {
							echo "Are you sure you wnat to delete this content? <br>
							<hr> ";
							
							$user = get_user_profile($row['userid'],$con);
							include("post_delete.php");

							echo "<input type='hidden' name = 'content_id' 
							value='$row[content_id]'> <br>";

							echo "<input id='share_button' type='submit' value='Delete'><br>";
						}	
						
						?>

					</form>
				</div>

				
			</div>
		</div>
	</div>

</body>
</html>
