<?php
session_start();

include("connection.php");
include("function.php");

  //check_login is a function
 $user_data = check_login($con);

 //making sure that we only one user on the header
 $curent_user = $user_data;
 
if (is_array($profile_data)) 
{
	$user_data = $profile_data;

}

$id = $user_data["user_id"];

//querying by getting all users that's not me, 
$query = "select * from users where user_id != '$id'  ";
$result = mysqli_query($con, $query);

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>browse || rush</title>
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
		#text_box_settings{
		align-content: center;
		width: 100%;
		height: 20px;
		border-radius: 5px;
		padding: 4px;
		margin: 10px;
	}

	#profil_pic{
		width: 150px;
		margin-top: -300px;
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
		background-color: lightgrey;
		margin-right: 10px;
		margin-top: 20px;
		padding: 8px;
		display: flex;
		flex-direction: column;
	}

	#friends{

		clear: both;
		padding: 8px;
		color: darkblue;
		width: 200px;
		
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
		width: 80px;

	}
		#follow_button{
		float: right;
		background-color: #FA8072;
		border: none;
		color: whitesmoke;
		padding: 4px;
		font-size: 14px;
		border-radius: 2px;
		width: 150px;

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
	<?php
//heaeder
	include("header.php");

	?>
		<div style="width: 800px; margin: auto; min-height: 500px;">

	<div style="padding: 10%; background-color: #f0f8ff">
	
	<?php 

			if ($result) 
			{
				
				foreach ($result as $row) 
				{
					//$row = get_user($row['user_id'],$con);
					include("friends.php");
				}
				

			}
			
	?>
	</div>

</div>
</body>
</html>