<?php
session_start();
include_once("Utilities/SessionManager.php");
include_once("Utilities/Authentication.php");
include_once("Utilities/Mailer.php");
include_once("DAL/accounts.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $returnValue = true;
    $_POST['exampleInputName'] == "" ? $returnValue = false : $name = $_POST['exampleInputName'];
    $_POST['exampleInputLastName'] == "" ? $returnValue = false : $lastname = $_POST['exampleInputLastName'];
    $_POST['exampleInputEmail1'] == "" ?  $returnValue = false : $email = $_POST['exampleInputEmail1'];
    if($_POST['exampleInputPassword1'] == "")
    {
        $returnValue = false;
    }
    else
    {
        $password = $_POST['exampleInputPassword1'];
    }
    if($_POST['exampleConfirmPassword'] == "")
    {
        $returnValue = false;
    }
    else
    {
        if($_POST['exampleConfirmPassword'] != $password)   //verify passwords match
        {
            $returnValue = false;
        }
        else
        {
            $confirmPassword = $_POST['exampleConfirmPassword'];
        }
    }
    $_POST['dataLocation'] == "" ? $returnValue = false : $location = $_POST['dataLocation'];
    $_POST['dataDOB'] == "" ? $returnValue = false : $dateofbirth = $_POST['dataDOB'];
    //bio is optional
    $bio = $_POST['dataBio'];
    $imgurl = $_POST['dataImageURL'];


    if($returnValue)
    {
        $account = Accounts::lookup($email);
        if ($account != null) {
            // This email is already taken
            $errorMessage = "The provided email is already in use. Please try another email.";
        }
        else {
            $currentDate = date('Y-m-d H:i:s');
            $defaultRoleId = 6; // Read Onlt role

            $account = Authentication::createAccount($name, $lastname, $email, $password,$bio, $defaultRoleId, $imgurl, $dateofbirth, $location, $currentDate);
            if ($account == null) {
                // Something went wrong while attempting to create this user
                $validationMsg = "An error occurred during the creation of this user account. Please try again. If the problem continues, contact OpenDevTools support at opendevtools@gmail.com";
            }
            else {
                // Set session values for successful login
                SessionManager::setAccountID($account->getAccountID());
                SessionManager::setRoleID($account->getRoleID());
                // Send registration email
                Mailer::sendRegistrationEmail($account->getEmail());
                // Redirect to Dashboard
                header("location: index.php");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php" ?>
<body class="bg-dark">
<div class="container">
    <?php if(isset($validationMsg)) { ?>
        <div class="alert alert-danger alert-dismissible fade show mx-auto mt-5" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4> <?php  echo $validationMsg; ?> </h4>
        </div>
    <?php } ?>
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">
            <?php if(isset($editaccountid)) { ?>
                Edit Account
            <?php } else { ?>
                Register an Account
            <?php } ?>
        </div>
        <div class="card-body">

            <form method="post" onsubmit="return doValidation()">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleInputName">First name</label>
                            <input id="inputFirstName" class="form-control" name="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name" value="<?php if(isset($editfirstname)) echo $editfirstname; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputLastName">Last name</label>
                            <input id="inputLastName" class="form-control" name="exampleInputLastName" type="text" aria-describedby="nameHelp" placeholder="Enter last name" value="<?php if(isset($editlastname)) echo $editlastname; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input id="inputEmail" class="form-control" name="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php if(isset($editemail)) echo $editemail; ?>">
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="exampleInputPassword1">Password</label>
                            <input id="inputPassword" class="form-control" name="exampleInputPassword1" type="password" placeholder="Password" value="<?php if(isset($editpassword)) echo $editpassword; ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="exampleConfirmPassword">Confirm password</label>
                            <input id="inputConfirmPassword" class="form-control" name="exampleConfirmPassword" type="password" placeholder="Confirm password" value="<?php if(isset($editpassword)) echo $editpassword; ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dataImageURL">Image URL</label>
                    <input id="inputImgURL" class="form-control" name="dataImageURL" aria-describedby="emailHelp" placeholder="Enter Image URL" value="<?php if(isset($editimgurl)) echo $editimgurl; ?>">
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label for="dataLocation">Location</label>
                            <input id="inputLocation" class="form-control" name="dataLocation" placeholder="Location" value="<?php if(isset($editlocation)) echo $editlocation; ?>">
                        </div>
                        <div class="col-md-6" id="divDOB">
                            <label for="dataDOB">Date of Birth</label>
                            <input id="inputDOB" type="date" class="form-control" name="dataDOB" placeholder="09/19/1994" value="<?php if(isset($editdateofbirth)) echo $editdateofbirth; ?>" onkeyup="keyUP(event.keyCode)" onkeydown="return isNumeric(event.keyCode);" onpaste="return false;">
                            <div id="divValidateDate">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dataBio">Bio Description <small class="text-muted">(optional)</small></label>
                    <textarea id="inputBio" name="dataBio" class="form-control" rows="5"><?php if(isset($editbio)) echo $editbio; ?></textarea>
                </div>
                <input type="hidden" name="editaccountid" value="<?php if(isset($editaccountid)) echo $editaccountid; ?>">
                <input type="hidden" name="editcreatedate" value="<?php if(isset($editcreatedate)) echo $editcreatedate; ?>">
                <div class="form-group">
                    <?php if(isset($editaccountid)) { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-primary btn-secondary btn-block" href="ViewAccount.php?accountid=<?php echo $editaccountid; ?>">Back to Account</a>
                            </div>
                        </div>

                    <?php } else { ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <button class="btn btn-primary btn-block" type="submit">Register</button>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-secondary btn-block" href="login.php">Login Page</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include "scripts.php" ?>
<script>
    //javascript to prevent alphabetic & special chars input into task id search
    var isShift = false;
    function keyUP(keyCode) {

        if (keyCode == 16)
            isShift = false;
    }
    function isNumeric(keyCode) {
        if (keyCode == 16)
            isShift = true;

        var isValidInput = ((keyCode >= 48 && keyCode <= 57 || keyCode == 8 ||
            (keyCode >= 96 && keyCode <= 105) || keyCode == 13) && isShift == false);
        if (!isValidInput)
        {
            $('#inputDOB').removeClass('is-valid');	//change color of input
            $('#inputDOB').addClass('is-invalid');
        }
        else {
            $('#inputDOB').removeClass('is-invalid');
            $('#inputDOB').addClass('is-valid');
        }
        return isValidInput;
    }
    //javascript for form validation
    function doValidation() {
        var isValid = true;
        var firstName = $("#inputFirstName").val();
        var lastName = $("#inputLastName").val();
        var email = $("#inputEmail").val();
        var password = $("#inputPassword").val();
        var confirmPassword = $("#inputConfirmPassword").val();
        var imgURL = $("#inputImgURL").val();
        var location = $("#inputLocation").val();
        var dob = $("#inputDOB").val();
        var bio = $("#inputBio").val();
        if(firstName.length > 0)
        {
            $("#inputFirstName").addClass("is-valid");
            $("#inputFirstName").removeClass("is-invalid");
        }
        else
        {
            $("#inputFirstName").addClass("is-invalid");
            $("#inputFirstName").removeClass("is-valid");
            isValid = false;
        }
        if(lastName.length > 0)
        {
            $("#inputLastName").addClass("is-valid");
            $("#inputLastName").removeClass("is-invalid");
        }
        else
        {
            $("#inputLastName").addClass("is-invalid");
            $("#inputLastName").removeClass("is-valid");
            isValid = false;
        }
        if(email.length > 0)
        {
            $("#inputEmail").addClass("is-valid");
            $("#inputEmail").removeClass("is-invalid");
        }
        else
        {
            $("#inputEmail").addClass("is-invalid");
            $("#inputEmail").removeClass("is-valid");
            isValid = false;
        }
        if(password.length > 0)
        {
            $("#inputPassword").addClass("is-valid");
            $("#inputPassword").removeClass("is-invalid");
            if(confirmPassword.length > 0)
            {
                $("#inputConfirmPassword").addClass("is-valid");
                $("#inputConfirmPassword").removeClass("is-invalid");
            }
            else
            {
                $("#inputConfirmPassword").addClass("is-invalid");
                $("#inputConfirmPassword").removeClass("is-valid");
                isValid = false;
            }
        }
        else
        {
            $("#inputPassword").addClass("is-invalid");
            $("#inputPassword").removeClass("is-valid");
            isValid = false;
        }
        if(confirmPassword.length > 0)
        {
            $("#inputConfirmPassword").addClass("is-valid");
            $("#inputConfirmPassword").removeClass("is-invalid");
        }
        else
        {
            $("#inputConfirmPassword").addClass("is-invalid");
            $("#inputConfirmPassword").removeClass("is-valid");
            isValid = false;
        }
        if(imgURL.length > 0)
        {
            $("#inputImgURL").addClass("is-valid");
            $("#inputImgURL").removeClass("is-invalid");
        }
        else
        {
            $("#inputImgURL").addClass("is-invalid");
            $("#inputImgURL").removeClass("is-valid");
            isValid = false;
        }

        if(location.length > 0)
        {
            $("#inputLocation").addClass("is-valid");
            $("#inputLocation").removeClass("is-invalid");
        }
        else
        {
            $("#inputLocation").addClass("is-invalid");
            $("#inputLocation").removeClass("is-valid");
            isValid = false;
        }
        if(dob.length > 0)
        {
            $("#inputDOB").addClass("is-valid");
            $("#inputDOB").removeClass("is-invalid");
        }
        else
        {
            $("#inputDOB").addClass("is-invalid");
            $("#inputDOB").removeClass("is-valid");
            isValid = false;
        }
        if(bio.length > 0)
        {
            $("#inputBio").addClass("is-valid");
            $("#inputBio").removeClass("is-invalid");
        }
        else
        {
            $("#inputBio").addClass("is-invalid");
            $("#inputBio").removeClass("is-valid");
            isValid = false;
        }
        return isValid;
    }
</script>
</body>

</html>
