<div id="friends">

<?php 
//assign image to female frst, avoid using else statement
$image = "assets/Female.jpg";
if ($row['gender'] == "Male") 
{
	$image = "assets/Male.jpg";
}

if (file_exists($row['profile_img'])) 
{
	
	$image = get_thumb_profile($row['profile_img']);
}

?>

<!-- using query string(?) to assign each user to its profile -->
<a href="profile.php?id=<?php echo $row['user_id'] ?>">

<img id="friend_img" src="<?php echo $image ?>">

<?php echo $row['first_name'] . " " . $row['last_name']; ?>

</a>

</div>
