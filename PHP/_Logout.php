<?php
	session_start();
	$_SESSION["LoggedIn"] = "";
	$_SESSION["FirstName"] = "";
	session_destroy();
	
	header("location:../login.php");
?>