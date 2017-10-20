<?php
	include "../DAL/accounts.php";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$returnValue = true;
		if($_POST['exampleInputName'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$name = $_POST['exampleInputName'];
		}
		if($_POST['exampleInputLastName'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$lastname = $_POST['exampleInputLastName'];
		}
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
		if($_POST['exampleConfirmPassword'] == "")
		{
			$returnValue = false;
		}
		else
		{
			if($_POST['exampleConfirmPassword'] != $password)
			{
				$returnValue = false;
			}
			else
			{
				$confirmPassword = $_POST['exampleConfirmPassword'];
			}
		}
		if($returnValue)
		{
			$account = new Accounts();
			$account->SetAccountID(0);	//new acct
			$account->SetFirstName($name);
			$account->SetLastName($lastname);
			$account->SetEmail($email);
			$account->SetPassword($password);
			$account->SetRoleID(0);		//default
			$account->SetTeamID(0);		//default
			$account->save();
			header("location:../login.php");
		}
		else
		{
			header("location:../register.php?msg=validate");
		}
	}


?>