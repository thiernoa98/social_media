
<?php 
$corner_img = "Male.jpg";
if (isset($curent_user) && file_exists($curent_user['profile_img'])) 
{
	$corner_img = get_thumb_profile($curent_user['profile_img']);
}
else
{
	if ($curent_user['gender'] == "Male") 
	{
		$corner_img = "assets/Male.jpg"; 
		
	}
	else
	{
		$corner_img = "assets/Female.jpg";
	}
}


?>


<div id="grey_bar">
	<form method="get" action="search.php">
		<div style="width: 800px; margin: auto; font-size: 35px;">
		
			<a href="Timeline.php" style="text-decoration: none; ">
				<?php echo "<img src='home.jpg' style='width:35px'"?> </br>
				Rush 
			</a> 

			<!-- search bar-->
			&nbsp &nbsp &nbsp <input type="text" id="search_box" name="find" placeholder="search for people">
			

			<a href="profile.php?id=<?php echo $_SESSION['user_id'] ?>"> 
			<img src="<?php echo $corner_img ?>" style="width:40px; float: right;">
			</a>
			<a href="logout.php">
				<span style="font-size: 15px; float: right; margin: 10px;"> Sign out</span>
			</a>
		</div>
	</form>
</div>
