<?php
//Check Session
session_start();
include_once("Utilities/SessionManager.php");
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}

include "DAL/tasks.php";
include "DAL/accounts.php";
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['accountid']) && is_numeric($_GET['accountid']))	//validate query string
    {
        $accountid = $_GET['accountid'];
        if(isset($_GET["messageid"]) && is_numeric($_GET["messageid"])){
            $message = new Messages();
            $message->load($_GET["messageid"]);
            $message->setSeen(1);
            $message->save();
        }
    }
    else
    {
        header("location:index.php");
    }
    $account = new Accounts();
    $account->load($accountid);
    $accountfullname = $account->getFirstName()." ".$account->getLastName();
    $imgurl = $account->getImgURL();
}
else
{
    header("location:index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $returnVal = true;
    $_POST["messageArea"] == "" ? $returnVal = false : $messageArea = $_POST["messageArea"];
    if($returnVal){
        $message = new Messages();
        $message->setMessageID(0);
        $message->setDescription($messageArea);
        $message->setSenderAccountID(SessionManager::getAccountID());
        $message->setRecipientAccountID($_POST["hfaccountid"]);
        $message->setSeen(0);
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d H:i:s');
        $message->setSentDate($date);
        $message->save();
        $id = $message->getRecipientAccountID();
        header("location:ViewAccount.php?accountid=$id");
    }
}


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
                <?php echo $accountfullname; ?>
            </li>
        </ol>

        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-12">
                                <img src="<?php echo $imgurl; ?>" class="rounded" alt="<?php echo $accountfullname; ?>" title="<?php echo $accountfullname; ?>" style="height: 75px;">
                                <div class="btn-group pull-right">
                                    <a class="btn btn-secondary" href="Messages.php"><i class="icon-envelope m-auto"></i> Messages</a>
                                    <a class="btn btn-secondary pull-right" href="CreateAccount.php?cmd=edit&accountid=<?php echo $account->getAccountID() ?>"><i class="icon-settings m-auto"></i> Update Account</a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-body">

                        <h4>Details</h4>
                        <div class="row">
                            <div class="col-sm-6">
                                <b>Location: </b><?php echo $account->getLocation(); ?>
                            </div>
                            <div class="col-sm-6">
                                <b>Date of Birth: </b><?php echo $account->getDateOfBirth(); ?>
                            </div>
                            <div class="col-sm-6">
                                <b>Email: </b><?php echo $account->getEmail(); ?>
                            </div>
                            <div class="col-sm-6">
                                <b>Create Date: </b><?php echo $account->getCreateDate(); ?>
                            </div>
                            <div class="col-sm-6">
                                <b>Role ID: </b>
                                <a href="ViewRole.php?roleid=<?php echo $account->getRoleID(); ?>" title="View <?php echo $account->getRoleID(); ?> ?>">
                                    <?php echo $account->getRoleID(); ?>
                                </a>

                            </div>
                        </div>
                        <hr>
                        <h4>Bio</h4>
                        <i><?php echo $account->getBio(); ?></i>
                    </div>
                    <div class="card-footer">
                        <form id="CommentForm" class="form-group" method="post" onsubmit="return doValidation();">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <textarea id="inputDescription" type="text" class="form-control" rows="4" name="messageArea" placeholder="Send a message"></textarea>
                                        <button type="submit" name="SendMessage" class="input-group-addon btn btn-primary"><i class="fa fa-paper-plane"></i>Send Message</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="hfaccountid" value="<?php echo $account->getAccountID() ?>">
                        </form>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <?php
                $TaskList = Tasks::loadbyaccountid($account->getAccountID());
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
                                <?php echo $account->getFirstName(); ?> Task Statistics
                            </div>
                            <div class="col-3">
                                <a class="btn btn-secondary pull-right" href="CreateTask.php"><i class="icon-plus m-auto"></i> Create Task</a>
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
                                    {label: "Testing Tasks", value: <?php echo $numOfReadyForTestingTasks; ?>},
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
<script>
    function doValidation() {
        var isValid = true;
        var Description = $("#inputDescription").val();
        if(Description.length > 0)
        {
            $("#inputDescription").addClass("is-valid");
            $("#inputDescription").removeClass("is-invalid");
        }
        else
        {
            $("#inputDescription").addClass("is-invalid");
            $("#inputDescription").removeClass("is-valid");
            isValid = false;
        }
        return isValid;
    }
</script>
</body>

</html>
