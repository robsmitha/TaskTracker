<?php
	if($_SERVER["REQUEST_METHOD"] == "GET")	//gather task id from query
	{
		
		if(isset($_GET['taskid']) && is_numeric($_GET['taskid']))	//validate query string
		{
			$taskid = $_GET['taskid'];
		}
		else
		{
			header("location:../index.php");
		}
		if(isset($_GET['statustypeid']) && is_numeric($_GET['statustypeid']))	//validate query string
		{
			$statustypeid = $_GET['statustypeid'];
		}
		else
		{
			header("location:../index.php");
		}
	}
	else
	{
		header("location:../index.php");
	}
	
	include "../DAL/tasks.php";
	$task = new Tasks();	
	$task->load($taskid);	//load this task to change status type	
	$task->setStatusTypeID($statustypeid);//record dates	
	if($statustypeid == 6) //closed
	{
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');
		$task->setCloseDate($date);
	}
	if($statustypeid == 5)
	{
		date_default_timezone_set('America/New_York');
		$date = date('Y-m-d H:i:s');
		$task->setReopenDate($date);
	}
	
	$task->save();
	
	header("location:../ViewTask.php?taskid=$taskid");
?>