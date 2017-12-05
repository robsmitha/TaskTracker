<?php
/**
 * Author: Jacob Mills
 * Date: 11/28/2017
 * Description: This page enables users to reset their password
 */


session_start();


include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");
include_once("DAL/accounts.php");
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";



$errorMessage = "";
$success = false;
$AccountID = SessionManager::getAccountID();
if($AccountID == 0){
    header("location:/login.php");
}
else{
    $account = new Accounts();
    $account->load($AccountID);
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $isValid=true;
    if($_POST["currentPw"]=="")
        $isValid=false;
    if($_POST["newPw"]=="")
        $isValid=false;
    if($_POST["confirmPw"]=="")
        $isValid=false;

    if($isValid==true) {
        $email = $account->getEmail();
        $currentPw = $_POST["currentPw"];
        $newPw = $_POST["newPw"];
        $confirmPw = $_POST["confirmPw"];

        if ($newPw == $confirmPw)
        {
            $isValid = Authentication::authLogin($email,$currentPw);
            if ($isValid) {

                Authentication::updatePassword($AccountID,$newPw);

                //redirect to account page
                header("location:/ViewAccount.php?accountid=$AccountID");
            }
            else {
                $errorMessage = "The current password field is not correct.";
            }
        }
        else {
            $errorMessage = "The new password fields do not match.";
        }
    }
    else {
        $errorMessage = "All fields are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include "head.php" ?>
<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php include "navbar.php" ?>

<!-- Page Content -->
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 mb-4 mt-4">
                <br/><br/>
                <h3>Reset Password</h3> <small></small>
                <br/>
                <?php
                if ($errorMessage != "")
                {
                    echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">";
                    echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
                    echo "<span aria-hidden=\"true\">&times;</span>";
                    echo "</button>";
                    echo "<strong>Error</strong> " . $errorMessage;
                    echo "</div>";
                }
                ?>


                <br/>
                <form name="update" id="updateForm" method="post" validate>

                    <div class="row">
                        <div class="control-group form-group col-lg-6 ">
                            <div class="controls">
                                <strong>Current Password:</strong><span style="color:red;">*</span>
                                <input type="password" class="form-control" id="currentPw" name="currentPw" required
                                       data-validation-required-message="Please enter your current password." maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="control-group form-group col-lg-6 ">
                            <div class="controls">
                                <strong>New Password:</strong><span style="color:red;">*</span>
                                <input type="password" class="form-control" id="newPw" name="newPw" required
                                       data-validation-required-message="Please enter your new password." maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="control-group form-group col-lg-6">
                            <div class="controls">
                                <strong>Confirm New Password:</strong><span style="color:red;">*</span>
                                <input type="password" class="form-control" id="confirmPw" name="confirmPw" required
                                       data-validation-required-message="Please confirm your new password." maxlength="255">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <button type="submit" class="btn btn-primary float-right">Update</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
</div>


<?php include "footer.php" ?>

<?php include "modal.php" ?>
<?php include "scripts.php" ?>
</body>
</html>

