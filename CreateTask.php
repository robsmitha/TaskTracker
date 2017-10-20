<?php
session_start();
if($_SESSION["LoggedIn"] == "")
{
	header("location:login.php?msg=notloggedin");
}
include "DAL/prioritytypes.php";
include "DAL/accounts.php";
include "DAL/statustypes.php";
include "DAL/tasktypes.php";
include "DAL/projects.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>TaskTracker</title>
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
        <li class="breadcrumb-item active">Create Task</li>
      </ol>

      <div class="row">
	  
        <div class="col-lg-8">
            <?php if(isset($validationMsg)) { ?>
	<div class="alert alert-danger alert-dismissible fade show mx-auto mt-5" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	  <h4> <?php  echo $validationMsg; ?> </h4>
	</div>
  <?php } ?>
    <div class="card">
      <div class="card-header">Create Task</div>
      <div class="card-body">
        <form id="formTask" method="post" action="PHP/_CreateTask.php">
			<div class="form-group">
				<label for="TaskName">Task name</label>
				<input class="form-control" name="TaskName" type="text" aria-describedby="nameHelp" placeholder="Enter task name">
			</div>
			<div class="form-group">
				<div>
					<div class="row form-group">
						<div class="col-md-6">
							<label for="ddlTaskType">Task Type</label>
							<select name="ddlTaskType" class="form-control">
								<?php
								echo '<option value="0">---Type---</option>';
								$TaskTypesList = Tasktypes::loadall();
								foreach($TaskTypesList as $taskType)
								{
									$tasktypeid = $taskType->getTaskTypeID();
									$tasktype = $taskType->getTaskType();
									echo '<option value="'.$tasktypeid.'">'.$tasktype.'</option>';
									
								}
								?>
							</select>
						</div>
						<div class="col-md-6">
							<label for="ddlPriorityType">Priority</label>
							<select name="ddlPriorityType" class="form-control">
								<?php
								echo '<option value="0">---Priority---</option>';
								$PriorityTypesList = Prioritytypes::loadall();
								foreach($PriorityTypesList as $priorityType)
								{
									$prioritytypeid = $priorityType->getPriorityTypeID();
									$prioritytype = $priorityType->getPriorityType();
									echo '<option value="'.$prioritytypeid.'">'.$prioritytype.'</option>';
									
								}
								?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<label for="ddlAssignee">Assign To</label>
							<select name="ddlAssignee" class="form-control">
								<?php
								echo '<option value="0">---Assignee---</option>';
								$AssigneeAccountIDList = Accounts::loadall();
								foreach($AssigneeAccountIDList as $assigneeAccountID)
								{
									$accountid = $assigneeAccountID->getAccountID();
									$accountname = $assigneeAccountID->getFirstName(). " " .$assigneeAccountID->getLastName();
									echo '<option value="'.$accountid.'">'.$accountname.'</option>';
									
								}
								?>
							</select>
						</div>
						<div class="col-md-6">
							<label for="ddlProjects">Project</label>
							<select name="ddlProjects" class="form-control">
								<?php
								echo '<option value="0">---Project---</option>';
								$ProjectList = Projects::loadall();
								foreach($ProjectList as $project)
								{
									$projectid = $project->getProjectID();
									$projectname = $project->getProjectName();
									echo '<option value="'.$projectid.'">'.$projectname.'</option>';
									
								}
								?>
							</select>
						</div>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label for="txtDescription">Description</label>
				<textarea name="txtDescription" class="form-control" rows="5"></textarea>
			</div>
          <button class="btn btn-primary btn-block" type="submit">Create Task</button>
        </form>
      </div>
    </div>
        </div>
        <div class="col-lg-4">
          <?php include "feed.php" ?>
        </div>
      </div>
      
    </div>
    <!-- /.container-fluid-->
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
  </div>
</body>

</html>
