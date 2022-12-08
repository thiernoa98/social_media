<!-- post area, images will be within this div-->
<div style=" min-height:400px; width: 100%; background-color:lightgrey; text-align: center;" >
	<div style="padding: 10%; max-width: 400px; display: inline-block;">
	
<!--  to upload a file, we must have the enctype -->
		<form method="post" enctype="multipart/form-data">


	<?php 

	$settings = get_settings($_SESSION['user_id'],$con);

	if (is_array($settings)) 
	{
		//the value print out the values of the $setting.
		//we have html special charaters for security
		echo "<p style='text-align:left; margin:0px'>First Name</p>
		<input type='text' id='text_box_settings' name='first_name' value='$settings[first_name]' placeholder='First name'/> " ;

		echo "<p style='text-align:left; margin:0px'>Last Name</p>
		<input type='text' id='text_box_settings' name='last_name' value='$settings[last_name]' placeholder='Last name'/> <br>";

		echo "Gender
		<select id='text_box_settings' name='gender' style='height:30px'>
			<option>$settings[gender]</option>
			<option> Male </option>
			<option> Female </option>
		 </select>";

		echo " <p style='text-align:left; margin:0px'>Email Adress </p>
		<input type='text' id='text_box_settings' name='email'  value='$settings[email]' placeholder='Email'/>";

		echo " <p style='text-align:left; margin:0px'>Password</p>
		<input type='password' id='text_box_settings' name='password'  value='$settings[password]' /> ";
/*
		htmlspecailchars is for security reeason
*/
		echo "<br> About me: <br>
			<textarea style='height:150px' id='text_box_settings' name='about'>".htmlspecialchars($settings['about']). "</textarea>";

	   echo '<input id="follow_button" type="submit"value="Save Changes"><br>';
	}

	?>

		</form>
	</div>
</div>