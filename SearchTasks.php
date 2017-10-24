<?php
session_start();
if($_SESSION["LoggedIn"] == "")
    header("location:login.php?msg=notloggedin");

include "DAL/prioritytypes.php";
include "DAL/accounts.php";
include "DAL/statustypes.php";
include "DAL/tasks.php";
include "DAL/tasktypes.php";
include "DAL/projects.php";

if($_SERVER["REQUEST_METHOD"] == "POST")    //check for postback (submit)
{
    $searchbarvalue = isset($_POST["searchBox"]) ? $_POST["searchBox"] : "";
    if($searchbarvalue != "")   //user searched from search bar
    {
        //do search stuff
        if(is_numeric(($searchbarvalue)))
        {
           //set up search by taskid
            $TaskSearchList = Tasks::search($searchbarvalue,"","","","","","","","","","","");

        }
        else{
            //set search by taskname
            $TaskSearchList = Tasks::search("",$searchbarvalue,"","","","","","","","","","");
        }
    }
    else{
        //variables for search
        $taskname = isset($_POST['TaskName']) ? $_POST['TaskName'] : "";
        $description = isset($_POST['txtDescription']) ? $_POST['txtDescription'] : "";
        $taskid = isset($_POST['TaskID']) ? $_POST['TaskID'] : "";
        //Project
        if(isset($_POST['ddlProjects']))//check if field was set in postback (sumbit)
        {//only set variable to a value other than 0 since search() does not take a 0 well
            $taskprojectid = $_POST['ddlProjects'] == 0 ? "" : $_POST['ddlProjects'];
        }
        else{
            $taskprojectid = "";
        }
        //Status Type
        if(isset($_POST['ddlStatusTypeID']))
        {
            $taskstatustypeid = $_POST['ddlStatusTypeID'] == 0 ? "" : $_POST['ddlStatusTypeID'];
        }
        else {
            $taskstatustypeid = "";
        }
        //Task Type
        if(isset($_POST['ddlTaskType']))
        {
            $tasktypeid = $_POST['ddlTaskType'] == 0 ? "" : $_POST['ddlTaskType'];
        }
        else {
            $tasktypeid = "";
        }
        //Priority Type
        if(isset($_POST['ddlPriorityType']))
        {
            $taskpriorirtytypeid = $_POST['ddlPriorityType'] == 0 ? "" : $_POST['ddlPriorityType'];
        }
        else {
            $taskpriorirtytypeid = "";
        }
        //Assignee
        if(isset($_POST['ddlAssignee']))
        {
            $taskassigneeaccountid = $_POST['ddlAssignee'] == 0 ? "" : $_POST['ddlAssignee'];
        }
        else {
            $taskassigneeaccountid = "";
        }
        //Reported By:
        if(isset($_POST['ddlReportedBy']))
        {
            $taskreportedbyaccountid = $_POST['ddlReportedBy'] == 0 ? "" : $_POST['ddlReportedBy'];
        }
        else {
            $taskreportedbyaccountid = "";
        }
        $taskcreatedate = isset($_POST["CreateDate"]) ? $_POST["CreateDate"] : "";
        $taskclosedate = isset($_POST["CloseDate"]) ? $_POST["CloseDate"] : "";
        $taskreopendate = isset($_POST["ReopenDate"]) ? $_POST["ReopenDate"] : "";

        $TaskSearchList = Tasks::search($taskid,$taskname,$description,$taskassigneeaccountid,$taskreportedbyaccountid,$taskstatustypeid,$tasktypeid,$taskpriorirtytypeid,$taskprojectid,$taskcreatedate,$taskclosedate,$taskreopendate);

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
                <?php if(isset($TaskSearchList)) { ?>
                    Search Results
                <?php } else { ?>
                    Search Tasks
                <?php } ?>
            </li>
        </ol>
        <?php if(isset($TaskSearchList)) { ?>
            <table class="table table-striped">
                <thead class="">
                <tr>
                    <th scope="col">Task ID</th>
                    <th scope="col">Task</th>
                    <th scope="col">Assignee ID</th>
                    <th scope="col">Reporter ID</th>
                    <th scope="col">Project ID</th>
                    <th scope="col">Status ID</th>
                    <th scope="col">Priority ID</th>
                    <th scope="col">Task Type ID</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($TaskSearchList as $task)
                {?>
                    <tr id="TaskID_<?php echo $task->getTaskID() ?>">
                        <th scope="row">
                            <a href="ViewTask.php?taskid=<?php echo $task->getTaskID() ?>" class="btn btn-link"><?php echo $task->getTaskID() ?></a>
                        </th>
                        <td>
                            <a href="ViewTask.php?taskid=<?php echo $task->getTaskID() ?>" class="btn btn-link"><?php echo $task->getTaskName() ?></a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $task->getAssigneeAccountID() ?>" class="btn btn-link"><?php echo $task->getAssigneeAccountID() ?></a>
                        </td>
                        <td>
                            <a href="ViewAccount.php?accountid=<?php echo $task->getReporterAccountID() ?>" class="btn btn-link"><?php echo $task->getReporterAccountID() ?></a>
                        </td>
                        <td>
                            <a href="ViewProject.php?projectid=<?php echo $task->getProjectID() ?>" class="btn btn-link"><?php echo $task->getProjectID() ?></a>
                        </td>
                        <td>
                            <a class="btn btn-link"><?php echo $task->getStatusTypeID() ?></a>
                        </td>
                        <td>
                            <a class="btn btn-link"><?php echo $task->getPriorityTypeID() ?></a>
                        </td>
                        <td>
                            <a class="btn btn-link"><?php echo $task->getTaskTypeID() ?></a>
                        </td>
                    </tr>
                    <?php
                }   //end foreach
                ?>
                </tbody>
            </table>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-search"></i> Search Tasks
                    </div>
                    <div class="card-body">

                            <form id="searchForm" method="post" action="">
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="TaskName">Task name</label>
                                        <input class="form-control" name="TaskName" type="text" aria-describedby="nameHelp" placeholder="Enter task name" value="<?php if(isset($taskname)) echo $taskname ?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ddlTaskType">Task ID</label>
                                        <input id="inputTaskID" name="TaskID" class="form-control" onkeydown="return isNumeric(event.keyCode);" onkeyup="keyUP(event.keyCode)" value="<?php if(isset($taskid)) echo $taskid ?>">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div>
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label for="ddlProjects">Project</label>
                                                <select name="ddlProjects" class="form-control">
                                                    <?php
                                                    if(isset($taskprojectid))
                                                    {
                                                        $p = new Projects();
                                                        $p->load($taskprojectid);
                                                        echo "<option value='$taskprojectid'>";
                                                        echo $p->getProjectName();
                                                        echo '</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="0">---Project---</option>';
                                                    }

                                                    $ProjectList = Projects::loadall();
                                                    foreach($ProjectList as $project)
                                                    {
                                                        if(isset($taskprojectid) && $project->getProjectID() == $taskprojectid)
                                                        {
                                                            //skip
                                                        }
                                                        else
                                                        {
                                                            $projectid = $project->getProjectID();
                                                            echo "<option value='$projectid'>";
                                                            echo $project->getProjectName();
                                                            echo '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="ddlStatusTypeID">Status ID</label>
                                                <select name="ddlStatusTypeID" class="form-control">
                                                    <?php
                                                    if(isset($taskstatustypeid))
                                                    {
                                                        $st = new Statustypes();
                                                        $st->load($taskstatustypeid);
                                                        echo "<option value='$taskstatustypeid'>";
                                                        echo $st->getStatus();
                                                        echo '</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="0">---Status---</option>';
                                                    }

                                                    $StatusTypesList = Statustypes::loadall();
                                                    foreach($StatusTypesList as $statusType)
                                                    {
                                                        if(isset($taskstatustypeid) && $statusType->getStatusTypeID() == $taskstatustypeid)
                                                        {
                                                            //skip
                                                        }
                                                        else
                                                        {
                                                            $taskstatustypeid = $statusType->getStatusTypeID();
                                                            echo "<option value='$taskstatustypeid'>";
                                                            echo $statusType->getStatusTypeID();
                                                            echo '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <!--</div>
                                        <div class="row form-group">-->
                                            <div class="col-md-4 form-group">
                                                <label for="ddlTaskType">Task Type</label>
                                                <select name="ddlTaskType" class="form-control">
                                                    <?php
                                                    if(isset($tasktypeid))
                                                    {
                                                        $tt = new Tasktypes();
                                                        $tt->load($tasktypeid);
                                                        echo "<option value='$tasktypeid'>";
                                                        echo $tt->getTaskType();
                                                        echo "</option>";
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="0">---Type---</option>';
                                                    }
                                                    $TaskTypesList = Tasktypes::loadall();
                                                    foreach($TaskTypesList as $taskType)
                                                    {
                                                        if(isset($tasktypeid) && $taskType->getTaskTypeID() == $tasktypeid)
                                                        {
                                                            //skip
                                                        }
                                                        else
                                                        {
                                                            $tasktypeid = $taskType->getTaskTypeID();
                                                            echo "<option value='$tasktypeid'>";
                                                            echo $taskType->getTaskType();
                                                            echo "</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="ddlPriorityType">Priority</label>
                                                <select name="ddlPriorityType" class="form-control">
                                                    <?php
                                                    if(isset($taskpriorirtytypeid))
                                                    {
                                                        $pt = new Prioritytypes();
                                                        $pt->load($taskpriorirtytypeid);
                                                        echo "<option value='$taskpriorirtytypeid'>";
                                                        echo $pt->getPriorityType();
                                                        echo '</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="0">---Priority---</option>';
                                                    }

                                                    $PriorityTypesList = Prioritytypes::loadall();
                                                    foreach($PriorityTypesList as $priorityType)
                                                    {
                                                        if(isset($taskprioritytype) && $priorityType->getPriorityTypeID() == $taskprioritytype)
                                                        {
                                                            //skip
                                                        }
                                                        else
                                                        {
                                                            $prioritytypeid = $priorityType->getPriorityTypeID();
                                                            echo "<option value='$prioritytypeid'>";
                                                            echo $priorityType->getPriorityType();
                                                            echo '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        <!--</div>
                                        <div class="row form-group">-->
                                            <div class="col-md-4 form-group">
                                                <label for="ddlAssignee">Assign To</label>
                                                <select name="ddlAssignee" class="form-control">
                                                    <?php
                                                    if(isset($taskassigneeaccountid))
                                                    {
                                                        $a = new Accounts();
                                                        $a->load($taskassigneeaccountid);
                                                        echo "<option value='$taskassigneeaccountid'>";
                                                        echo $a->getFirstName()." ". $a->getLastName();
                                                        echo '</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="0">---Assignee---</option>';
                                                    }

                                                    $AssigneeAccountList = Accounts::loadall();
                                                    foreach($AssigneeAccountList as $assigneeAccount)
                                                    {
                                                        if(isset($taskassigneeaccountid) && $assigneeAccount->getAccountID() == $taskassigneeaccountid)
                                                        {
                                                            //skip
                                                        }
                                                        else
                                                        {
                                                            $accountid = $assigneeAccount->getAccountID();
                                                            echo "<option value='$accountid'>";
                                                            echo $assigneeAccount->getFirstName(). " " .$assigneeAccount->getLastName();
                                                            echo '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label for="ddlReportedBy">Reported By</label>
                                                <select name="ddlReportedBy" class="form-control">
                                                    <?php
                                                    if(isset($taskreportedbyaccountid))
                                                    {
                                                        $a = new Accounts();
                                                        $a->load($taskreportedbyaccountid);
                                                        echo "<option value='$taskreportedbyaccountid'>";
                                                        echo $a->getFirstName()." ". $a->getLastName();
                                                        echo '</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="0">---Reporter---</option>';
                                                    }

                                                    $ReporterAccountList = Accounts::loadall();
                                                    foreach($ReporterAccountList as $reporterAccount)
                                                    {
                                                        if(isset($taskreportedbyaccountid) && $reporterAccount->getAccountID() == $taskreportedbyaccountid)
                                                        {
                                                            //skip
                                                        }
                                                        else
                                                        {
                                                            $raccountid = $reporterAccount->getAccountID();
                                                            echo "<option value='$raccountid'>";
                                                            echo $reporterAccount->getFirstName(). " " .$reporterAccount->getLastName();
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
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="CreateDate">Created</label>
                                            <input type="date" id="inpnutCreateDate" name="CreateDate" class="form-control" value="<?php echo $taskcreatedate ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="CloseDate">Closed</label>
                                            <input type="date" id="inpnutCloseDate" name="CloseDate" class="form-control" value="<?php echo $taskclosedate ?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="ReopenDate">Reopened</label>
                                            <input type="date" id="inpnutReopenDate" name="ReopenDate" class="form-control" value="<?php echo $taskreopendate ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="txtDescription">Description</label>
                                    <textarea name="txtDescription" class="form-control" rows="5"><?php if(isset($description)) echo $description ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <?php if(isset($TaskSearchList)) { ?>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button class="btn btn-primary btn-block" type="submit">Seach Again</button>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a class="btn btn-secondary btn-block" href="SearchTasks.php">Clear Search</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <button class="btn btn-primary btn-block" type="submit">Search</button>
                                                </div>
                                                <div class="col-sm-6">
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
            $("#inputTaskID").addClass("is-invalid");
           // setTimeout(function () { $('#InputWarningLabel').addClass("hidden"); }, 1750);
        }
        else {
            $("#inputTaskID").removeClass("is-invalid");
            $("#inputTaskID").addClass("is-valid");
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
