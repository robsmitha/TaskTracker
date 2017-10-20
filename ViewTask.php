<?php
//Check Session
session_start();
if($_SESSION["LoggedIn"] == "")
{
	header("location:login.php?msg=notloggedin");
}
//Check Query
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	if(isset($_GET['taskid']) && is_numeric($_GET['taskid']))	//validate query string
	{
		$taskid = $_GET['taskid'];
	}
	else
	{
		header("location:index.php");
	}
}
else
{
	header("location:index.php");
}	
//we good, load task for this task id
include "DAL/tasks.php";
$task = new Tasks();
$task->load($taskid);

//now load by foreign keys to fill in form values from type ids

//Priority type
include "DAL/prioritytypes.php";
$prioritytype = new Prioritytypes();
$prioritytype->load($task->getPriorityTypeID());

//status type
include "DAL/statustypes.php";
$statustype = new Statustypes();
$statustype->load($task->getStatusTypeID());

//Task Types
include "DAL/tasktypes.php";
$tasktype = new Tasktypes();
$tasktype->load($task->getTaskTypeID());

//Project
include "DAL/projects.php";
$project = new Projects();
$project->load($task->getProjectID());

//Account
include "DAL/accounts.php";
$reporter = new Accounts();
$reporter->load($task->getReporterAccountID());	//reporter obj

$assignee = new Accounts();
$assignee->load($task->getAssigneeAccountID());	//assignee obj
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TaskTracker - Task ID: <?php echo $task->getTaskID(); ?></title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php include "navbar.php" ?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">View Task <?php echo $task->getTaskID(); ?></li>
      </ol>

      <div class="row">
	  
        <div class="col-lg-8">
			<div class="card">
				<div class="bg-light" style="padding: 12px;">
					<div class="row">
						<div class="col-sm-10">
							<h3><?php echo $task->getTaskName(); ?></h3>
						</div>
						<div class="col-sm-2">
						<div class="btn-group pull-right">
							<?php
							$statustypeid = $task->getStatusTypeID();
								switch($statustypeid)
								{
									case 1:	//open
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=2' class='btn btn-secondary'>Start Progress</a>";
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=3' class='btn btn-secondary'>Resolve</a>";
									break;
									case 2:	//in progress
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=1' class='btn btn-secondary'>Stop Progress</a>";
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=3' class='btn btn-secondary'>Resolve</a>";
									break;
									case 3:	//resolved
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=5' class='btn btn-secondary'>Reopen</a>";
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=4' class='btn btn-secondary'>Ready For Testing</a>";
									break;
									case 4:	//ready for testing
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=5' class='btn btn-secondary'>Reopen</a>";
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=6' class='btn btn-secondary'>Close</a>";
									break;
									case 5:	//reopened
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=4' class='btn btn-secondary'>Ready For Testing</a>";
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=3' class='btn btn-secondary'>Resolve</a>";
									break;
									case 6:	//closed
										echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=5' class='btn btn-secondary'>Reopen</a>";
									break;
									default:
										//do nothing
									break;
								}
							?>
						</div>
						</div>
					</div>
					
				</div>
			    <div class="card-body">
					<h4>Details</h4>
					<div class="row">
						<div class="col-sm-6">
							<b>Status: </b><?php echo $statustype->getStatus(); ?>
						</div>
						<div class="col-sm-6">
							<b>Priority: </b><?php echo $prioritytype->getPriorityType(); ?>
						</div>
						<div class="col-sm-6">
							<b>Type: </b><?php echo $tasktype->getTaskType(); ?>
						</div>
						<div class="col-sm-6">
							<b>Project: </b><?php echo $project->getProjectName(); ?>
						</div>
					</div>
					<hr>
					<h4>Description</h4>
					<p><?php echo $task->getDescription(); ?></p>
			    </div>
			</div>
        </div>
        <div class="col-lg-4">
			<b><i class="fa fa-users"></i> People</b><br>
			<b>Reported By: </b><?php echo $reporter->getFirstName(). " " .$reporter->getLastName(); ?><br>
			<b>Assigned To: </b><?php echo $assignee->getFirstName(). " " .$assignee->getLastName();  ?><br>
			<hr>
			<b><i class="fa fa-calendar"></i> Dates</b><br>
			<b>Create Date: </b><?php echo $task->getCreateDate(); ?><br>
			<?php if($task->getReopenDate() != 0) echo "<b>Reopen Date: </b>".$task->getReopenDate()."<br>"; ?>
			<?php if($task->getCloseDate() != 0) echo "<b>Close Date: </b>".$task->getCloseDate()."<br>"; ?>
        </div>
      </div>
      
    </div>
    <!-- /.container-fluid-->
</div>
<!-- /.content-wrapper-->
<?php include "footer.php"?>
<?php include "modal.php"?>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>

</body>

</html>
