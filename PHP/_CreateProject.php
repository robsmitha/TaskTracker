<?php
	include "../DAL/projects.php";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$returnValue = true;
		if($_POST['ProjectName'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$projectname = $_POST['ProjectName'];
		}
		//img url
		if($_POST['ProjectImgURL'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$imageURL = $_POST['ProjectImgURL'];
		}
		//Project url
		if($_POST['ProjectURL'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$projecturl = $_POST['ProjectURL'];
		}
		//Project Category
		if($_POST['ddlProjectCategoryTypes'] == 0)
		{
			$returnValue = false;
		}
		else
		{
			$projectcategorytypeid = $_POST['ddlProjectCategoryTypes'];
		}
		//ProjectLeadID
		if($_POST['ddlProjectLeadAccountID'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$leadaccountid = $_POST['ddlProjectLeadAccountID'];
		}
		//desc
		if($_POST['txtDescription'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$description = $_POST['txtDescription'];
		}
		if($returnValue)
		{
			$project = new Projects();
			$project->setProjectId(0);	//new acct
			$project->setProjectName($projectname);
			$project->setProjectDescription($description);
			$project->setImgURL($imageURL);
			$project->setProjectURL($projecturl);
			$project->setProjectLeadAccountID($leadaccountid);
			$project->setProjectCategoryID($projectcategorytypeid);
			$project->save();
			header("location:../index.php?msg=sucess");
		}
		else
		{
			header("location:../CreateProject.php?msg=validate");
		}
	}


?>