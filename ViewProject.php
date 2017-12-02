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
    if(isset($_GET['projectid']) && is_numeric($_GET['projectid']))	//validate query string
    {
        $projectid = $_GET['projectid'];
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
include "DAL/tasks.php";
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
//Project
include "DAL/projects.php";
$project = new Projects();
$project->load($projectid);

//Project
include "DAL/projectcategorytypes.php";
$projectcategorytype = new Projectcategorytypes();
$projectcategorytype->load($project->getProjectCategoryID());


//Account
include "DAL/accounts.php";
$projectleadaccount = new Accounts();
$projectleadaccount->load($project->getProjectLeadAccountID());	//leader obj
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
                <?php echo $project->getProjectName(); ?>
            </li>
        </ol>

        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-9">
                                <div class="text-left">
                                    <?php $projectimgurl = $project->getImgURL(); $projectname = $project->getProjectName(); ?>
                                    <img src="<?php echo $projectimgurl; ?>" class="rounded" alt="<?php echo $projectname; ?>" title="<?php echo $projectname; ?>" style="height: 75px;">
                                </div>
                            </div>
                            <div class="col-3">
                                    <a class="btn btn-secondary pull-right" href="CreateProject.php?cmd=edit&projectid=<?php echo $projectid ?>">Update Project</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <h4>Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <b>Project Type: </b><?php echo $projectcategorytype->getProjectCategoryType(); ?>
                            </div>
                            <div class="col-sm-6">
                                <b>Project Lead: </b><a href="ViewAccount.php?accountid=<?php echo $projectleadaccount->getAccountID() ?>"><?php echo $projectleadaccount->getFirstName(). " " .$projectleadaccount->getLastName(); ?></a>  <br>
                            </div>
                        </div>
                        <hr>
                        <h4>Description</h4>
                        <p><?php echo $project->getProjectDescription(); ?></p>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <?php
                $TaskList = Tasks::loadbyprojectid($project->getProjectID());
                $numOfOpenTasks = 0;
                $numOfReadyForTestingTasks = 0;
                $numOfReopenedTasks = 0;
                $numOfClosedTasks = 0;
                $numOfInProgressTasks = 0;
                $numOfResolvedTasks = 0;
                foreach ($TaskList as $task){
                    switch ($task->getStatusTypeID()){
                        case 1:	//open
                            $numOfOpenTasks = $numOfOpenTasks + 1;
                            break;
                        case 2:	//in progress
                            $numOfInProgressTasks = $numOfInProgressTasks + 1;
                            break;
                        case 3:	//resolved
                            $numOfResolvedTasks = $numOfResolvedTasks + 1;
                            break;
                        case 4:	//ready for testing
                            $numOfReadyForTestingTasks = $numOfReadyForTestingTasks + 1;
                            break;
                        case 5:	//reopened
                            $numOfReopenedTasks = $numOfReopenedTasks + 1;
                            break;
                        case 6:	//closed
                            $numOfClosedTasks = $numOfClosedTasks + 1;
                            break;
                        default:
                            //do nothing
                            break;
                    }
                }
                ?>
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-9">
                                <?php echo $projectname; ?> Task Statistics
                            </div>
                            <div class="col-3">
                                <a class="btn btn-secondary pull-right" href="CreateTask.php">Create Task</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="donut-example"></div>
                        <script>
                            Morris.Donut({
                                element: 'donut-example',
                                data: [
                                    {label: "Open Tasks", value: <?php echo $numOfOpenTasks; ?>},
                                    {label: "Ready For Testing Tasks", value: <?php echo $numOfReadyForTestingTasks; ?>},
                                    {label: "Closed Tasks", value: <?php echo $numOfClosedTasks; ?>}
                                ]
                            });
                        </script>
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
</div>

</body>

</html>
