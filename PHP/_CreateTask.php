<?php
session_start();
$reporteracoountid = $_SESSION["AccountID"];
    include_once($_SERVER['DOCUMENT_ROOT']."/DAL/tasks.php");

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
        if($_POST['ddlTaskType'] == 0)
        {
            $returnValue = false;
        }
        else{
            $tasktype =  $_POST['ddlTaskType'];
        }

        if($_POST['ddlPriorityType'] == 0)
        {
            $returnValue = false;
        }
        else{
            $taskprioritytypeid = $_POST['ddlPriorityType'];
        }

        if($_POST['ddlAssignee'] == 0)
        {
            $returnValue = false;
        }
        else{
            $taskassigneeaccountid = $_POST['ddlAssignee'];
        }

        if($_POST['ddlProjects'] == 0)
        {
            $returnValue = false;
        }
        else{
            $taskprojectid = $_POST['ddlProjects'];
        }


		if($returnValue)
		{
            if(isset($_POST["edittaskid"]) && $_POST["edittaskid"] > 0) {
                if (is_numeric($_POST["edittaskid"])) {
                    $tid = $_POST["edittaskid"];
                    $edittaskreporteraccountid = $_POST["edittaskreporteraccountid"] == 0 ? "" : $_POST["edittaskreporteraccountid"];
                    $edittaskstatustypeid = $_POST["edittaskstatustypeid"] == 0 ? "" : $_POST["edittaskstatustypeid"];
                    $edittaskcreatedate = isset($_POST["edittaskcreatedate"]) ? $_POST["edittaskcreatedate"] : "";
                    $edittaskclosedate = isset($_POST["edittaskclosedate"]) ? $_POST["edittaskclosedate"] : "";
                    $edittaskreopendate = isset($_POST["edittaskreopendate"]) ? $_POST["edittaskreopendate"] : "";

                    $task = new Tasks();
                    $task->setTaskID($tid);	//new task
                    $task->setTaskName($taskname);
                    $task->setDescription($description);
                    $task->setAssigneeAccountID($taskassigneeaccountid);
                    $task->setReporterAccountID($edittaskreporteraccountid);
                    $task->setStatusTypeID($edittaskstatustypeid);		//set to open as default
                    $task->setTaskTypeID($tasktype);
                    $task->setPriorityTypeID($taskprioritytypeid);
                    $task->setProjectID($taskprojectid);
                    $task->setCreateDate($edittaskcreatedate);
                    $task->setCloseDate($edittaskclosedate);
                    $task->setReopenDate($edittaskreopendate);
                    $task->save();
                    header("location:../ViewTask.php?taskid=$tid");
                }
            }
            else{
                $task = new Tasks();
                $task->setTaskID(0);	//new task
                $task->setTaskName($taskname);
                $task->setDescription($description);
                $task->setAssigneeAccountID($taskassigneeaccountid);
                $task->setReporterAccountID($reporteracoountid);
                $task->setStatusTypeID(1);		//set to open as default
                $task->setTaskTypeID($tasktype);
                $task->setPriorityTypeID($taskprioritytypeid);
                $task->setProjectID($taskprojectid);
                //record dates
                date_default_timezone_set('America/New_York');

                // Then call the date functions
                $date = date('Y-m-d H:i:s');
                $task->setCreateDate($date);
                $task->setCloseDate(NULL);
                $task->setReopenDate(NULL);
                $task->save();
                header("location:../index.php?msg=Created Task: $taskname!");
            }

		}
		else
		{
			header("location:../CreateTask.php?msg=validate");
		}
	}


?>