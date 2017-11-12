<?php
	session_start();
	$_SESSION["LoggedIn"] = "";
	$_SESSION["FirstName"] = "";
    $_SESSION["AccountID"] = 0;
    $_SESSION["RoleID"] = 0;
	session_destroy();
	
	header("location:../login.php");
?>