<?php 
session_start();

include("connection.php");
include("function.php");


$user_data = check_login($con);
$curent_user = $user_data;


$row = get_one_post($_GET,$con,$_SESSION);

		
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Comments | rush</title>
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



<!-- post area, start-->
		<div style=" min-height:400px; flex:3; padding: 20px;" id="friends_bar" >
			
			<div style="border: solid thin #aaa;padding: 10px;">
				
			<?php 
				
				if (is_array($row)) 
				
				{
					echo"<img src='$row[image]' style='width:100%' />";

				}
					

			?>
				<br style="clear: both;">
			</div>
				

			
		</div>
	</div>
</div>

</body>
</html>
