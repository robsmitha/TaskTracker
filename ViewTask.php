<?php
//Check Session
session_start();
include_once("Utilities/SessionManager.php");
include "DAL/tasks.php";
include "DAL/prioritytypes.php";
include "DAL/statustypes.php";
include "DAL/tasktypes.php";
include "DAL/projects.php";
include "DAL/accounts.php";
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
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

if($_SERVER["REQUEST_METHOD"] == "POST")	//gather task id from query
{
    if(isset($_POST['statustypeid']))	//validate query string
    {
        $statustypeid = $_POST['statustypeid'];
    }
    else
    {
        header("location:.index.php");
    }
    if(isset($_POST['taskid']))	//validate query string
    {
        $taskid = $_POST['taskid'];
    }
    else
    {
        header("location:.index.php");
    }
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
    $id = $task->getTaskID();
    header("location:ViewTask.php?taskid=$id");
}

//we good, load task for this task id
$task = new Tasks();
$task->load($taskid);

//now load by foreign keys to fill in form values from type ids

//Priority type
$prioritytype = new Prioritytypes();
$prioritytype->load($task->getPriorityTypeID());

//status type
$statustype = new Statustypes();
$statustype->load($task->getStatusTypeID());

//Task Types
$tasktype = new Tasktypes();
$tasktype->load($task->getTaskTypeID());

//Project
$project = new Projects();
$project->load($task->getProjectID());
$projectid = $project->getProjectId();

//Account
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
                        <script>
                            function setStatustType(e) {
                                switch (e){
                                    case "STATUS_1":	//open
                                        $("#hfstatustypeid").val(1);
                                        break;
                                    case "STATUS_2":	//in progress
                                        $("#hfstatustypeid").val(2);
                                        break;
                                    case "STATUS_3":	//resolved
                                        $("#hfstatustypeid").val(3);
                                        break;
                                    case "STATUS_4":	//ready for testing
                                        $("#hfstatustypeid").val(4);
                                        break;
                                    case "STATUS_5":	//reopened
                                        $("#hfstatustypeid").val(5);
                                        break;
                                    case "STATUS_6":	//closed
                                        $("#hfstatustypeid").val(6);
                                        break;
                                    default:
                                    //do nothing
                                    break;
                                }
                                return true;
                            }
                        </script>
						<form method="post" class="btn-group pull-right">
                            <input id="hfstatustypeid" type="hidden" name="statustypeid">
                            <input type="hidden" name="taskid" value="<?php echo $taskid ?>">
                            <a class="btn btn-secondary" href="CreateTask.php?cmd=edit&taskid=<?php echo $taskid ?>">Edit</a>
							<?php
                            if(true)    //$task->getAssigneeAccountID() == $_SESSION["AccountID"]
                            {
                                $statustypeid = $task->getStatusTypeID();
                                switch($statustypeid)
                                {
                                    case 1:	//open
                                        ?>
                                        <button type="submit" id="STATUS_2" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Start Progress</button>
                                        <button type="submit" id="STATUS_3" class='btn btn-secondary' onclick="return setStatustType(this.id)">Resolve</button>
                                        <?php
                                        $badgecssclass = "primary";
                                        break;
                                    case 2:	//in progress
                                        ?>
                                        <button type="submit" id="STATUS_1" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Stop Progress</button>
                                        <button type="submit" id="STATUS_3" class='btn btn-secondary' onclick="return setStatustType(this.id)">Resolve</button>
                                        <?php
                                        $badgecssclass = "light";
                                        break;
                                    case 3:	//resolved
                                        ?>
                                        <button type="submit" id="STATUS_5" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Reopen</button>
                                        <button type="submit" id="STATUS_4" class='btn btn-secondary' onclick="return setStatustType(this.id)">Ready For Testing</button>
                                        <?php
                                        $badgecssclass = "success";
                                        break;
                                    case 4:	//ready for testing
                                        ?>
                                        <button type="submit" id="STATUS_5" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Reopen</button>
                                        <button type="submit" id="STATUS_6" class='btn btn-secondary' onclick="return setStatustType(this.id)">Close</button>
                                        <?php
                                        $badgecssclass = "warning";
                                        break;
                                    case 5:	//reopened
                                        ?>
                                        <button type="submit" id="STATUS_4" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Ready For Testing</button>
                                        <button type="submit" id="STATUS_3" class='btn btn-secondary' onclick="return setStatustType(this.id)">Resolve</button>
                                        <?php
                                        $badgecssclass = "danger";
                                        break;
                                    case 6:	//closed
                                        ?>
                                        <button type="submit" id="STATUS_5" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Reopen</button>
                                        <?php
                                        $badgecssclass = "dark";
                                        break;
                                    default:
                                        //do nothing
                                        break;
                                }
                            }
							?>
						</form>
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
							<b>Project: </b>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectId(); ?>" title="View <?php echo $project->getProjectName(); ?>">
                                <?php echo $project->getProjectName(); ?>
                            </a>
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
