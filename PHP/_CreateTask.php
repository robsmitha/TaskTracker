<?php
session_start();
$ReporterAccountID = $_SESSION["AccountID"];
	include "../DAL/tasks.php";

	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$returnValue = true;
		if($_POST['TaskName'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$taskname = $_POST['TaskName'];
		}
		//task type
		if($_POST['ddlTaskType'] == 0)
		{
			$returnValue = false;
		}
		else
		{
			$tasktype = $_POST['ddlTaskType'];
		}
		//ddlPriorityType
		if($_POST['ddlPriorityType'] == 0)
		{
			$returnValue = false;
		}
		else
		{
			$PriorityTypeID = $_POST['ddlPriorityType'];
		}
		//ddlAssignee
		if($_POST['ddlAssignee'] == 0)
		{
			$returnValue = false;
		}
		else
		{
			$AssigneeAccountID = $_POST['ddlAssignee'];
		}
		//ddlProjects
		if($_POST['ddlProjects'] == 0)
		{
			$returnValue = false;
		}
		else
		{
			$ProjectID = $_POST['ddlProjects'];
		}
		//txtDescription
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
			$task = new Tasks();
			$task->setTaskID(0);	//new task
			$task->setTaskName($taskname);
			$task->setDescription($description);
			$task->setAssigneeAccountID($AssigneeAccountID);
			$task->setReporterAccountID($ReporterAccountID);
			$task->setStatusTypeID(1);		//set to open as default	
			$task->setTaskTypeID($tasktype);			
			$task->setPriorityTypeID($PriorityTypeID);			
			$task->setProjectID($ProjectID);	
			//record dates	
			date_default_timezone_set('America/New_York');

			// Then call the date functions
			$date = date('Y-m-d H:i:s');
			$task->setCreateDate($date);
			//$task->setCloseDate(0);
			//$task->setReopenDate(0);			
			$task->save();
			header("location:../index.php?msg=success");
		}
		else
		{
			header("location:../CreateTask.php?msg=validate");
		}
	}


?>