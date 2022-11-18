<div id="friends">

		<!-- check if user is female or male-->
	<?php 
	//assign image to female first to avoid using else statement
	$image = "Female.jpg";
	if ($row['gender'] == "Male") 
	{
		$image = "Male.jpg";
	}

    if (file_exists($row['profile_img'])) 
	{
		//get_thumb_profile shape the image
		$image = get_thumb_profile($row['profile_img']);
	}

	?>

	<!-- we are using query string(?) to assign each user to its profile -->
	<a href="profile.php?id=<?php echo $row['user_id'] ?>">

	<img id="friend_img" src="<?php echo $image ?>">
	
	<?php echo $row['first_name'] . " " . $row['last_name']; ?>

	</a>

</div>