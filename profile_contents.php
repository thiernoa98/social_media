<?php

$id = $user_data['user_id'];

$query = "select * from users inner join contents on users.user_id = contents.userid where contents.parent = 0 && users.user_id = '$id' order by contents.id desc";

$result = mysqli_query($con,$query);

$friends = get_following($user_data['user_id'], "user",$con);
?>


<div style="display: flex;">

	<div style=" min-height:400px; flex:1">

		<div id="friends_bar">

			Friends <br>
		

			<?php 

			

			if ($friends) 
			{
				
				foreach ($friends as $friend) 
				{
					$row = get_user($friend['user_id'],$con);
					include ("friends.php");
				}
				

			}


			?>
			


		</div>
	</div> 

<!-- post area-->
	<div style=" min-height:400px; flex:3; padding: 20px;" >
		
		<div style="border: solid thin #aaa;padding: 10px;">

			<form method="post" enctype="multipart/form-data">
				<textarea name = "content" placeholder="what's up"></textarea>
				<input type="file" name="file">
				<input id="share_button" type="submit"value="Share"><br>
			</form>

		</div>

		<!-- Post -->
		<div id="post_bar">



	<?php 
		

			if ($result) 
			{
				
					foreach($result as $row)
				{
					
					include("post.php");
				}
				

			}
	?>

				

		</div>

	 </div>
</div>
