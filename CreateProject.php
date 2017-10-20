<?php
session_start();
if($_SESSION["LoggedIn"] == "")
{
	header("location:login.php?msg=notloggedin");
}
include "DAL/projects.php";
include "DAL/accounts.php";
include "DAL/projectcategorytypes.php";
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
        <li class="breadcrumb-item active">Create Project</li>
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
      <div class="card-header">Create Project</div>
      <div class="card-body">
	  
        <form id="formRegister" method="post" action="PHP/_CreateProject.php">
			<div class="form-group">
				<label for="ProjectName">Project name</label>
				<input class="form-control" name="ProjectName" type="text" aria-describedby="nameHelp" placeholder="Enter project name">
			</div>
			<div class="form-group">
				<label for="ProjectImgURL">Image URL</label>
				<input class="form-control" name="ProjectImgURL" type="text" aria-describedby="nameHelp" placeholder="Enter project image URL">
			</div>
			<div class="form-group">
				<label for="ProjectURL">Project URL</label>
				<input class="form-control" name="ProjectURL" type="text" aria-describedby="nameHelp" placeholder="Enter project image URL">
			</div>
			<div class="row form-group">
				<div class="col-md-6">
					<label for="ddlProjectCategoryTypes">Project Category</label>
					<select name="ddlProjectCategoryTypes" class="form-control">
					<?php
					echo '<option value="0">---Project Category---</option>';
					$ProjectCategoryList = Projectcategorytypes::loadall();
					foreach($ProjectCategoryList as $projectCategory)
					{
						$pid = $projectCategory->getProjectCategoryID();
						$pcname = $projectCategory->getProjectCategory();
						echo '<option value="'.$pid.'">'.$pcname.'</option>';
						
					}
					?>
					</select>
				</div>
				<div class="col-md-6">
					<label for="ddlProjectLeadAccountID">Project Lead</label>
					<select name="ddlProjectLeadAccountID" class="form-control">
					<?php
					echo '<option value="0">---Project Lead---</option>';
					$ProjectLeadList = Accounts::loadall();
					foreach($ProjectLeadList as $leadAccountID)
					{
						$laid = $leadAccountID->getAccountID();
						$name = $leadAccountID->getFirstName(). " " .$leadAccountID->getLastName() ;
						echo '<option value='.$laid.'>'.$name.'</option>';
						
					}
					?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="txtDescription">Description</label>
				<textarea name="txtDescription" class="form-control" rows="5"></textarea>
			</div>
          <button class="btn btn-primary btn-block" type="submit">Create Project</button>
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
