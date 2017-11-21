<?php
session_start();
include_once("Utilities/SessionManager.php");
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}
include "DAL/accounts.php";
include  "DAL/roles.php";
include  "DAL/teams.php";
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";

if($_SERVER["REQUEST_METHOD"] == "POST")    //check for postback (submit)
{
    $searchbarvalue = isset($_POST["searchBox"]) ? $_POST["searchBox"] : "";
    if($searchbarvalue != "")   //user searched from search bar
    {
        //do search stuff
        if(is_numeric(($searchbarvalue)))
        {
            //set up search by Account id
            $AccountSearchList = Accounts::search($searchbarvalue,"","","","","","","","","","");

        }
        else{
            //set search by keyword
            $AccountSearchList = Accounts::search("",$searchbarvalue,"","","","","","","","","");
        }
    }
    else{
        //variables for search
        $accountid = isset($_POST['AccountID']) ? $_POST['AccountID'] : "";
        $firstname = isset($_POST["FirstName"]) ? $_POST["FirstName"] : "";
        $lastname = isset($_POST["LastName"]) ? $_POST["LastName"] : "";
        $email = isset($_POST["Email"]) ? $_POST["Email"] : "";

        if(isset($_POST["ddlRoles"]))
        {
            $roleid = $_POST['ddlRoles'] == 0 ? "" : $_POST['ddlRoles'];
        }
        else {
            $roleid = "";
        }
        if(isset($_POST["ddlTeams"]))
        {
            $teamid = $_POST['ddlTeams'] == 0 ? "" : $_POST['ddlTeams'];
        }
        else {
            $teamid = "";
        }

        $dateofbirth = isset($_POST["DateOfBirth"]) ? $_POST["DateOfBirth"] : "";
        $location = isset($_POST["Location"]) ? $_POST["Location"] : "";
        $createdate = isset($_POST["CreateDate"]) ? $_POST["CreateDate"] : "";

        $AccountSearchList = Accounts::search($accountid, $firstname, $lastname, $email, "","", $roleid, "", $dateofbirth, $location, $createdate);

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
                <?php if(isset($AccountSearchList)) { ?>
                    Search Results
                <?php } else { ?>
                    Search Accounts
                <?php } ?>
            </li>
        </ol>
        <?php if(isset($AccountSearchList)) { ?>
            <script>
                $( document ).ready(function() {
                    if ($(window).width() < 769) {
                        $("#gridSearchResults").addClass("table-responsive");
                    }
                });
            </script>
            <table id="gridSearchResults" class="table table-striped">
                <thead class="">
                <tr>
                    <th scope="col">Account ID</th>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Role</th>
                    <th scope="col">Location</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($AccountSearchList as $account)
                {?>
                    <tr id="AccountID<?php echo $account->getAccountID() ?>">
                        <th scope="row">
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link"><?php echo $account->getAccountID() ?></a>
                        </th>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link"><?php echo $account->getFirstName() ?></a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link"><?php echo $account->getLastName() ?></a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link"><?php echo $account->getEmail() ?></a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link"><?php echo $account->getDateOfBirth() ?></a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link">
                                <?php
                                $r = new Roles();
                                $r->load($account->getRoleID());
                                echo $r->getRole();
                                ?>
                            </a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID() ?>" class="btn btn-link"><?php echo $account->getLocation() ?></a>
                        </td>
                    </tr>
                    <?php
                }   //end foreach
                ?>
                </tbody>
            </table>
        <?php } ?>
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <i class="icon-people m-auto"></i> Search Accounts
                    </div>
                    <div class="card-body">

                        <form id="searchForm" method="post" action="">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="AccountID">Account ID</label>
                                    <input id="inputAccountID" class="form-control" name="AccountID" type="text" aria-describedby="nameHelp" placeholder="Enter task name" onkeydown="return isNumeric(event.keyCode);" onkeyup="keyUP(event.keyCode)" value="<?php if(isset($accountid)) echo $accountid ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="FirstName">First Name</label>
                                    <input name="FirstName" class="form-control" value="<?php if(isset($firstname)) echo $firstname ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="LastName">Last Name</label>
                                    <input name="LastName" class="form-control" value="<?php if(isset($lastname)) echo $lastname ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="ddlRoles">Role</label>
                                            <select name="ddlRoles" class="form-control">
                                                <?php
                                                if(isset($roleid))
                                                {
                                                    $r = new Roles();
                                                    $r->load($roleid);
                                                    echo "<option value='$roleid'>";
                                                    echo $r->getRole();
                                                    echo '</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="0">---Role---</option>';
                                                }

                                                $RoleList = Roles::loadall();
                                                foreach($RoleList as $role)
                                                {
                                                    if(isset($roleid) && $role->getRoleID() == $roleid)
                                                    {
                                                        //skip
                                                    }
                                                    else
                                                    {
                                                        $roleid = $role->getRoleID();
                                                        echo "<option value='$roleid'>";
                                                        echo $role->getRole();
                                                        echo '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="ddlTeams">Team</label>
                                            <select name="ddlTeams" class="form-control">
                                                <?php
                                                if(isset($teamid))
                                                {
                                                    $t = new Teams();
                                                    $t->load($teamid);
                                                    echo "<option value='$teamid'>";
                                                    echo $t->getName();
                                                    echo '</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="0">---Team---</option>';
                                                }

                                                $TeamList = Teams::loadall();
                                                foreach($TeamList as $team)
                                                {
                                                    if(isset($teamid) && $team->getTeamID() == $teamid)
                                                    {
                                                        //skip
                                                    }
                                                    else
                                                    {
                                                        $teamid = $team->getTeamID();
                                                        echo "<option value='$teamid'>";
                                                        echo $team->getName();
                                                        echo '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <?php if(isset($AccountSearchList)) { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-primary btn-block" type="submit">Search Again</button>
                                            </div>
                                            <div class="col-6">
                                                <a class="btn btn-secondary btn-block" href="SearchAccounts.php">Clear Search</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-primary btn-block" type="submit">Search</button>
                                            </div>
                                            <div class="col-6">
                                                <a class="btn btn-secondary btn-block" href="index.php">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">

            </div>
        </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    </script>
    <script>
    var isShift = false;
    var ctrlDown = false
    function keyUP(keyCode) {

        if (keyCode == 16)
            isShift = false;

        if (keyCode == 17)
            ctrlDown = true;

        if (keyCode == 91)
            ctrlDown = true;
    }
    function isNumeric(keyCode) {

        ctrlKey = 17,
            cmdKey = 91,
            vKey = 86,
            cKey = 67;
        xKey = 88;
        zKey = 90;
        //allow keyboard shortcuts of copy/paste
        if (keyCode == 16)
            isShift = true;

        var isValidInput = ((keyCode >= 48 && keyCode <= 57 || keyCode == 8 || keyCode == 9 || keyCode == 13 ||
            (keyCode == vKey && ctrlDown) || (keyCode == cKey && ctrlDown) || (keyCode == xKey && ctrlDown) || (keyCode == zKey && ctrlDown) || keyCode == ctrlKey || keyCode == cmdKey ||
            (keyCode >= 96 && keyCode <= 105)) && isShift == false);

        if (!isValidInput)
        {
            //$("#InputWarningLabel").removeClass("hidden");
            $("#inputAccountID").addClass("is-invalid");
            // setTimeout(function () { $('#InputWarningLabel').addClass("hidden"); }, 1750);
        }
        else {
            $("#inputAccountID").removeClass("is-invalid");
            $("#inputAccountID").addClass("is-valid");
            //$("#InputWarningLabel").addClass("hidden");
        }
        return isValidInput;
    }
    </script>
    <?php include "footer.php" ?>
    <?php include "modal.php" ?>
    <?php include "scripts.php" ?>

</div>
</body>

</html>
