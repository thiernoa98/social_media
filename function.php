<?php 
//this function check if user is loged in
function check_login($con) 
{
	if (isset($_SESSION['user_id'])) 
	{
		$id = $_SESSION['user_id'];
		$query = "select * from users where user_id = '$id' limit 1";

		$result = mysqli_query($con, $query);
		if ($result && mysqli_num_rows($result) > 0) 
		{
			
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}


	header("Location: login.php");
	die;

}

//second function, from signup.php
function random_num($length)
{

	$text = "";

	if ($length < 5) 
	{
		$length = 5;
	}

	$len = rand(4, $length); 

	for ($i=0; $i < $len; $i++) 
	{ 
		$text .= rand(0,9); 


	}

	return $text;
}



//generate a random image name
function generate_imgname($length) 
{
	$array= array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L',
  'M', 'N', 'O', 'P', 'Q', 'R',  'S', 'T', 'U', 'V', 'W', 'X',
  'Y', 'Z', 'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

	$text = "";

	for ($i=0; $i < $length; $i++) 
	{ 
		$random = rand(0,61); //from 0, 61 is the add of the total array above

		//save it to $text
		$text .=$array[$random] . ".jpeg";
	}
	return $text;
}




// the image crop function/reducing the size
function crop_img($original_file_name,$cropped_file_name, $max_width,$max_height)
{
	if(file_exists($original_file_name)) 
	{
		
		$original_image = imagecreatefromjpeg($original_file_name);

		$original_width = imagesx($original_image);
		$original_height = imagesy($original_image);


		if ($original_height > $original_width)
		{
			
			$ratio = ($max_width / $original_width);

			$new_width = $max_width;
			$new_height = ($original_height * $ratio);
		}
		else
		{
			$ratio = ($max_height / $original_height);

			$new_height = $max_height;
			$new_width = ($original_width * $ratio);
		}

	}

	if ($max_width != $max_height) 
	{
		if ($max_height > $max_width) 
		{
			if ($max_height > $new_height) 
			{
				$adjustment = ($max_height/$new_height);
			}
			else
			{
				$adjustment = ($new_height/$max_height);
			}
			$new_width = ($new_width * $adjustment);
			$new_height = ($new_height * $adjustment);
		}
		else
		{
			if ($max_width > $new_width) 
			{
				$adjustment = ($max_width/$new_width);
			}
			else
			{
				$adjustment = ($new_width/$max_width);
			}
			$new_width = ($new_width * $adjustment);
			$new_height = ($new_height * $adjustment);

		}
	}
	$new_image = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

	imagedestroy($original_image);


	if ($max_width != $max_height)
	{ 
		if ($max_width > $max_height) 
		{
		
			$diff = ($new_height - $max_height);

			if ($diff < 0) 
			{
				$diff = $diff * -1; 
			}

			$yaxis = round($diff / 2);
			$xaxis = 0; 
		}
		else
		{
			$diff = ($new_width - $max_width);

			if ($diff < 0) 
			{
				$diff = $diff * -1; 
			}	
			$xaxis = round($diff / 2);
			$yaxis = 0; 

		}
	}
	else
	{
		if ($new_height > $new_width) 
		{
			
			$diff = ($new_height - $new_width);
			$yaxis = round($diff / 2);
			$xaxis = 0;
		}
		else
		{
			$diff = ($new_width - $new_height);
			$xaxis = round($diff / 2);
			$yaxis = 0; 

		}
	}
	

	$new_cropped_img = imagecreatetruecolor($max_width, $max_height);

	imagecopyresampled($new_cropped_img, $new_image, 0, 0, $xaxis, $yaxis, $max_width, $max_height, $max_width, $max_height);

	imagedestroy($new_image);

	imagejpeg($new_cropped_img, $cropped_file_name, 90);

	imagedestroy($new_cropped_img);
}



// resizing the image 
function resize_img($original_file_name,$resized_file_name, $max_width,$max_height)
{
	if(file_exists($original_file_name)) 
	{
		
		$original_image = imagecreatefromjpeg($original_file_name);

		$original_width = imagesx($original_image);
		$original_height = imagesy($original_image);

		if ($original_height > $original_width)
		{
			$ratio = ($max_width / $original_width);

			$new_width = $max_width;
			$new_height = ($original_height * $ratio);
		}
		else
		{
			$ratio = ($max_height / $original_height);

			$new_height = $max_height;
			$new_width = ($original_width * $ratio);
		}

	}

	if ($max_width != $max_height) 
	{
		if ($max_height > $max_width) 
		{
			if ($max_height > $new_height) 
			{
				$adjustment = ($max_height/$new_height);
			}
			else
			{
				$adjustment = ($new_height/$max_height);
			}
			$new_width = ($new_width * $adjustment);
			$new_height = ($new_height * $adjustment);
		}
		else
		{
			if ($max_width > $new_width) 
			{
				$adjustment = ($max_width/$new_width);
			}
			else
			{
				$adjustment = ($new_width/$max_width);
			}
			$new_width = ($new_width * $adjustment);
			$new_height = ($new_height * $adjustment);

		}
	}
	$new_image = imagecreatetruecolor($new_width, $new_height);
	imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);

	imagedestroy($original_image);

	imagejpeg($new_image, $resized_file_name, 90);

	imagedestroy($new_image);
}


//saving the full veersion of the cover image to our file
function get_thumb_cover($filename)
{
	$thumb = $filename . "_cover.jpg";

	crop_img($filename, $thumb, 1366,488);

	if (file_exists($thumb)) 
	{
		return $thumb;
	}
	else
	{
		return $filename;
	}
}


//saving the full veersion of the profile image to our file
function get_thumb_profile($filename)
{
	$thumb = $filename . "_profile.jpg";

	crop_img($filename, $thumb, 700,700);

	if (file_exists($thumb)) 
	{
		return $thumb;
	}
	else
	{
		//return original image
		return $filename;
	}
}


//saving the full veersion of the post image 
function get_thumb_post($filename)
{
	$thumb = $filename . "_post.jpg";

	crop_img($filename, $thumb, 600,500);

	if (file_exists($thumb)) 
	{
		return $thumb;
	}
	else
	{
		//return original image
		return $filename;
	}
}








// creating a post
function create_post($userid, $data, $con, $files)
{
	if (!empty($data['content']) || !empty($files['file']['name']) || 
		isset($data['is_profile_img']) || isset($data['is_cover_img'])) 
	{
		//posting images in the post
		$myimg = "";
		$has_img = 0;
		$is_profile_img = 0;
		$is_cover_img = 0;
		$comments = 0;
		$likes = 0;
		$parent = 0;

	//creating a post for the profile pic
		if (isset($data['is_profile_img']) || isset($data['is_cover_img']) )
		{
			$myimg = $files;
			$has_img = 1;

			if (isset($data['is_profile_img'])) 
			{
				$is_profile_img = 1;
			}
			if (isset($data['is_cover_img'])) 
			{
				$is_cover_img = 1;
			}
		}

		else
		{


			if (!empty($files['file']['name'])) 
			{
				//creating a random folder 
				$img_folder = "uploaded_posts/" . $user_data['user_id']."/"; 

				if (!file_exists($img_folder)) 
				{
					mkdir($img_folder, 0777, true); //make foder.. 0777 file permission

					//creating an empty index.php file in the new folder, for security reason
					file_put_contents($img_folder . "index.php", 
					"<h1 style='color:red'> Error 404 </h1>");
				}

				$myimg = $img_folder . generate_imgname(14) ;

				move_uploaded_file($_FILES['file']['tmp_name'], $myimg);

				$image = resize_img($myimg, $myimg, 1500,1500);

				$has_img = 1; 
			}
		}
 
		$content = " ";
		if (isset($data['content'])) 
		{
			$content = addslashes($data['content']); 
		}

		if (isset($data['parent']) && is_numeric($data['parent'])) 
		{
			$parent = $data['parent'];


			$query = "update contents set comments = comments + 1 where content_id ='$parent' limit 1";

			  mysqli_query($con,$query);

		}

		$content_id = random_num(20);

		$query = "insert into contents (content_id, userid, content,image, comments,likes, has_img, is_profile_img, is_cover_img,parent) values('$content_id', '$userid', '$content', '$myimg', '$comments', '$likes', '$has_img', '$is_profile_img', '$is_cover_img', '$parent')";

		mysqli_query($con,$query);
		
}

	else
	{
		echo "<p style='text-align:center; color:red'>Please Type Something to Post!</p>";
	}

}



//getting the credentials of the correct user profile
function get_user_profile($id, $con)
{

	if (isset($_GET['id']) && is_numeric($_GET['id'])) 
	{
		$id = addslashes($_GET['id']);

		//must join the two table because userid are different
		$query = "select * from users inner join contents 
		on users.user_id = contents.userid where users.user_id = '$id' limit 1";

		$result =  mysqli_query($con,$query);
		
		if ($result && mysqli_num_rows($result) > 0) 
		{
			$user_data = mysqli_fetch_assoc($result);

			return $user_data;
		}
		

	}


}




// delete function 
function get_one_post($content_id,$con,$user_id)
{
	$error = "";
	$content_id =$_GET['content_id'];
	$user_id = $_SESSION['user_id'];

	if (isset($_GET['content_id']) && isset($_SESSION['user_id']) && is_numeric($_GET['content_id'])) 
	{
		$query = "select * from contents inner join users
		on contents.userid = users.user_id where contents.content_id = '$content_id' limit 1";

		$result = mysqli_query($con,$query);

	    if ($result && mysqli_num_rows($result) > 0) 
	    {

	    	$user_data = mysqli_fetch_assoc($result);

	    	return $user_data;
	    }
			

	}
	else
	{
		return $error("No Content Found to Delete!");
	}
	    
}



//post delete function
function delete_post($content_id,$con)
{
	$content_id =$_GET['content_id'];

	$query = "select parent from contents where content_id = '$content_id' limit 1";
	$result = mysqli_query($con,$query);
	 
	 if ($result && mysqli_num_rows($result) > 0) 
		{
			
			$user_data = mysqli_fetch_assoc($result);
			
			if (($user_data)) 
			{
				if ($user_data['parent'] > 0)
				{
					$parent = $user_data['parent'];

					$query = "update contents set comments = comments - 1 where content_id ='$parent' limit 1";

			 		mysqli_query($con,$query);
			 		
				}
			}
		}



	
	if (isset($_GET['content_id']) && is_numeric($_GET['content_id'])) 
	{
		$query = "delete from contents where content_id = '$content_id' limit 1";

		mysqli_query($con,$query);


	}

}




//the like function
function like_content($id, $type, $user_id,$con)
{
		
		$following =  '';

		//saving like details
		$query = "select likes from likes where type ='$type' && content_id = '$id' limit 1";
		$result = mysqli_query($con,$query);

		//checking if a person has already liked the post
		if ($result && mysqli_num_rows($result) > 0) 
		{
			$user_data = mysqli_fetch_assoc($result);
			
			if (is_array($user_data)) 
			{
			
				//if they have already liked, then prevent them from doing so again 
				$likes = json_decode($user_data['likes'], true);
	
				//getting a column of all users who liked the postt
				$user_ids = array_column($likes, "user_id");


			if (!in_array($user_id, $user_ids)) 
			{
				$array["user_id"] = $user_id;
				$array["date"] = date("Y-m-d H:i:s"); //the time post was liked

				$likes[]= $array;

				$likes = json_encode($likes); 

				$query = "update likes set likes = '$likes' where type ='$type' 
				&& content_id = '$id' limit 1 ";

				mysqli_query($con,$query);

				//increment table after like, use {$type} because that will update the right table
				$query = "update {$type}s set likes = likes + 1 where {$type}_id = '$id' limit 1";
				mysqli_query($con,$query);

			}
			else //unlike
			{
				$key = array_search($user_id, $user_ids);
				unset($likes[$key]);

				//once unset, encode the likes and send it to the database & save
				$likes = json_encode($likes); 

				$query = "update likes set likes = '$likes' where type ='$type' 
				&& content_id = '$id' limit 1 ";

				mysqli_query($con,$query);

				$query = "update {$type}s set likes = likes - 1 where {$type}_id = '$id' limit 1";
				mysqli_query($con,$query);
			}
		

			}
		
		}
		else //if they haven't liked, then allow them to do so
		{
		
			$array["user_id"] = $user_id;
			$array["date"] = date("Y-m-d H:i:s"); //the time post was liked

			$likes[] = $array;

			$likes = json_encode($likes);

			$query = "insert into likes(type,content_id,likes,following) 
			values ('$type','$id','$likes','$following') ";

			mysqli_query($con,$query);

			$query = "update {$type}s set likes = likes + 1 where {$type}_id = '$id' limit 1";
			mysqli_query($con,$query);
				
		} 
		


	

}


//getting the people who liked the post
function get_likes($id,$type,$con)
{

	

	if (is_numeric($id)) 
	{
		
		$query = "select likes from likes where type ='$type' && content_id = '$id' limit 1";
			
		$result = mysqli_query($con,$query);

		if ($result && mysqli_num_rows($result) > 0) 
		{
			
			
			$user_data = mysqli_fetch_assoc($result);
			
			if (is_array($user_data)) 
			{

				$likes = json_decode($user_data['likes'],true);

				return $likes;
			}
		
		}
	}


	return false; 
}




function get_user($id,$con)
{


	$query = "select * from users inner join 
	contents on users.user_id = contents.userid where user_id = '$id' order by contents.id desc limit 1";
	$result = mysqli_query($con,$query);
	if ($result && mysqli_num_rows($result)>0) 
	{
		$user_data = mysqli_fetch_assoc($result);

		return $user_data;


	}

}


//post edit
function edit_post($data, $con, $files)
{

	if (!empty($data['content']) || !empty($files['file']['name']) ) 
	{
		$myimg = "";
		$has_img = 0;



		if (!empty($files['file']['name'])) 
		{
			$img_folder = "uploaded_posts/" . $user_data['user_id']."/"; 

			if (!file_exists($img_folder)) 
			{
				mkdir($img_folder, 0777, true); 

				file_put_contents($img_folder . "index.php", 
				"<h1 style='color:red'> Error 404 </h1>");
			}

			$myimg = $img_folder . generate_imgname(14) ;

			move_uploaded_file($_FILES['file']['tmp_name'], $myimg);

			$image = resize_img($myimg, $myimg, 1500,1500);

			$has_img = 1; 
		}
		

		$content = " ";
		if (isset($data['content'])) 
		{
			$content = addslashes($data['content']); 
		}

		$content_id = addslashes($data['content_id']);

		
		if ($has_img) 
		{
			$query = "update contents set content = '$content', image = '$myimg' 
			where content_id = '$content_id' limit 1";
		}
		else
		{
			$query = "update contents set content = '$content'
			where content_id = '$content_id' limit 1";
		}
		
		 mysqli_query($con,$query);
		
}

	else
	{
		echo "<p style='text-align:center; color:red'>Please Type Something to Post!</p>";
	}

}





function user_following($id, $type, $user_id, $con)
{
		$likes = '';
		
		$query = "select * from likes where type ='$type' && content_id = '$user_id' limit 1";
		$result = mysqli_query($con,$query);

		if ($result && mysqli_num_rows($result) > 0) 
		{
			$user_data = mysqli_fetch_assoc($result);

			if (is_array($user_data)) 
			{
			
			$following = json_decode($user_data['following'],true);
			
			$user_ids = array_column($following, "user_id");

			if (!in_array($id, $user_ids)) 
			{
				$array["user_id"] = $id;
				$array["date"] = date("Y-m-d H:i:s");

				$following[]= $array;

				$following = json_encode($following); 

				$query = "update likes set following = '$following' where type ='$type' 
				&& content_id = '$user_id' limit 1 ";

				mysqli_query($con,$query);

			}
			else //unlike
			{
				$key = array_search($id, $user_ids);
				unset($following[$key]);

				$following = json_encode($following); 

				$query = "update likes set following = '$following' where type ='$type' 
				&& content_id = '$user_id' limit 1 ";

				mysqli_query($con,$query);

			}
		

			}
		
		}
		else 
		{
			
			$array["user_id"] = $id; 
			$array["date"] = date("Y-m-d H:i:s"); 

			$following[] = $array;

			$following = json_encode($following);

			$query = "insert into likes(type,content_id,likes,following) 
			values ('$type','$user_id','$likes','$following') ";

			mysqli_query($con,$query);
		
		} 
		

}


//getting the following
function get_following($id,$type,$con)
{
	if (is_numeric($id)) 
	{
		$query = "select following from likes where type ='$type' && content_id = '$id' limit 1";
			
		$result = mysqli_query($con,$query);

		if ($result && mysqli_num_rows($result) > 0) 
		{
			
			$user_data = mysqli_fetch_assoc($result);
			
			if (is_array($user_data)) 
			{

				//if they have already liked, decode the array
				$following = json_decode($user_data['following'],true);

				return $following;
			}
		
		}
	}


	return false; 
}


function get_settings($id,$con)
{
	$query = "select * from users where user_id = '$id' limit 1";
	$result = mysqli_query($con,$query);

	if ($result && mysqli_num_rows($result)>0)
	 {
		$user_data = mysqli_fetch_assoc($result);
		if (is_array($user_data)) 
		{
			return $user_data;
		}
	 }
}



function save_settings($id,$data,$con)
{
	$query = "update users set ";

	foreach ($data as $key => $value) 
	{
		$query .= $key . "='". $value ."',";
	}

	$query = trim($query,",");
	$query .= " where user_id = '$id' limit 1"; 

	mysqli_query($con,$query);



}


function get_comments($id,$con)
{

	$query = "select * from contents inner join users on contents.userid = users.user_id  where contents.parent = '$id' order by contents.id asc limit 10";
	$result = mysqli_query($con,$query);

	 return $result;
}


function get_time($pasttime , $today = 0, $differenceFormat = '%y' )
{
	
	$today = date("Y-m-d H:i:s");
	$datetime1 = date_create($pasttime);
	$datetime2 = date_create($today);

	$interval = date_diff($datetime1,$datetime2);
	$answerYear = $interval->format($differenceFormat);

	$differenceFormat = '%m';
	$answerMonth = $interval->format($differenceFormat);
	
	$differenceFormat = '%d';
	$answerDay = $interval->format($differenceFormat);	

	$differenceFormat = '%d';
	$answerHour = $interval->format($differenceFormat);

	//check for how much time has passed

	if ($answerYear >= 1) //more or equal to 1 year
	{
		
		$answerYear = date(" F j, Y", strtotime($pasttime));
		return $answerYear;
	}
	elseif ($answerMonth >= 1) 
	{
		$answerMonth = date(" F j, Y", strtotime($pasttime));
		return $answerMonth;
	}
	elseif ($answerDay > 2) 
	{
		$answerDay = date(" F j, Y", strtotime($pasttime));
		return $answerDay;
	}
	elseif ($answerDay == 2) 
	{
		return $answerDay . "d, " . $answerHour . "h ago ";
	}
	elseif ($answerDay == 1) 
	{
		return "1d, ". date("h", strtotime($pasttime)) ."h";
	}
	else 
	{
		$differenceFormat = '%h';
		$answerDay = $interval->format($differenceFormat);

		$differenceFormat = '%i';
		$answerHour = $interval->format($differenceFormat);

		
		if (($answerHour < 24 ) && ($answerHour > 1)) 
		{
			return $answerDay . "h, ". $answerHour . "m ago";
		}
		elseif ($answerDay == 1) 
		{
			return "1h ago";
		}
		else 
		{
			$differenceFormat = '%i';
			$answerDay =  $interval->format($differenceFormat);

			if (($answerDay < 60 ) && ($answerDay > 1))
			{
				return $answerDay ."m ago";
			}
			elseif ($answerDay == 1) 
			{
				return $answerDay. "m ago";
			}
			else
			{
				$differenceFormat = '%s';
				$answerDay = $interval->format($differenceFormat);
 
				if (($answerDay < 60 ) && ($answerDay > 10))
				{
					return $answerDay ."sec ago";
				}
				elseif ($answerDay < 10) 
				{
					return " just now ";
				}
			}


		}

	}

}


