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

		//desc
		if($_POST['txtDescription'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$description = $_POST['txtDescription'];
		}
        $projectcategorytypeid = $_POST['ddlProjectCategoryTypes'];
        $leadaccountid = $_POST['ddlProjectLeadAccountID'];
		if($returnValue)
		{
		    if(isset($_POST["editprojectid"]) && is_numeric($_POST["editprojectid"]))
            {
                $pid = $_POST["editprojectid"];
                $project = new Projects();
                $project->setProjectId($pid);	//new acct
                $project->setProjectName($projectname);
                $project->setProjectDescription($description);
                $project->setImgURL($imageURL);
                $project->setProjectURL($projecturl);
                $project->setProjectLeadAccountID($leadaccountid);
                $project->setProjectCategoryID($projectcategorytypeid);
                $project->save();
                header("location:../ViewProject.php?projectid=$pid");
            }
            else
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
                header("location:../index.php?msg=Created Project: $projectname!");
            }
		}
		else
		{
			header("location:../CreateProject.php?msg=Please review your entries.");
		}
	}


?>