<?php

	include "../DAL/accounts.php";
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$returnValue = true;
		if($_POST['exampleInputEmail1'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$email = $_POST['exampleInputEmail1'];
		}
		if($_POST['exampleInputPassword1'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$password = $_POST['exampleInputPassword1'];
		}
		if($returnValue)
		{
			$accountList = Accounts::search("","","",$email, $password,"","","","","","");
			if($accountList != "")
			{
				foreach($accountList as $acct)
				{
					$accountid = $acct->getAccountID();
					$firstname = $acct->getFirstName();
					$lastname = $acct->getLastName();
					$email = $acct->getEmail();
					$password = $acct->getPassword();
					$roleid = $acct->getRoleID();
				}
				session_start();
				$_SESSION["LoggedIn"] = true;
				$_SESSION["FirstName"] = $firstname;
                $_SESSION["AccountID"] = $accountid;
                $_SESSION["RoleID"] = $roleid;
				header("location:../index.php");
			}
			else
			{
				header("location:../login.php?msg=noresults");
			}
		}
		else
		{
			header("location:../login.php?msg=validate");
		}
	}


?>