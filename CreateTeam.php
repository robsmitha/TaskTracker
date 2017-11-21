<?php
#region validate session & query
session_start();
include_once("Utilities/SessionManager.php");
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
include "DAL/accounts.php";
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}
include "DAL/teams.php";
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['msg']))
        $alertmsg = $_GET['msg'];
    //existing roles being edited
    if(isset($_GET['cmd']) && isset($_GET['teamid']))
    {
        if($_GET['cmd'] == "edit" && is_numeric($_GET['teamid']))
        {
            $editteam = new Teams();
            $editteam->load($_GET['teamid']);
            $editteamid = $editteam->getTeamID();
            $editteamname = $editteam->getName();
            $editdescription = $editteam->getDescription();
        }
    }
}
#endregion
/*
 * For Post Back (Submit)
 */
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $returnValue = true;
    if($_POST['dataTeamName'] == "")
    {
        $returnValue = false;
    }
    else
    {
        $teamname = $_POST['dataTeamName'];
    }
    if($_POST['txtDescription'] == "")
    {
        $returnValue = false;
    }
    else
    {
        $description = $_POST['txtDescription'];
    }
    if($returnValue)
    {
        if(isset($_POST["editteamid"]) && $_POST["editteamid"] > 0)
        {
            $tid = $_POST["editteamid"];
            if(is_numeric($tid))
            {
                $team = new Teams();
                $team->load($tid);
                $team->setName($teamname);
                $team->setDescription($description);
                $team->save();
                header("location:ViewTeam.php?teamid=$tid");
            }
        }
        else
        {
            $team = new Teams();
            $team->load(0);
            $team->setName($teamname);
            $team->setDescription($description);
            $team->save();

            $tid = $team->getTeamID();
            header("location:ViewTeam.php?teamid=$tid");
        }
    }
    else
    {
        header("location:CreateTeam.php?msg=validate");
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
                <?php if(isset($editteamid)) { ?>
                    Edit <?php echo $editteamname ?>
                <?php } else { ?>
                    Create Team
                <?php } ?>
            </li>
        </ol>
        <div class="row">
            <div class="col-lg-8">
                <?php if(isset($alertmsg)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4> <?php  echo $alertmsg; ?> </h4>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-header"><i class="icon-people m-auto"></i>
                        <?php if(isset($editteamid)) { ?>
                            <div class="row">
                                <div class="col-sm-9">
                                    Edit <?php echo $editteamname ?> Team
                                </div>
                                <div class="col-sm-3">

                                </div>
                            </div>
                        <?php } else { ?>
                            Create Team
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <form id="formCreateRole" method="post" onsubmit="return doValidation()">
                            <div class="form-group">
                                <label for="dataTeamName">Team name</label>
                                <input id="inputTeamName" class="form-control" name="dataTeamName" type="text" aria-describedby="nameHelp" placeholder="Enter team name" value="<?php if(isset($editteamname)) echo $editteamname ?>">
                            </div>
                            <div class="form-group">
                                <label for="txtDescription">Description</label>
                                <textarea id="inputDescription" name="txtDescription" class="form-control" rows="5"><?php if(isset($editdescription)) echo $editdescription ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <?php if(isset($editteamid)) { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <a class="btn btn-secondary btn-block" href="ViewTeam.php?roleid=<?php echo $editteamid ?>">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary btn-block" type="submit" onsubmit="">Create Team</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <a class="btn btn-secondary btn-block" href="index.php">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="editteamid" value="<?php if(isset($editteamid)) echo $editteamid ?>">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <?php include "teams.php" ?>
            </div>
        </div>
    </div><!-- /.container-fluid-->
</div> <!-- /.content-wrapper-->
<?php include "footer.php"?>
<?php include "modal.php"?>
<?php include "scripts.php" ?>

<script>
    function doValidation() {
        var isValid = true;
        var teamName = $("#inputTeamName").val();
        var description = $("#inputDescription").val();

        if(teamName.length > 0)
        {
            $("#inputTeamName").addClass("is-valid");
            $("#inputTeamName").removeClass("is-invalid");
        }
        else
        {
            $("#inputTeamName").addClass("is-invalid");
            $("#inputTeamName").removeClass("is-valid");
            isValid = false;
        }
        if(description.length > 0)
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
