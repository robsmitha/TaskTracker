<?php
    include_once($_SERVER['DOCUMENT_ROOT']."/DAL/accounts.php");

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
            if(isset($_POST["editaccountid"]))
            {
                $currentDate = date('Y-m-d H:i:s');
                $account = new Accounts();
                $account->setAccountID($_POST["editaccountid"]);
                $account->setFirstName($name);
                $account->setLastName($lastname);
                $account->setEmail($email);
                $account->setPassword($password);
                $account->setBio($bio);
                $account->setRoleID(0);
                $account->setImgURL($imgurl);
                $account->setDateOfBirth($dateofbirth);
                $account->setLocation($location);
                $account->setCreateDate($currentDate);
                $account->save();
                $transferid = $_POST["editaccountid"];
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
                $account->setImgURL($imgurl);
                $account->setDateOfBirth($dateofbirth);
                $account->setLocation($location);

                date_default_timezone_set('America/New_York');
                $createdate = date('Y-m-d H:i:s');
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