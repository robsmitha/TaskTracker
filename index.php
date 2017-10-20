<?php
session_start();
if($_SESSION["LoggedIn"] == "")
{
	header("location:login.php?msg=notloggedin");
}
include "DAL/tasks.php";
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
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>

      <?php include "cardcounters.php" ?>
      <div class="row">
	  
        <div class="col-lg-8">
          <!-- Open Tasks Feed-->
          <div class="card mb-3">
            <div class="card-header">
              <i class="fa fa-bar-chart"></i> My Open Tasks</div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12 my-auto">
					<?php
					
					$TasksList = Tasks::loadbyaccountid($_SESSION["AccountID"]);
					foreach($TasksList as $task)
					{
						/* if($task->getStatusTypeID() == 1)	//open
						{
							
						} */
						$taskid = $task->getTaskID();
						$taskname = $task->getTaskName();
						echo "<a href='ViewTask.php?taskid=$taskid' class='lead'>$taskname</a><br>";
					}
					?>
                </div>
              </div>
            </div>
            <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
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
