<?php
//Check Session
session_start();
if($_SESSION["LoggedIn"] == "")
    header("location:login.php?msg=notloggedin");


//Check Query
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['teamid']) && is_numeric($_GET['teamid']))	//validate query string
    {
        $teamid = $_GET['teamid'];
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
include "DAL/teams.php";
$role = new Roles();
$role->load($roleid);
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
            <li class="breadcrumb-item active">
                <?php echo $role->getRole(); ?>
            </li>
        </ol>

        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="text-left">
                                    <?php echo $role->getRole(); ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-secondary pull-right" href="CreateRole.php?cmd=edit&roleid=<?php echo $roleid ?>">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Description</h4>
                        <p><?php echo $role->getDescription(); ?></p>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <?php include "roles.php" ?>
            </div>
        </div>

    </div>
    <!-- /.container-fluid-->
</div>
<!-- /.content-wrapper-->
<?php include "footer.php"?>
<?php include "modal.php"?>
<?php include "scripts.php" ?>
</div>

</body>

</html>
