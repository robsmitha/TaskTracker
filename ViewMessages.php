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


if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["accountid"]) && is_numeric($_GET["accountid"])
    && $_GET["accountid"] > 0){
        $senderAccountObj = new Accounts();
        $senderAccountObj->load($_GET["accountid"]);
    }
}

$ActiveAccountID = SessionManager::getAccountID();
$ActiveAccountObj = new Accounts();
$ActiveAccountObj->load($ActiveAccountID);

$MessageList = Messages::loadmessagesbysenderrecipient($senderAccountObj->getAccountID(),$ActiveAccountObj->getAccountID());
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
                <a href="Messages.php">
                    <?php echo $ActiveAccountObj->getFirstName()."'s Messages"; ?>
                </a>
            </li>
            <li class="breadcrumb-item active">
                Messages with <?php echo $senderAccountObj->getFirstName(). " " .$senderAccountObj->getLastName(); ?>
            </li>
        </ol>

        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="bg-light" style="padding: 12px;">
                        <div class="row">
                            <div class="col-12">
                                <h3>Messages with <?php echo $senderAccountObj->getFirstName(). " " .$senderAccountObj->getLastName(); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php
                            if(isset($MessageList)){
                                $i = 0;
                                foreach ($MessageList as $message)
                                {
                                    if($message->getSenderAccountID() == $ActiveAccountObj->getAccountID()){
                                        //build acct obj for this acct id (pull-right)
                                        $account = new Accounts();
                                        $account->load($message->getSenderAccountID());  //we only want to load sender, trust me..
                                        ?>
                                        <!-- comment -->
                                        <div class="comment mb-2 row">
                                            <div class="comment-content col-md-11 col-sm-10">
                                                <div class="pull-right">
                                                <h6 class="small comment-meta">
                                                    <a href="ViewAccount.php?accountid=<?php echo $message->getSenderAccountID(); ?>">
                                                        <?php
                                                        echo $account->getFirstName(). " " .$account->getLastName();
                                                        ?>
                                                    </a>
                                                    <small><?php echo $message->getSentDate(); ?></small>
                                                </h6>
                                                <div class="comment-body">
                                                    <p>
                                                        <?php echo $message->getDescription(); ?>
                                                        <br>
                                                    </p>
                                                </div>
                                                </div>
                                            </div>
                                            <div class="comment-avatar col-md-1 col-sm-2 text-center pr-1">
                                                <a href=""><img class="mx-auto rounded-circle img-fluid img-avatar" src="<?php echo $account->getImgURL() ?>" alt="avatar"></a>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                        <?php
                                    }
                                    else{
                                        //build acct obj for this recipient acct id (pull-right)
                                        $account = new Accounts();
                                        $account->load($message->getSenderAccountID());  //load recipient
                                        ?>
                                        <!-- comment -->
                                        <div class="comment mb-2 row">
                                            <div class="comment-avatar col-md-1 col-sm-2 text-center pr-1">
                                                <a href=""><img class="mx-auto rounded-circle img-fluid img-avatar" src="<?php echo $account->getImgURL() ?>" alt="avatar"></a>
                                            </div>
                                            <div class="comment-content col-md-11 col-sm-10">

                                                <h6 class="small comment-meta">
                                                    <a href="ViewAccount.php?accountid=<?php echo $message->getSenderAccountID(); ?>">
                                                        <?php
                                                        echo $account->getFirstName(). " " .$account->getLastName();
                                                        ?>
                                                    </a>
                                                    <small><?php echo $message->getSentDate(); ?></small>
                                                </h6>
                                                <div class="comment-body">
                                                    <p>
                                                        <?php echo $message->getDescription(); ?>
                                                        <br>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /comment -->
                                        <?php
                                    }
                                ?>
                                <hr>
                        <?php
                                    $i = $i + 1;
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
