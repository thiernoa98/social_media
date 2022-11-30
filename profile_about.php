<!-- post area, images will be within this div-->
<div style=" min-height:400px; width: 100%; background-color:lightgrey; text-align: center;" >
	<div style="padding: 10%; max-width: 400px; display: inline-block;">
	
<!--  to upload a file, we must have the enctype -->
		<form method="post" enctype="multipart/form-data">


	<?php 


	$settings = get_settings($user_data['user_id'],$con);

	if (is_array($settings)) 
	{
		

		echo "<br> About me: <br>
			 <div style='height:150px' id='text_box_settings' >".htmlspecialchars($settings['about']). "</div>";



	}

	?>

		</form>
	</div>
</div>