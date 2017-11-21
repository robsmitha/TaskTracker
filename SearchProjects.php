<?php
session_start();
include_once("Utilities/SessionManager.php");
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}
include "DAL/accounts.php";
include  "DAL/projects.php";
include  "DAL/projectcategorytypes.php";
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
            //set up search by project id
            $ProjectSearchList = Projects::search($searchbarvalue,"","","","","","","","","","");

        }
        else{
            //set search by keyword (projecct name)
            $ProjectSearchList = Projects::search("",$searchbarvalue,"","","","","","","","","");
        }
    }
    else{
        //variables for search
        $projectid = isset($_POST['ProjectID']) ? $_POST['ProjectID'] : "";
        $projectname = isset($_POST["ProjectName"]) ? $_POST["ProjectName"] : "";
        $projectdescription = isset($_POST["ProjectDescription"]) ? $_POST["ProjectDescription"] : "";
        $projecturl = isset($_POST["ProjectURL"]) ? $_POST["ProjectURL"] : "";

        if(isset($_POST["ddlProjectCategories"]))
        {
            $projectcategoryid = $_POST['ddlProjectCategories'] == 0 ? "" : $_POST['ddlProjectCategories'];
        }
        else {
            $projectcategoryid = "";
        }
        if(isset($_POST["ddlProjectLead"]))
        {
            $projectleadaccountid = $_POST['ddlProjectLead'] == 0 ? "" : $_POST['ddlProjectLead'];
        }
        else {
            $projectleadaccountid = "";
        }
        $ProjectSearchList = Projects::search($projectid,$projectname, $projectdescription, "",$projecturl, $projectleadaccountid, $projectcategoryid);

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
                <?php if(isset($ProjectSearchList)) { ?>
                    Search Results
                <?php } else { ?>
                    Search Project
                <?php } ?>
            </li>
        </ol>
        <?php if(isset($ProjectSearchList)) { ?>
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
                    <th scope="col">Project ID</th>
                    <th scope="col">Project Name</th>
                    <th scope="col">Project Url</th>
                    <th scope="col">Lead Account</th>
                    <th scope="col">Category</th>
                    <th scope="col">Description</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($ProjectSearchList as $project)
                {?>
                    <tr id="ProjectID<?php echo $project->getProjectID() ?>">
                        <th scope="row">
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectID() ?>" class="btn btn-link"><?php echo $project->getProjectID() ?></a>
                        </th>
                        <td>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectID() ?>" class="btn btn-link"><?php echo $project->getProjectName() ?></a>
                        </td>
                        <td>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectID() ?>" class="btn btn-link"><?php echo $project->getProjectURL() ?></a>
                        </td>
                        <td>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectID() ?>" class="btn btn-link"><?php echo $project->getProjectLeadAccountID() ?></a>
                        </td>
                        <td>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectID() ?>" class="btn btn-link"><?php echo $project->getProjectCategoryID() ?></a>
                        </td>
                        <td>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectID() ?>" class="btn btn-link"><?php echo $project->getProjectDescription() ?></a>
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
                        <i class="icon-folder m-auto"></i> Search Project
                    </div>
                    <div class="card-body">

                        <form id="searchForm" method="post" action="">
                            <div class="row form-group">
                                <div class="col-md-4">
                                    <label for="ProjectID">Project ID</label>
                                    <input id="inputProjectID" class="form-control" name="ProjectID" type="text" aria-describedby="nameHelp" placeholder="Enter Project ID" onkeydown="return isNumeric(event.keyCode);" onkeyup="keyUP(event.keyCode)" value="<?php if(isset($projectid)) echo $projectid ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="ProjectName">Project Name</label>
                                    <input name="ProjectName" class="form-control" value="<?php if(isset($projectname)) echo $projectname ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="LastName">Project Url</label>
                                    <input name="LastName" class="form-control" value="<?php if(isset($projecturl)) echo $projecturl ?>">

                                </div>
                            </div>
                            <div class="form-group">
                                <div>
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="ddlProjectCategories">Project Type</label>
                                            <select name="ddlProjectCategories" class="form-control">
                                                <?php
                                                if(isset($projectcategoryid))
                                                {
                                                    $pc = new Projectcategorytypes();
                                                    $pc->load($projectcategoryid);
                                                    echo "<option value='$projectcategoryid'>";
                                                    echo $pc->getProjectCategoryType();
                                                    echo '</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="0">---Project Type---</option>';
                                                }

                                                $ProjectCategoryTypeList = Projectcategorytypes::loadall();
                                                foreach($ProjectCategoryTypeList as $pct)
                                                {
                                                    if(isset($projectcategoryid) && $pct->getProjectCategoryTypeID() == $projectcategoryid)
                                                    {
                                                        //skip
                                                    }
                                                    else
                                                    {
                                                        $projectcategoryid = $pct->getProjectCategoryTypeID();
                                                        echo "<option value='$projectcategoryid'>";
                                                        echo $pct->getProjectCategoryType();
                                                        echo '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="ddlProjectLead">Project Lead</label>
                                            <select name="ddlProjectLead" class="form-control">
                                                <?php
                                                if(isset($projectleadaccountid))
                                                {
                                                    $a = new Accounts();
                                                    $a->load($projectleadaccountid);
                                                    echo "<option value='$projectleadaccountid'>";
                                                    echo $a->getFirstName()." ". $a->getLastName();
                                                    echo '</option>';
                                                }
                                                else
                                                {
                                                    echo '<option value="0">---Project Lead---</option>';
                                                }

                                                $ProjectLeadList = Accounts::loadall();
                                                foreach($ProjectLeadList as $leadAccount)
                                                {
                                                    if(isset($projectleadaccountid) && $leadAccount->getAccountID() == $projectleadaccountid)
                                                    {
                                                        //skip
                                                    }
                                                    else
                                                    {
                                                        $projectleadaccountid = $leadAccount->getAccountID();
                                                        echo "<option value='$projectleadaccountid'>";
                                                        echo $leadAccount->getFirstName(). " " .$leadAccount->getLastName();
                                                        echo '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ProjectDescription">Description</label>
                                <textarea name="ProjectDescription" class="form-control" rows="5"><?php if(isset($projectdescription)) echo $projectdescription ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <?php if(isset($ProjectSearchList)) { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-6">
                                                <button class="btn btn-primary btn-block" type="submit">Search Again</button>
                                            </div>
                                            <div class="col-6">
                                                <a class="btn btn-secondary btn-block" href="SearchProjects.php">Clear Search</a>
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
                <div class="card">
                    <div class="card-header">
                        Project Category Statistics
                    </div>
                    <div class="card-body">
                        <?php
                        $pcl = Projectcategorytypes::loadall();
                        $x = 0;
                        $y = 0;
                        $z = 0;
                        foreach($pcl as $pc){
                            $p = new Projects();
                            $p->load($pc->getProjectCategoryTypeID());
                            if($p->getProjectCategoryID() == 1) //asp.net/C#
                            {
                                $x = $x + 1;
                            }
                            if($p->getProjectCategoryID() == 2) //php/mysql
                            {
                                $y = $y + 1;
                            }
                            if($p->getProjectCategoryID() == 3) //html/css
                            {
                                $z = $z + 1;
                            }
                        }
                        ?>
                        <div id="donut-example"></div>
                        <script>
                            Morris.Donut({
                                element: 'donut-example',
                                data: [
                                    {label: "ASP.NET/C#", value: <?php echo $x; ?>},
                                    {label: "PHP/MySQL", value: <?php echo $y; ?>},
                                    {label: "HTML/CSS", value: <?php echo $z; ?>}
                                ]
                            });
                        </script>
                    </div>
                </div>
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
            $("#inputProjectID").addClass("is-invalid");
            // setTimeout(function () { $('#InputWarningLabel').addClass("hidden"); }, 1750);
        }
        else {
            $("#inputProjectID").removeClass("is-invalid");
            $("#inputProjectID").addClass("is-valid");
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
