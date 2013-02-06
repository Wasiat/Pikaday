<?php

session_start();

require("connection.php");

$connect = mysql_connect($database_host, $database_username, $database_password) or die("couldn't connect to database" .mysql_error());

mysql_select_db($database_table, $connect) or die("Couldn't select database" .mysql_error());


	if (isset($_SESSION['user_login']) == FALSE)
	{
		header("Location: ". $connection_localhost);
	}



////// INSERT Post Messages
	if (isset($_POST['submit']))
	{
		//$date = date("D F jS Y g:i A", strtotime($_POST['date']));
		$post_message = mysql_real_escape_string($_POST['post_message']);
		
		if ($post_message)
		{
			$sql = ("INSERT INTO posts VALUES ('', '".$_SESSION['login_id']."', NOW(), '$post_message')") 
					or die(mysql_error());	
			
			$result = mysql_query($sql);
			
			$numrow = mysql_num_rows($result);
			
			if ($numrow != 1)
			{
				//echo "Message sent successfully.";
				
				header("Location: ". $connection_localhost);
			}
			else
			{
				//echo "Message couldn't sent.";
			}
		}
		else
		{
			//echo "Please fill in the blank field.";
		}
		
	} else {
		
		/////// Send Comment
		require("header.php");
		
	
	
///////// Show First Name and Last Name
	
	$query = ("SELECT * FROM logins WHERE id='".$_SESSION['login_id']."'");
	
	$result = mysql_query($query);
	
	while ($row = mysql_fetch_assoc($result))
	{
		$firstname = $row['firstname'];
		$lastname = $row['lastname'];
	}



echo '<div id="profilepicture">';	
	
//////// Show Profile Picture	

	$check_picture = ("SELECT * FROM pictures WHERE login_id ='".$_SESSION['login_id']."' LIMIT 1");
	
	$result_picture = mysql_query($check_picture);
	
	$picture_row = mysql_fetch_assoc($result_picture);
	
	$picture_thumbnails = $picture_row['thumbnails'];
	
	$picture_name = $picture_row['name'];
	
	if (empty($picture_thumbnails))
	{
		$profile_picture = "<img src='defaultpicture/default_pic.jpg' width='200' height='250' />";
	}
	else
	{
		$profile_picture = "<a href='datapicture/".$picture_name."'>
		<img src='datapicture/".$picture_thumbnails."' alt='".$picture_name."' width='200' height='250' /></a>";	
	}
	
	
	
	/*$check_picture = ("SELECT * FROM pictures WHERE login_id ='".$_SESSION['login_id']."' LIMIT 1");
	
	$result_picture = mysql_query($check_picture);
	
	while ($row = mysql_fetch_assoc($result_picture))
	{
	
		if (empty($row['thumbnails']))
		{
	
			$profile_picture = "<img src='defaultpicture/default_pic.jpg' width='200' />";
		
		}
		else
		{
			$profile_picture = "<a href='datapicture/".$row['name']."'>
				<img src='datapicture/".$row['thumbnails']."' alt='".$row['name']."' /></a>";
			
		}
	}*/
    


echo "<br /><br />"; 

    
  	echo $profile_picture;
    
	echo "<h2>". $firstname ." ". $lastname ."</h2>";
   
   	echo "<hr />";
    
	echo '<a href="information.php">Information</a><br />
    
	<a href="displaypictures.php">Picture</a><br />
    
    <a href="fileupload.php">Upload Picture</a><br />
    
	<a href="account_setting.php">Account Setting</a>
    
    <hr />
	
    <div style="float: left"><img src="" width="50" height="50"  /></div>
    
    <div style="float: left"><img src="" width="50" height="50"  /></div>
    
    <div style="float: left"><img src="" width="50" height="50"  /></div>
    
    <div style="float: left"><img src="" width="50" height="50"  /></div>
	
	</div>';


	
	
//////// Show Small Picture Post Messages

	$check_picture = ("SELECT * FROM pictures WHERE login_id ='".$_SESSION['login_id']."' LIMIT 1");
	
	$result_picture = mysql_query($check_picture);
	
	$picture_row = mysql_fetch_assoc($result_picture);
	
	$picture_thumbnails = $picture_row['thumbnails'];
	
	$picture_name = $picture_row['name'];
	
	if (empty($picture_thumbnails))
	{
		$profile_picture = "<img src='defaultpicture/default_pic.jpg' width='80' height='80' />";
	}
	else
	{
		$profile_picture = "<a href='datapicture/".$picture_name."'>
		<img src='datapicture/".$picture_thumbnails."' alt='".$picture_name."' width='80' height='80' /></a>";	
	}
	
	
	
	/*$check_picture = ("SELECT * FROM pictures WHERE login_id ='".$_SESSION['login_id']."' LIMIT 1");
	
	$result_picture = mysql_query($check_picture);
	
	while ($row = mysql_fetch_assoc($result_picture))
	{
	
		if (empty($row['thumbnails']))
		{
	
			$profile_picture = "<img src='defaultpicture/default_pic.jpg' width='200' />";
		
		}
		else
		{
			$profile_picture = "<a href='datapicture/".$row['name']."'>
				<img src='datapicture/".$row['thumbnails']."' alt='".$row['name']."' /></a>";
			
		}
	}*/
	


echo "<br /><br />";


/*<!---Display Small Picture, Post Messages and Comments Wrapper Top---->*/
echo '<div id="wrapper_insider">';

////// Show Post Messages

	$post_query = ("SELECT * FROM posts WHERE '".$_SESSION['login_id']."'");
	
	$result = mysql_query($post_query);
	
	while ($row = mysql_fetch_assoc($result))
	{
		$date = date("D, F jS Y, g:i:s A", strtotime($row['date']));
		$post_message = $row['post_message'];
		
		echo "<div id='post_horizontal' style=' width: 560px; float: left;'><hr /></div>";
		
		echo "<div id='small_picture'>$profile_picture</div>";
		
		echo "<div id='post_name_date'>";
		
		echo "<strong><p>$firstname $lastname<br />";
		
		echo "Posted on $date<br /><br /></strong>";
		
		echo  "$post_message</p>";
		
		echo "</div>";
	}
	
	
echo "</div>";
/*<!---Display Small Picture, Post Messages and Comments Wrapper Bottom---->*/
	
	
?>

<div id="post_idea" style=" width: 460px; float: right;">
<form action="<?php echo $SCRIPT_NAME; ?>" method="post">
		<textarea name="post_message" rows="2" cols="46" placeholder="Write something here"></textarea>	 		<input type="submit" name="submit" value="Post" style="background-color: #DCE5EE; float: right; border: 1px solid #666; color: #666; height: 51px; width: 65px;">
</form>
</div>

<div id='post_horizon' style=' width: 560px; float: right;'><hr /></div>



</div>
<br />

<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />


<?php

	}
	
	require("footer.php");
	
?>


