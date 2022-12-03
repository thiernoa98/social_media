<?php 
session_start();

include("connection.php");
include("function.php");

$user_data = check_login($con);


if (isset($_SERVER['HTTP_REFERER'])) 
{
	$return_to = $_SERVER['HTTP_REFERER'];
}
else
{
	$return_to = "profile.php";
}

if (isset($_GET['type']) && isset($_GET['id']) ) 
{	
	if (is_numeric($_GET['id'])) 
	{
		//check the things to like,(white listing) only select things that are allowed 
		$allowed[] = 'content'; 
		$allowed[] = 'user';
		$allowed[] = 'comment';

		if (in_array($_GET['type'], $allowed)) //whatever the type, it's in the $allowed[]
		{

			if ($_GET['type']=="content") 
			{
			//get the info of the post, type and who liked it 
			$content = like_content($_GET['id'], $_GET['type'], $_SESSION['user_id'],$con);
			}

			if ($_GET['type']=="user") 
			{
			//get the info of the post, type and who liked it 
			$content = like_content($_GET['id'], $_GET['type'], $_SESSION['user_id'],$con);
			}


			
			if($_GET['type'] == 'user')
			{
				$content = user_following($_GET['id'], $_GET['type'], $_SESSION['user_id'],$con);

			}	
/*

			if ($_GET['type']=="comment") 
			{
			//get the info of the post, type and who liked it 
			$content = like_content($_GET['id'], $_GET['type'], $_SESSION['user_id'],$con);
			}	
		*/
		}
	}
}



header("Location: ".$return_to);
die;

