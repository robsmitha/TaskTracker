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
        //location
        if($_POST['dataLocation'] == "")
        {
            $returnValue = false;
        }
        else
        {
            $location = $_POST['dataLocation'];
        }
        //dob
        if($_POST['dataDOB'] == "")
        {
            $returnValue = false;
        }
        else
        {
            $dateofbirth = $_POST['dataDOB'];
            //$dateofbirth = date_create_from_format('d/M/Y:H:i:s', $s);
        }
        //bio is optional
        $bio = $_POST['dataBio'];
        $imgurl = $_POST['dataImageURL'];
		if($returnValue)
		{
		    session_start();
            if(isset($_SESSION["AccountID"]))
            {
                $account = new Accounts();
                $account->setAccountID($_SESSION["AccountID"]);
                $account->setFirstName($name);
                $account->setLastName($lastname);
                $account->setEmail($email);
                $account->setPassword($password);
                $account->setBio($bio);
                $account->setRoleID(0);
                $account->setTeamID(0);
                $account->setImgURL($imgurl);
                $account->setDateOfBirth($dateofbirth);
                $account->setLocation($location);
                $account->save();
                $transferid = $_SESSION["AccountID"];
                header("location:../ViewAccount.php?accountid=$transferid");
            }
            else
            {
                $account = new Accounts();
                $account->setAccountID(0);
                $account->setFirstName($name);
                $account->setLastName($lastname);
                $account->setEmail($email);
                $account->setPassword($password);
                $account->setBio($bio);
                $account->setRoleID(0);
                $account->setTeamID(0);
                $account->setImgURL($imgurl);
                $account->setDateOfBirth($dateofbirth);
                $account->setLocation($location);

                date_default_timezone_set('America/New_York');
                $createdate = date('m/d/Y h:i:s a', time());

                $account->setCreateDate($createdate);
                $account->save();
                header("location:../login.php");
            }

		}
		else
		{
			header("location:../CreateAccount.php?msg=validate");
		}
	}


?>