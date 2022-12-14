<?php 

session_start();

	include("connection.php");
	include("function.php");

	$user_data = check_login($con);

	$curent_user = $user_data;
	
if ($_SERVER['REQUEST_METHOD'] == "POST") 
{
	
 if(isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") 
	{

		if ( $_FILES['file']['type'] == 'image/jpeg') 
		{
			
			$file_size = (1024 * 1024) * 7; 
			if ($_FILES['file']['size'] < $file_size) 
			{

				
				$img_folder = "uploaded_profiles/" . $user_data['user_id']."/"; 

				if (!file_exists($img_folder)) 
				{
					mkdir($img_folder, 0777, true); //make foder.. 0777 file permission

				
					file_put_contents($img_folder . "index.php", 
						"<h1 style='color:red'> Error 404 </h1>");
				}

				$filename = $img_folder . generate_imgname(14) ;

				
				move_uploaded_file($_FILES['file']['tmp_name'], $filename);

				$update = "profile";
				if (isset($_GET['update'])) 
				{
					$update = $_GET['update'];
					
				}
				if ($update == "cover") 
				{
					
					if (file_exists($user_data['cover_img'])) 
					{
						unlink($user_data['cover_img']);
					}

					$image = resize_img($filename, $filename, 1500,1500);
				}
				else
				{
					
					if (file_exists($user_data['profile_img'])) 
					{
						unlink($user_data['profile_img']);
					}

				
					$image = resize_img($filename, $filename, 1500,1500);
				}
				
				
				if (file_exists($filename)) 
				{
					
					$user_id = $user_data['user_id'];
	
					if ($update == "cover") 
					{
						$query = "update users set cover_img = '$filename'
					 	where user_id = '$user_id' limit 1";
					 	
					 	$_POST['is_cover_img'] = 1;
					}
					else
					{

						$query = "update users set profile_img = '$filename'
					 	where user_id = '$user_id' limit 1";

					 	
					 	$_POST['is_profile_img'] = 1;
					}	

					mysqli_query($con,$query);
		
	
					create_post($user_id, $_POST,$con, $filename);

					header("Location:profile.php");
					die();
				}
				
			}
			else
			{
				echo "<p style='text-align:center; color:red'>File is too big, </br>
				Please Try A Smaller Size Image</p>";
			}
		}
		else
		{
		echo "<p style='text-align:center; color:red'>Invalid Image Format, </br> Only jpeg Files Allowed </p>";
		}

		
	}
	
	else
	{
		echo "<p style='text-align:center; color:red'>please add a valid file </p>";
	}


}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Change profile image | rush</title>
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

	#share_button{
		float: right;
		background-color: darkblue;
		border: none;
		color: whitesmoke;
		padding: 4px;
		font-size: 14px;
		border-radius: 2px;
		width: 100px;
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
				
			<form method="post" enctype="multipart/form-data">
				<div style="border: solid thin #aaa;padding: 10px;">
					<input type="file" name="file">
					
					<input id="share_button" type="submit" type="submit" value="Post">
					<br><br>


					<div style="text-align: center;">
					<!-- image place holder when changing  -->
					<?php 

				
				if (isset($_GET['update']) && $_GET['update'] == "cover") 

				{
					$update = "cover";
					echo "<img src='$user_data[cover_img]' style ='max-width:500px'> ";
				}
				else
				{
					echo "<img src='$user_data[profile_img]' style ='max-width:500px'> ";
				}

					


					?>
					</div>
				</div>
			</form>

			</div>
		</div>
	</div>

</body>
</html>
