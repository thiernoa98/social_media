<div style=" min-height:400px; width: 100%; background-color:lightgrey; text-align: center;" >
	<div style="padding: 10%;">
	<?php 

	$followers = get_likes($user_data['user_id'], "user",$con);


		if ($followers) 
		{

			foreach ($followers as $row) 
			{
				//$row =... has full data of users, it connects it with the likes table
				$row = get_user($row['user_id'],$con);
				include("friends.php");

			}
			
		}
	
	
		else

		{
			echo "<h2 style='color:#800080' >Sorry! But ".$user_data['first_name']. " has no followers";	
		}
			
		
	


	?>


	</div>
</div>
