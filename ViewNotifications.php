<?php
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
include_once("DAL/accounts.php");
include "DAL/roles.php";
//Check Session
session_start();
include_once("Utilities/SessionManager.php");


$ActiveAccountID = SessionManager::getAccountID();
if($ActiveAccountID == 0)
{
    header("location: login.php");
}


if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["btnClearAll"])){
        Notifications::clearnotificationsbyaccountid($ActiveAccountID); //users can only clear their own notifications
    }
}



$ActiveAccountObj = new Accounts();
$ActiveAccountObj->load($ActiveAccountID);
$NotificationsList = Notifications::loadbyaccountid($ActiveAccountID);
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
                Notifications
            </li>
        </ol>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-8">
                                <h3>Notifications for <?php echo $ActiveAccountObj->getFirstName(). " " .$ActiveAccountObj->getLastName(); ?></h3>
                            </div>
                            <div class="col-4">
                                <form method="post">
                                    <button type="submit" id="btnClearAll" name="btnClearAll" class="btn btn-danger pull-right" title="clear all notifications">Clear All</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if(isset($NotificationsList)){
                            $i = 0;
                            $likes = 0;
                            $comments = 0;
                            $statusUpdate = 0;
                            foreach ($NotificationsList as $n)
                            {
                                ?>
                                <div class="dropdown-divider"></div>
                                <a id="<?php echo $n->getNotificationID() ?>" href="ViewTask.php?taskid=<?php echo $n->getTaskID() ?>&notificationid=<?php echo $n->getNotificationID()?>">
                                    <?php
                                    $nt = new Notificationtypes();
                                    $nt->load($n->getNotificationTypeID());
                                    switch ($n->getNotificationTypeID()){
                                        case 1: //likes
                                            $cssclass = "text-primary";
                                            $likes = $likes + 1;
                                            break;
                                        case 2:   //comments
                                            $cssclass = "text-warning";
                                            $comments = $comments + 1;
                                            break;
                                        case 3:   //status update
                                            $cssclass = "text-success";
                                            $statusUpdate = $statusUpdate + 1;
                                            break;
                                        default:
                                            break;
                                    }
                                    ?>
                                    <span class="<?php echo $cssclass; ?>">
                            <strong>
                              <i class="fa fa-long-arrow-up fa-fw"></i><?php echo $nt->getNotification(); ?></strong>
                          </span>
                                    <span class="small float-right text-muted"><?php echo $n->getCreateDate(); ?></span>
                                    <div class="dropdown-message small"><?php echo $nt->getDescription(); ?></div>
                                </a>
                                <form class="notification-form" id="FORM_<?php echo $n->getNotificationID() ?>">
                                    <input type="hidden" name="hfnotificationid" value="<?php echo $n->getNotificationID() ?>">
                                </form>
                                <?php
                                $i = $i + 1;
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div id="donut-example"></div>
                <script>
                    Morris.Donut({
                        element: 'donut-example',
                        data: [
                            {label: "Likes", value: <?php echo $likes; ?>},
                            {label: "Comments", value: <?php echo $comments; ?>},
                            {label: "Status Updates", value: <?php echo $statusUpdate; ?>}
                        ]
                    });
                </script>
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
