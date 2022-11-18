
<div id="post">
<div style="margin-right: 5px;">

<?php 
 $user_data = check_login($con);

	$image = "assets/Female.jpg";
	if ($row['gender'] == "Male") 
	{

		$image = "assets/Male.jpg";
	}


    if (file_exists($row['profile_img'])) 
	{
		//get_thumb_profile shape the image
		$image = get_thumb_profile($row['profile_img']);

	}

?>

	<img src="<?php echo $image?>" style="width:75px; border-radius: 50%;">
</div>
						
						
					
<div style="width: 100%;" >
	<div style="font-weight: bold; color: darkblue; width: 100%;"> 

	<?php 
	echo"<a href='profile.php?id=$row[user_id]' style='text-decoration:none' >";
	echo htmlspecialchars($row['first_name'])." ".htmlspecialchars($row['last_name']); 
	echo"</a>";	


		if ($row['is_profile_img'] || $row['is_cover_img']) 
		{
			$pronoun = "her";
			if ($row['gender'] == "Male") 
			{
				$pronoun = "his";
				
			}

			if ($row['is_profile_img']) 
			{
				echo "<span style = 'font-weight: normal;color:#A10A10A1'> <em> has updated $pronoun profile image </em> </span>";
			}

			if ($row['is_cover_img']) 
			{
				echo "<span style = 'font-weight: normal;color:#A10A10A1'> <em> has updated $pronoun cover image </em> </span>";
				
			}
		
		}


		?>
	</div>

<!-- post script-->
<!-- securing the post against hacks using htmlspecialcharts this will 
	prevent javascript codes from runing someone post it on the post-->
	<?php echo htmlspecialchars($row['content']) ?>
	<br><br>

<!-- post image-->
	<?php 

	//check is there is an actual image 
	if (file_exists($row['image']) ) 
	{

		//calling the resizing function from u_p_img.php
		echo"<a href='image_view.php?content_id=$row[content_id]'>";
		$post_img = get_thumb_post($row['image']);
		echo "<img src='$post_img' style='width:90%'/>";

		echo"</a>";
		
	}

	?>
	<br><br>



<!-- displaying the number of likes-->
<?php 
$likess = "";

//condition, if row > 0, then display row
$likess = ($row["likes"] > 0) ? '('."<img src='assets/bl.jpg' style='width:20px; height:15px'>".$row["likes"]. ')' : "";

?>


<!-- using a query string? to tell the type wee're liking, post or profile ...-->
<a href="like.php?type=content&id=<?php echo $row['content_id']?>" style="text-decoration: none;">  			
	<?php 

		$i_likedd = false;

		if (isset($_SESSION['user_id'])) 
		{
			
		//cheking if someone has already liked it, then continue
			$query = "select likes from likes where type ='content' && content_id = '$row[content_id]' limit 1";

			$result = mysqli_query($con,$query);

			if ($result && mysqli_num_rows($result) > 0) 
			{
				$user_dataa = mysqli_fetch_assoc($result);
				
				if (is_array($user_dataa)) 
				{
					
					//if they have already liked, then prevent them from doing so again 
					$likes = json_decode($user_dataa['likes'],true);
					
					//getting a column of all users who liked the post
					$user_ids = array_column($likes, "user_id");
					if (in_array($_SESSION['user_id'], $user_ids)) 
					{
						$i_likedd = true;
						if ($i_likedd) 
						{
							echo "<img src='assets/bl.jpg' style='width:15px; height: 15px;'>";
						}		
						
							
					}
					else
					{
						echo "<img src='assets/like2.png' style='width:15px; height: 15px;'>";
					}
				}
			}
		}
		?> 

	Like <?php echo $likess ?></a> .  



<!-- displaying the number of comments-->
<?php 
$Comments = "";

//condition, if row > 0, then display row
$Comments = ($row["comments"] > 0) ? '(' .$row["comments"]. ')' : "";


?>

<a href="comments.php?content_id=<?php echo $row['content_id']?>" style="text-decoration: none;"> Comments <?php echo $Comments ?> </a>


<!-- date -->
<span style="color: #999">
<?php echo get_time($row['date']) ?>

</span> 




<!-- Edit and delete -->
<span style="color: #999; float: right; ">

<!-- show this only when I own the post-->
<?php 

	//I checked if it's the user logged in, $user_data, so they can edit their posts
	//if so, they can delete it
	if ($user_data['user_id'] == $row['user_id'])
	{
		
		echo "<a href='edit.php?content_id=$row[content_id]' style='text-decoration: none;'>
			
			Edit
		</a> . 

		<a href='delete.php?content_id=$row[content_id]' style='text-decoration: none;'>

			Delete
		</a>
		";
	
	}


?>
</span>

<!-- the string for people who liked the post -->
<?php

//telling the webpage that I, liked the post
$i_liked = false;

if (isset($_SESSION['user_id'])) 
{
	
	//saving like details, & cheking if someone has already liked it, then continue
	$query = "select likes from likes where type ='content' && content_id = '$row[content_id]' limit 1";

	$result = mysqli_query($con,$query);

	if ($result && mysqli_num_rows($result) > 0) 
	{
		$user_data = mysqli_fetch_assoc($result);
		
		if (is_array($user_data)) 
		{
			
			//if they have already liked, then prevent them from doing so again 
			$likes = json_decode($user_data['likes'],true);
			
			//getting a column of all users who liked the post
			$user_ids = array_column($likes, "user_id");
			if (in_array($_SESSION['user_id'], $user_ids)) 
			{
				$i_liked = true;
			}
		}
	}

}


//displaying the likes on the page
	if ($row['likes'] > 0) 
	{
		echo "<br>";
		echo "<a href='likes_container.php?type=content&&id=$row[content_id]' style='text-decoration:none' >";

		if ($row['likes'] == 1) 
		{
			if ($i_liked) 
			{
				echo  "You liked this post";
			}
			//echo $row['first_name']. " ". " liked your post";
			else
			{
				echo $row['first_name']. " liked this post";
			}
		}
		else
		{
			$script = "others";
			if (( $row['likes']-1) == 1) 
			{
				$script = "other";
			}

			if ($i_liked) 
			{
				echo "You and ".( $row['likes']-1). " $script liked this post";
			}
			else 
			{
				echo $row['likes']. " people liked this post";
			}
		}
		echo "</a>";
	}

?>

	</div>
</div>


