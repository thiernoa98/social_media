<?php 
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($con);

$curent_user = $user_data;

if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
	$id = $user_data['user_id'];
	
	$result = create_post($id, $_POST,$con, $_FILES);

		//if result is empty, don't repost previous posts, just die.
		if ($result == "") 
		{
			//redirect to the same page again
			header("Location: Timeline.php");
			die;
				
		}
		else
		{
			echo $result;
		}

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

			<div style=" min-height:400px; flex:1">

				<div id="friends_bar" style="text-align: center; color: darkblue;">
						
					<a style="text-decoration: none;" 
					href="profile.php" >
					
				
						<img src="<?php echo $corner_img ?>" 
						id="profil_pic"><br>

						<?php 
							echo $curent_user['first_name']." ".$curent_user['last_name'];

						?>
						
					</a>
					<div style="text-align: center;  padding: 50px;">
						<a href="Browse_people.php?id=<?php echo $user_data['user_id'] ?>" style="text-decoration: none;"> Browse for People </a>
						 <?php echo "<img src='assets/search.png' style='width:20px'"?>
					  <br>

					</div>

				</div>

			</div> 


<!-- post area-->
			<div style=" min-height:400px; flex:3; padding: 20px; min-width: 400px;" id="friends_bar" >
				
				<div style="border: solid thin #aaa;padding: 10px;">
					
					<!--  to upload a file, we must have the enctype -->
					<form method="post" enctype="multipart/form-data">
						<textarea name = "content" placeholder="what's up"></textarea>
						<input type="file" name="file">
						<input id="share_button" type="submit"value="Share"><br>
					</form>
				</div>

				<div id="post_bar">

					<!--post 1-->
					<?php 

					$followers = get_following($_SESSION['user_id'], "user", $con);

					$followers_ids = false; //replace isset

					if (is_array($followers)) 
					{
						$followers_ids = array_column($followers, "user_id");
						
						$followers_ids = implode("','", $followers_ids);
						
					}

					if ($followers_ids) 
					{
						//adding my own posts to timeline
						$id = $user_data['user_id'];

						
						$query = "select * from users inner join contents on users.user_id = contents.userid where contents.parent = 0 && users.user_id = '$id' || users.user_id in('".$followers_ids."') order by contents.id desc limit 25";

						$result  = mysqli_query($con,$query);
					
					}
					else
					{
						//adding my own posts to timeline
						$id = $user_data['user_id'];

						$query = "select * from users inner join contents on users.user_id = contents.userid where contents.parent = 0 && users.user_id = '$id' || users.user_id in('".$followers_ids."') order by contents.id desc limit 25";

						$result  = mysqli_query($con,$query);
					}

					if ($result) 
					{
						
							foreach($result as $row)
						{
							

							include("post.php");
						}
						

					}
					
					?>

				</div>

			</div>

		</div>

	</div>

</body>
</html>
