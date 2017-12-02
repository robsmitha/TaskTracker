<?php
/**
 * Author: Jacob Mills
 * Date: 11/28/2017
 * Description: This page enables users request a password reset
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

/*if(SessionManager::getAccountID() == 0){
    header("location:/login.php");
}*/

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $isValid = true;

    if($_POST["email"] == "")
        $isValid = false;

    if($isValid) {

        $email = $_POST["email"];

        $searchResults = Accounts::search(null,null,null,$email,null,null,null,null,null,null,null);

        if (count($searchResults) > 0)
        {
            $AccountID = $searchResults[0]->getAccountID();
            $Email = $searchResults[0]->getEmail();


            // Generate random password
            $password = bin2hex(openssl_random_pseudo_bytes(16));

            // Update the user's password
            Authentication::updatePassword($AccountID,$password);

            // Create the email and send the message
            $email_subject = "New OpenDevTools Password";
            $email_body = "You recently requested a password reset for the following account: $username<br/><br/>New Password: $password<br/><br/>If you did not request this password change, please contact opendevtools@gmail.com immediately.<br/><br/>Sincerely,<br/>The OpenDevTools team";

            Mailer::sendGenericEmail($email,$email_subject,$email_body);
        }

        // Display success message regardless of whether or not an email was found.
        // We don't want malicious users to be able to identify usernames and emails of others.
        $success = true;
    }
    else {
        $errorMessage = "All fields are required.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include "head.php" ?>
<body class="bg-dark">

<!-- Page Content -->
<div class="container">
    <?php
    if ($errorMessage != "")
    {
        echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
        echo "<span aria-hidden=\"true\">&times;</span>";
        echo "</button>";
        echo "<strong>Error</strong> " . $errorMessage;
        echo "</div>";
    } elseif ($success)
    {
        echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">";
        echo "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">";
        echo "<span aria-hidden=\"true\">&times;</span>";
        echo "</button>";
        echo "<strong>Success</strong> We sent a new password for this account to your email address.";
        echo "</div>";
    }
    ?>
    <div class="row">
        <div class="col-lg-12 mb-4 mt-4">
            <div class="card card-register mx-auto mt-5">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8">
                            <h3>Forgot Password</h3>
                        </div>
                        <div class="col-4">
                            <a href="login.php" class="btn btn-secondary float-right">Login</a>
                        </div>
                    </div>


                </div>
                <div class="card-body">
                    <form name="update" id="updateForm" method="post" validate>
                        <div class="row">
                            <div class="col-lg-2"></div>
                            <div class="control-group form-group col-lg-8">
                                <div class="controls">
                                    <strong>Email Address:</strong><span style="color:red;">*</span>
                                    <input type="email" class="form-control" id="email" name="email" required
                                           data-validation-required-message="Please enter the email address for this account." maxlength="255">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-8">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">Remind Me</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->


</body>
</html>