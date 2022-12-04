
<div id="post">
<div style="margin-right: 5px;">

<!-- posting images on the side of each post -->
<?php 
 $user_data = check_login($con);
//$roww = my_post($_GET, $con, $_SESSION);

	$image = "Female.jpg";
	if ($row['gender'] == "Male") 
	{
		$image = "Male.jpg";
	}


    if (file_exists($row['profile_img'])) 
	{	
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

	if (file_exists($row['image']) ) 
	{
		echo"<a href='image_view.php?content_id=$row[content_id]'>";
		$post_img = get_thumb_post($row['image']);
		echo "<img src='$post_img' style='width:90%'/>";

		echo"</a>";
		
	}

	?>
	<br><br>
<?php 
	
$likess = "";

$likess = ($row["likes"] > 0) ? '('."<img src='bl.jpg' style='width:20px; height:15px'>".$row["likes"]. ')' : "";

?>


<!-- using a query string to tell thee type wee're liking, post or profile ...-->
<a href="like.php?type=content&id=<?php echo $row['content_id']?>" style="text-decoration: none;">
	Like <?php echo $likess ?></a> .

	

<!-- date -->
<span style="color: #999">
<?php echo $row['date'] ?>

</span> 

<!-- Edit and delete -->
<span style="color: #999; float: right; ">

<!-- show this only when I own the post-->
<?php 

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

		//checking if a person has already liked the post
		//then decode the array with jsondecode, make it an array again
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
