<?php 
session_start();

include("connection.php");
include("function.php");

 $user_data = check_login($con);

 $curent_user = $user_data;


 $profile_data = get_user_profile($_GET, $con);


if (is_array($profile_data)) 
{
	$user_data = $profile_data;

}


 // posting codes begin
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
	if (isset($_POST['first_name'])) 
	{
		//call the settings 
		$settings = save_settings($_SESSION['user_id'],$_POST,$con);
		
	}
	else //create a post
	{

		$id = $user_data['user_id'];
		
		$result = create_post($id, $_POST,$con, $_FILES);

				if ($result == "") 
			{
				
				//redirect to the same page again
				header("Location: profile.php");
				die;
			}
			else
			{
				echo $result;

			}

	}
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>profile || rush</title>
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
	<!-- top bar --> 			
<!-- calling the header class-->
	<?php

	include("header.php");

	?>


	<div style="width: 800px; margin: auto; min-height: 500px;">
		<div style="background-color: white; text-align: center; color:#405d9b">
				<?php 
					//setting the cover to empty for new users
				$image ="cover.jpeg";
				if (file_exists($user_data['cover_img'])) 
				{
					//call the funtion with the cropped image
					$image = get_thumb_cover($user_data['cover_img']);
				}

				?>
			<img src="<?php echo "$image"?>" style="width: 100%">


			<!-- profile pic -->
			<span style="font-size: 12px;">

				<?php 
				//setting the profile to empty for new users
				$image = "Female.jpg"; 

				if ($user_data['gender'] == "Male") 
				{
					$image = "Male.jpg"; 
				}

				if (file_exists($user_data['profile_img'])) 
				{
					$image = get_thumb_profile($user_data['profile_img']);

				}

				?>

				<img src="<?php echo $image ?>" id="profil_pic"><br>

				<a style="text-decoration: none; color:#f0f" href="upload_profile_img.php?update=profile">
					upload profile | |
				</a>
	<!--here we are using query string to change both profile and cover using one page -->
				<a style="text-decoration: none; color:#f0f" href="upload_profile_img.php?update=cover">
					upload cover
				</a>

			</span>


			<br> 
			<div style="font-size: 25px;"> 
			  <a href="profile.php?id=<?php echo $user_data['user_id'] ?>" 
			  	style="text-decoration: none;">
					<?php echo $user_data['first_name']. " " . $user_data['last_name']?>
				</a>
			</div>

					 <!-- follow button for user-->
	 <?php 

	

	 		$myfollowers = ""; 
	 	
	 			
	 			if ($user_data['p_likes'] > 0) 
	 			{
	 			
	 				
	 				$script = " Followers";
	 				if ($user_data['p_likes'] == 1) 
	 				{
	 					$script = " Follower";
	 				}

	 				$myfollowers = $user_data['p_likes'].$script;
	 			}



			 //follow display
			 if ($user_data['user_id'] != ($_SESSION['user_id']) ) 
			 {
	
			 			echo "<a href='like.php?type=user&id=".$user_data['user_id']."'>
					<input id='follow_button' type='button' value='Follow ". $myfollowers ."' 
					style='margin-right: 5px;'> 
					</a>";
			 					

			 }
			 else
			 {
			 	 	 	 	
			 	echo "<input id='follow_button' type='button' value='". $myfollowers."' 
					style='margin-right: 5px;'> 
					</a>";
				
			 }
			
			?>

			 <br>
<!-- the buttons -->
			<a href="Timeline.php"><div id="menu_buttons">Timeline</div></a>

			<a href="profile.php?section=about&id=<?php echo $user_data['user_id'] ?>">
				<div id="menu_buttons">About</div></a>
		
			<a href="profile.php?section=following&id=<?php echo $user_data['user_id'] ?>">
				<div id="menu_buttons">Following</div></a>

		  <a href="profile.php?section=followers&id=<?php echo $user_data['user_id'] ?>">
		  	<div id="menu_buttons">Followers</div></a>


			<a href="profile.php?section=photos&id=<?php echo $user_data['user_id'] ?>">
				<div id="menu_buttons">Photos</div></a> 

				<!-- show the settings to owner only-->
			<?php
			if ($user_data['user_id'] == $_SESSION['user_id']) 
			{
				echo "<a href='profile.php?section=settings&id=".$user_data['user_id']."'><div id='menu_buttons'>Settings</div></a>" ;
			}

			?>

			
		</div>

<!-- below cover and profile area-->
			<?php 
			//setting up the sections of the profile page
			$section = "default_profile";
			if (isset($_GET['section'])) 
			{
				$section = $_GET['section'];
			}

			if ($section == "default_profile") 
			{
					//including the profile_html page, with friends and posts
					include("profile_contents.php");
			}
			elseif ($section == "photos") 
			{
				include("profile_photos.php");
			}
			elseif ($section == "followers") 
			{
				include("profile_followers.php");
			}
			elseif ($section == "following") 
			{
				include("profile_following.php");
			}
			elseif ($section == "about") 
			{
				include("profile_about.php");
			}
			elseif ($section == "settings") 
			{
				include("profile_settings.php");
			}


			?>

	</div>



</body>
</html>