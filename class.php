<?php 

class Auth 
{
	private $mysqli;
	
	public function __construct()
	{
		//Connection 
		$this->mysqli = new mysqli("localhost","root","","tests");
	}
	
    public function signup($post)
	{
		$name = $this->mysqli->real_escape_string(trim($post['name']));
		$email = $this->mysqli->real_escape_string(trim($post['email']));
		$password = $this->mysqli->real_escape_string(trim($post['password']));
		$salt = '$2a$07$usesomadaULQXTPpOSDAQWESADnnnn$$$$$$$$$$$$$$$$$asdsadesillystringfors';
        $psw = crypt($password, $salt);
		//Chech the button
		if($post['submit'])
		{
			//Check the same email
			$sql = "SELECT email FROM xyz_users WHERE email='%s'";
			$sql = sprintf($sql,$email);
			$sql = $this->mysqli->query($sql);
			$row = mysqli_fetch_row($sql);
			if($row > 0)
			{
				echo "<script>alert('Email already exists!')</script>";
			}else {
				$in_sql = "INSERT INTO `xyz_users`(fullname,email,password)VALUES('%s','%s','%s')";
				$in_sql = sprintf($in_sql,$name,$email,$psw);
				$in_sql = $this->mysqli->query($in_sql);
				if($in_sql)
				{
					 echo "<script>alert('You have successfully registered!')</script>";
				}else {
					 echo "<script>alert('Please repait again!')</script>";
				}
			}
		}
	}
	 public function signin($post)
	{
		$email = $this->mysqli->real_escape_string(trim($post['email']));
		$password = $this->mysqli->real_escape_string(trim($post['password']));
		$salt = '$2a$07$usesomadaULQXTPpOSDAQWESADnnnn$$$$$$$$$$$$$$$$$asdsadesillystringfors';
        $psw = crypt($password, $salt);
		//Chech the button
		if($post['submit'])
		{
			//Check the same email
			$sql = "SELECT email,password FROM xyz_users WHERE email='%s' and password='%s'";
			$sql = sprintf($sql,$email,$psw);
			$sql = $this->mysqli->query($sql);
			$check = mysqli_num_rows($sql);
			if($check == 1)
			{
				echo "<script>alert('you have successfully authenticated!')</script>";
				$salt = '$2a$07$usesomadaULQXTPpOSDAQWESADnnnn$$$$$$$$$$$$$$$$$asdsadesillystringfors';
				$email_s = crypt($email, $salt);
				$email_d = date('Y-m-d\TH:i:sP')."-(?)-(?@@@Q)-".$email_s;
				$this->mysqli->query("UPDATE xyz_users SET session_email='$email_d' WHERE email='$email'");
				$_SESSION['users'] = $email_d;
				header("Location:index.php");
			}else
			{
				 echo "<script>alert('Email or password is incorrect')</script>";
			}
			
			
		}
	}
	public function profile($session)
	{
		    $sql = "SELECT * FROM xyz_users WHERE session_email='%s'";
			$sql = sprintf($sql,$session);
			$sql = $this->mysqli->query($sql);
			while($row = mysqli_fetch_assoc($sql))
			{
				echo "<center><h3>Hello,{$row[fullname]}</h3></center>";
				echo "<center><h4>Email:{$row[email]}</h4></center>";
				if($row['image'] == "")
				{
					echo "<center><img src='https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg' width='200' height='200'></center>";
				    echo "<form action='' method='post' enctype='multipart/form-data'>";
                    echo "Change the image:		 
					<input type='file' name='myfile' value='Image one'><br/>";
                    echo "<input type='submit' name='submit_im' value='Change' class='btncontact'>";
					echo "</form>";
				}else {
					echo "<center><img src='{$row[image]}' width='200' height='200'></center>";
				}
			}
	}
	public function upload($session)
	{
	 if($_POST['submit_im'])
		{
		$blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm");
		 foreach ($blacklist as $item)
		  if(preg_match("/$item\$/i", $_FILES['myfile']['name'])) exit;
			$type = $_FILES['myfile']['type'];
			 $size = $_FILES['myfile']['size'];
			 if (($type != "image/jpg") && ($type != "image/jpeg")) exit;
			  if ($size > 102400) exit;
			  $uploadfile = "img/".$_FILES['myfile']['name'];
			   move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadfile);
			    $sql = $this->mysqli->query("UPDATE xyz_users SET image='$uploadfile' WHERE session_email='$session'");
				if($sql)
				{
					 
					
					header("location:index.php");
				}
			}
	}
} 