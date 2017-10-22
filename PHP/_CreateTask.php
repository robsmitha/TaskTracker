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
		//txtDescription
		if($_POST['txtDescription'] == "")
		{
			$returnValue = false;
		}
		else
		{
			$description = $_POST['txtDescription'];
		}
        $tasktype = $_POST['ddlTaskType'];
		$PriorityTypeID = $_POST['ddlPriorityType'];
        $AssigneeAccountID = $_POST['ddlAssignee'];
        $ProjectID = $_POST['ddlProjects'];
		if($returnValue)
		{
            if(isset($_POST["edittaskid"]) && $_POST["edittaskid"] > 0) {
                if (is_numeric($_POST["edittaskid"])) {
                    $tid = $_POST["edittaskid"];
                    $task = new Tasks();
                    $task->setTaskID($tid);	//new task
                    $task->setTaskName($taskname);
                    $task->setDescription($description);
                    $task->setAssigneeAccountID($AssigneeAccountID);
                    $task->setReporterAccountID($_POST["edittaskreporteraccountid"]);
                    $task->setStatusTypeID($_POST["edittaskstatustypeid"]);		//set to open as default
                    $task->setTaskTypeID($tasktype);
                    $task->setPriorityTypeID($PriorityTypeID);
                    $task->setProjectID($ProjectID);
                    $task->setCreateDate($_POST["edittaskcreatedate"]);
                    $task->setCloseDate($_POST["edittaskclosedate"]);
                    $task->setReopenDate($_POST["edittaskreopendate"]);
                    $task->save();
                    header("location:../index.php?msg=success");
                }
            }
            else{
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

		}
		else
		{
			header("location:../CreateTask.php?msg=validate");
		}
	}


?>