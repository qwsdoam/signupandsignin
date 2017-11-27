<?php 
ob_start();
session_start();
$users = $_SESSION['users'];
require_once("class.php");
$auth_class = new Auth;

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Minimal sign up form</title>
  <script src="https://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
   <?php 
      switch($_GET['page'])
	  {
		  case "signup":
		      $file = "signup.tpl";
		  break;
		   case "signin":
		      $file = "signin.tpl";
		  break;
		    case "profile":
		      $file = "profile.tpl";
		  break;
		  default:
		      $file = "profile.php";
		  break;
	  }
	  include($file);
   ?>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script  src="js/index.js"></script>

</body>
</html>
