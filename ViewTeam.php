<?php
//Check Session
session_start();
include_once("Utilities/SessionManager.php");
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}
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
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
include_once("DAL/accounts.php");
include "DAL/teams.php";
$team = new Teams();
$team->load($teamid);
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
                <?php echo $team->getName(); ?>
            </li>
        </ol>

        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="text-left">
                                    <?php echo $team->getName(); ?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-secondary pull-right" href="CreateTeam.php?cmd=edit&teamid=<?php echo $teamid ?>">Edit</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4>Description</h4>
                        <p><?php echo $team->getDescription(); ?></p>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <?php include "teams.php" ?>
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
