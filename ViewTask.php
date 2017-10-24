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
$projectid = $project->getProjectId();

//Account
include "DAL/accounts.php";
$reporter = new Accounts();
$reporter->load($task->getReporterAccountID());	//reporter obj

$assignee = new Accounts();
$assignee->load($task->getAssigneeAccountID());	//assignee obj
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php include "navbar.php" ?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
          <li class="breadcrumb-item">
              <a href="ViewProject.php?projectid=<?php echo $projectid ?>">
                  <?php echo $project->getProjectName(); ?>
              </a>
          </li>
        <li class="breadcrumb-item active"><?php echo $task->getTaskName(); ?></li>
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
                            <a class="btn btn-secondary" href="CreateTask.php?cmd=edit&taskid=<?php echo $taskid ?>">Edit</a>
							<?php
                            if(true)    //$task->getAssigneeAccountID() == $_SESSION["AccountID"]
                            {
                                $statustypeid = $task->getStatusTypeID();
                                switch($statustypeid)
                                {
                                    case 1:	//open
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=2' class='btn btn-secondary'>Start Progress</a>";
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=3' class='btn btn-secondary'>Resolve</a>";
                                        $badgecssclass = "primary";
                                        break;
                                    case 2:	//in progress
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=1' class='btn btn-secondary'>Stop Progress</a>";
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=3' class='btn btn-secondary'>Resolve</a>";
                                        $badgecssclass = "light";
                                        break;
                                    case 3:	//resolved
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=5' class='btn btn-secondary'>Reopen</a>";
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=4' class='btn btn-secondary'>Ready For Testing</a>";
                                        $badgecssclass = "success";
                                        break;
                                    case 4:	//ready for testing
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=5' class='btn btn-secondary'>Reopen</a>";
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=6' class='btn btn-secondary'>Close</a>";
                                        $badgecssclass = "warning";
                                        break;
                                    case 5:	//reopened
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=4' class='btn btn-secondary'>Ready For Testing</a>";
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=3' class='btn btn-secondary'>Resolve</a>";
                                        $badgecssclass = "danger";
                                        break;
                                    case 6:	//closed
                                        echo "<a href='PHP/_UpdateTaskStatus.php?taskid=$taskid&statustypeid=5' class='btn btn-secondary'>Reopen</a>";
                                        $badgecssclass = "dark";
                                        break;
                                    default:
                                        //do nothing
                                        break;
                                }
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
                            <b>Status: </b><a href="#" class="badge badge-<?php echo isset($badgecssclass) ? $badgecssclass : "light" ?>"><?php echo $statustype->getStatus(); ?></a>
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
            <div class="card bg-light">
                <div class="card-body">
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
      </div>
      
    </div>
    <!-- /.container-fluid-->
</div>
<!-- /.content-wrapper-->
<?php include "footer.php"?>
<?php include "modal.php"?>
<?php include "scripts.php" ?>

</body>

</html>
