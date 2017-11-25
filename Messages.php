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
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}

$ActiveAccountID = SessionManager::getAccountID();
$ActiveAccountObj = new Accounts();
$ActiveAccountObj->load($ActiveAccountID);

$MessagesList = Messages::loadbyrecipientaccountid($ActiveAccountObj->getAccountID());
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
                <?php echo $ActiveAccountObj->getFirstName()."'s Messages"; ?>
            </li>
        </ol>

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-12">
                                <h3><i class="icon-folder"></i> Inbox</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                        if(!empty($MessagesList)){
                            foreach($MessagesList as $message) {
                                $senderaccount = new Accounts();
                                $senderaccount->load($message->getSenderAccountID());
                                ?>
                                <a class="dropdown-item" href="ViewMessages.php?accountid=<?php echo $message->getSenderAccountID(); ?>&messageid=<?php echo $message->getMessageID(); ?>">
                                    <strong><?php echo $senderaccount->getFirstName(). " " .$senderaccount->getLastName(); ?></strong>
                                    <span class="small float-right text-muted"><?php echo $message->getSentDate(); ?></span>
                                    <div class="dropdown-message small"><?php echo $message->getDescription(); ?>
                                    </div>
                                </a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">

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
