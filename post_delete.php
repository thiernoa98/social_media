
<div id="post">
<div style="margin-right: 5px;">

<?php 

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
	<?php echo htmlspecialchars($row['first_name'])." ".htmlspecialchars($row['last_name']); 
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
		$post_img = get_thumb_post($row['image']);
		echo "<img src='$post_img' style='width:90%'/>";
		
	}

	?>
</div>

</div>
