<!-- post area, images will be within this div-->
<div style=" min-height:400px; width: 100%; background-color:lightgrey; text-align: center;" >
	<div style="padding: 10%;">
	<?php 

	//querying to display images, by looking for has_img 
	$query = "select * from contents where has_img = 1 && userid = $user_data[user_id] order by id desc limit 30";
	$result = mysqli_query($con, $query);

		if ($result) 
		{
			foreach ($result as $row) 
			{
				echo "<a href='comments.php?content_id=$row[content_id]'>";
				echo "<img src='".get_thumb_post($row['image'])."' style='width:200px; margin:15px' />";
				echo "</a>";
			}

		}
	else
	{
		echo "<h2 style='color:#FF5733' >Sorry! " .$result['first_name']. " has not Uploaded Any Photos </h2>";
	}


	?>


	</div>
</div>