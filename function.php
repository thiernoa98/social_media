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



//deleting the post function
function delete_post($content_id,$con)
{
	//to mask the id using addslashes();
	$content_id =$_GET['content_id'];

	//checking for contents that has parents number
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
		//$content_id = addslashes();
		$query = "delete from contents where content_id = '$content_id' limit 1";

		mysqli_query($con,$query);


	}

}





//the like function
function like_content($id, $type, $user_id,$con)
{
		
		$following =  '';
	

		//saving like details, & cheking if someone has already liked it, then continue
		$query = "select likes from likes where type ='$type' && content_id = '$id' limit 1";
		$result = mysqli_query($con,$query);

		//checking if a person has already liked the post
		//then decode the array with jsondecode, make it an array again
		if ($result && mysqli_num_rows($result) > 0) 
		{
			$user_data = mysqli_fetch_assoc($result);
			
			if (is_array($user_data)) 
			{
			
				//if they have already liked, then prevent them from doing so again 
				$likes = json_decode($user_data['likes'], true);
	
				//getting a column of all users who liked the postt
				$user_ids = array_column($likes, "user_id");


			//check if current user is not in user_ids or among the likers
			if (!in_array($user_id, $user_ids)) 
			{
				$array["user_id"] = $user_id;
				$array["date"] = date("Y-m-d H:i:s"); //the time post was liked

				$likes[]= $array;

				//convert the array to string using json
				//we're converting the array because arrays cannot be saved into databases
				$likes = json_encode($likes); 

				$query = "update likes set likes = '$likes' where type ='$type' 
				&& content_id = '$id' limit 1 ";

				mysqli_query($con,$query);

				//increment table after we liked, we use {$type} because that will update the right table
				$query = "update {$type}s set likes = likes + 1 where {$type}_id = '$id' limit 1";
				mysqli_query($con,$query);

			}
			else //unlike
			{
				//search for user who liked it already 
				$key = array_search($user_id, $user_ids);
				unset($likes[$key]);

				//once unset, encode the likes and send it to the database & save
				$likes = json_encode($likes); 

				$query = "update likes set likes = '$likes' where type ='$type' 
				&& content_id = '$id' limit 1 ";

				mysqli_query($con,$query);

				//remove the likes, by like -1
				$query = "update {$type}s set likes = likes - 1 where {$type}_id = '$id' limit 1";
				//{$type}_id 
				mysqli_query($con,$query);
			}
		

			}
		
		}
		else //if they haven't liked, then allow them to do so
		{
		
			
			//$array["user_id"] will add the user_id into the databs as "user_id":...
			$array["user_id"] = $user_id;
			$array["date"] = date("Y-m-d H:i:s"); //the time post was liked

			//to have an array within another
			$likes[] = $array;

			//convert the array to string using json
			//we're converting the array because arrays cannot be saved into databases
			$likes = json_encode($likes);

			$query = "insert into likes(type,content_id,likes,following) 
			values ('$type','$id','$likes','$following') ";

			mysqli_query($con,$query);

			//incrementing content table after liking it first
			$query = "update {$type}s set likes = likes + 1 where {$type}_id = '$id' limit 1";
			mysqli_query($con,$query);
				
		} 
		


	

}


//getting the people who liked the post
function get_likes($id,$type,$con)
{

	

	if (is_numeric($id)) 
	{
		//bringing up the likes
		$query = "select likes from likes where type ='$type' && content_id = '$id' limit 1";
			
		$result = mysqli_query($con,$query);

		//checking if a person has already liked the post
		//then decode the array with jsondecode, make it an array again
		if ($result && mysqli_num_rows($result) > 0) 
		{
			
			
			$user_data = mysqli_fetch_assoc($result);
			
			if (is_array($user_data)) 
			{

				//if they have already liked, decode the array
				$likes = json_decode($user_data['likes'],true);

				return $likes;
			}
		
		}
	}


	return false; //if nothing happen
}



//get user credentials for the likes_container.php, no get_user_profile function due to a different query

function get_user($id,$con)
{

	//$query = "select * from users where user_id = '$id' ";
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
// creating a post
function edit_post($data, $con, $files)
{

	//['file']['name'] is from the html from profile, the name is file
	if (!empty($data['content']) || !empty($files['file']['name']) ) 
	{
		//posting images in the post
		$myimg = "";
		$has_img = 0;



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

			//the name of the file is within the $_FILES array
			move_uploaded_file($_FILES['file']['tmp_name'], $myimg);

			//resizing the image
			$image = resize_img($myimg, $myimg, 1500,1500);

			$has_img = 1; 
		}
		

		//addslashes is a function that ignores special characters  
		$content = " ";
		if (isset($data['content'])) 
		{
			$content = addslashes($data['content']); 
		}

		//getting the content_id
		$content_id = addslashes($data['content_id']);

		
		//check if we have an image
		if ($has_img) 
		{
			//storing updated data in the database 
			$query = "update contents set content = '$content', image = '$myimg' 
			where content_id = '$content_id' limit 1";
		}
		else
		{
			//if no image, don't save empty string
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





//user followings
function user_following($id, $type, $user_id, $con)
{
		$likes = '';
		

		//querying to see where I have followed something
		$query = "select * from likes where type ='$type' && content_id = '$user_id' limit 1";
		$result = mysqli_query($con,$query);



		//checking if a person has already liked the post
		//then decode the array with jsondecode, make it an array again
		if ($result && mysqli_num_rows($result) > 0) 
		{
			$user_data = mysqli_fetch_assoc($result);

			if (is_array($user_data)) 
			{
			
			//if they have already liked, then prevent them from doing so again 
			$following = json_decode($user_data['following'],true);
			

			//getting a column of all users who liked the postt
			$user_ids = array_column($following, "user_id");


			//check if current user is not in user_ids or among the likers
			if (!in_array($id, $user_ids)) 
			{
				//set $user_id to others' ids here
				$array["user_id"] = $id;
				$array["date"] = date("Y-m-d H:i:s"); //the time post was liked

				$following[]= $array;

				//convert the array to string using json
				//we're converting the array because arrays cannot be saved into databases
				$following = json_encode($following); 

				$query = "update likes set following = '$following' where type ='$type' 
				&& content_id = '$user_id' limit 1 ";

				mysqli_query($con,$query);

			}
			else //unlike
			{
				//search for user who liked it already 
				//$id is other people
				$key = array_search($id, $user_ids);
				unset($following[$key]);

				//once unset, encode the likes and send it to the database & save
				$following = json_encode($following); 

				$query = "update likes set following = '$following' where type ='$type' 
				&& content_id = '$user_id' limit 1 ";

				mysqli_query($con,$query);

			}
		

			}
		
		}
		else //if they haven't liked, then allow them to do so in the first place
		{
			
			//$array["user_id"] will add the user_id into the databs as "user_id":...
			$array["user_id"] = $id; //$id is equal others user_ids.
			$array["date"] = date("Y-m-d H:i:s"); //the time post was liked

			//to have an array within another
			$following[] = $array;

			//convert the array to string using json
			//we're converting the array because arrays cannot be saved into databases
			$following = json_encode($following);

			//it's $user_id there because content id is my own id!
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
		//bringing up the followings
		$query = "select following from likes where type ='$type' && content_id = '$id' limit 1";
			
		$result = mysqli_query($con,$query);

		//checking if a person has already liked the post
		//then decode the array with jsondecode, make it an array again
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


	return false; //if nothing happen
}

//settings
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

//saving the settings
function save_settings($id,$data,$con)
{
	/*
	$password = $data['password'];
	if ($data['password'] == $data['password2']) 
	{
		$data['password'] == $data['password2'];
	}
	else
	{
		//unset($data['password']);
	}
*/
	$query = "update users set ";

	foreach ($data as $key => $value) 
	{
		//.= adds to what already exist
		$query .= $key . "='". $value ."',";
	}

	//trim it to remove the extra coma above at the end $key = '$value',...
	$query = trim($query,",");
	$query .= " where user_id = '$id' limit 1"; 

	mysqli_query($con,$query);



}

//get comments
function get_comments($id,$con)
{
	//inner join users on contents.userid = users.user_id 

	$query = "select * from contents inner join users on contents.userid = users.user_id  where contents.parent = '$id' order by contents.id asc limit 10";
	$result = mysqli_query($con,$query);

	 return $result;
}

//getting the date as 
function get_time($pasttime , $today = 0, $differenceFormat = '%y' )
{
	//declare...
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
		//date format " F j, Y", month day, and year
		$answerYear = date(" F j, Y", strtotime($pasttime));
		return $answerYear;
	}
	elseif ($answerMonth >= 1) 
	{
		$answerMonth = date(" F j, Y", strtotime($pasttime));
		return $answerMonth;
	}
	elseif ($answerDay > 2) // > 2 days
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
	else //less than a day
	{
		$differenceFormat = '%h';
		$answerDay = $interval->format($differenceFormat);

		$differenceFormat = '%i';
		$answerHour = $interval->format($differenceFormat);

		//check if less than 24 hours & greater than 1 hour
		if (($answerHour < 24 ) && ($answerHour > 1)) 
		{
			return $answerDay . "h, ". $answerHour . "m ago";
		}
		elseif ($answerDay == 1) 
		{
			return "1h ago";
		}
		else //less than an hour
		{
			$differenceFormat = '%i';
			$answerDay =  $interval->format($differenceFormat);

			if (($answerDay < 60 ) && ($answerDay > 1)) //less than 60 min > 1 minutes
			{
				return $answerDay ."m ago";
			}
			elseif ($answerDay == 1) // == 1 minutes
			{
				return $answerDay. "m ago";
			}
			else
			{
				$differenceFormat = '%s';
				$answerDay = $interval->format($differenceFormat);
 
				if (($answerDay < 60 ) && ($answerDay > 10)) //seconds
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


