<?php
//Check Session
session_start();
if($_SESSION["LoggedIn"] == "")
    header("location:login.php?msg=notloggedin");

include "DAL/tasks.php";
include "DAL/accounts.php";

if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['accountid']) && is_numeric($_GET['accountid']))	//validate query string
    {
        $accountid = $_GET['accountid'];
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

$account = new Accounts();
$account->load($accountid);
$accountfullname = $account->getFirstName()." ".$account->getLastName();
$imgurl = $account->getImgURL();
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
                            <div class="col-sm-9">
                                <div class="text-left">
                                    <div class="text-left">
                                        <img src="<?php echo $imgurl; ?>" class="rounded" alt="<?php echo $accountfullname; ?>" title="<?php echo $accountfullname; ?>" style="height: 75px;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-secondary pull-right" href="CreateAccount.php?cmd=edit&accountid=<?php echo $account->getAccountID() ?>">Update Account</a>
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
                                <b>Role ID: </b><?php echo $account->getRoleID(); ?>
                            </div>
                        </div>
                        <hr>
                        <h4>Bio</h4>
                        <i><?php echo $account->getBio(); ?></i>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <?php
                $paramaccountid = $account->getAccountID();
                include "tasks.php";
                ?>
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
