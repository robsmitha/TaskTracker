<?php
//Check Session
session_start();
include_once("Utilities/SessionManager.php");
include "DAL/tasks.php";
include "DAL/prioritytypes.php";
include "DAL/statustypes.php";
include "DAL/tasktypes.php";
include "DAL/projects.php";
include "DAL/accounts.php";
include "DAL/comments.php";
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}
$accountid = SessionManager::getAccountID();
//Check Query
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	if(isset($_GET['taskid']) && is_numeric($_GET['taskid']))	//validate query string
	{
		$taskid = $_GET['taskid'];
		//now check if notificationid was set and set notiifcation to seen if so
        //this means they clicked from the alerts drop down in the nav bar
		if(isset($_GET['notificationid']) && is_numeric($_GET['notificationid'])){
            $notification = new Notifications();
            $notification->load($_GET["notificationid"]);
            $notification->setSeen(1);
            $date = date('Y-m-d H:i:s');
            $notification->setSeenDate($date);
            $notification->save();
        }
	}
	else
	{
		header("location:index.php");
	}
	if(isset($_GET["cmd"]) && $_GET["cmd"] == "editcomment"){
	    if(isset($_GET["commentid"]) && is_numeric($_GET["commentid"])){
	        $editcomment = new Comments();
	        $editcomment->load($_GET["commentid"]);
	        $editcommentdesc = $editcomment->getDescription();
	        $editcommentid = $editcomment->getCommentID();
        }
    }
	//we good, load task for this task id
    $task = new Tasks();
    $task->load($taskid);

//now load by foreign keys to fill in form values from type ids

//Priority type
    $prioritytype = new Prioritytypes();
    $prioritytype->load($task->getPriorityTypeID());

//status type
    $statustype = new Statustypes();
    $statustype->load($task->getStatusTypeID());

//Task Types
    $tasktype = new Tasktypes();
    $tasktype->load($task->getTaskTypeID());

//Project
    $project = new Projects();
    $project->load($task->getProjectID());
    $projectid = $project->getProjectId();

//Account
    $reporter = new Accounts();
    $reporter->load($task->getReporterAccountID());	//reporter obj

    $assignee = new Accounts();
    $assignee->load($task->getAssigneeAccountID());	//assignee obj

}



if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["LikeComment"])) {
        $notification = new Notifications();
        $notification->setNotificationTypeID(1);    //Like
        $notification->setAccountID($_POST["hfcommentaccountid"]);
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d H:i:s');
        $notification->setCreateDate($date);
        $notification->setSeenDate(null);
        $notification->setSeen(0);
        $notification->setTaskID($_POST["hfcommenttaskid"]);
        $notification->setProjectID($_POST["hfprojectid"]);
        $notification->setCommentID($_POST["hfcommentid"]);
        $notification->save();
        $id = $notification->getTaskID();
        header("location:ViewTask.php?taskid=$id");
    }
    if(isset($_POST["PostComment"])){
        $returnVal = true;
        $_POST["commentArea"] == "" ? $returnVal = false : $commentArea = $_POST["commentArea"];
        if($returnVal){
            $comment = new Comments();
            //$comment->setCommentID(0);
            $comment->setDescription($commentArea);
            $comment->setAccountID($_POST["hfaccountid"]);
            $comment->setTaskID($_POST["hftaskid"]);
            $comment->setCommentStatusTypeID(1);    //open
            date_default_timezone_set('America/New_York');
            $date = date('Y-m-d H:i:s');
            $comment->setCreateDate($date);
            $comment->setEditDate(null);
            $comment->save();
            //now make notification for new comment
            $notification = new Notifications();
            $notification->setNotificationTypeID(2);    //comment
            $notification->setAccountID($_POST["hfaccountid"]);
            $notification->setCreateDate($date);
            $notification->setSeenDate(null);
            $notification->setSeen(0);
            $notification->setTaskID($_POST["hftaskid"]);
            $notification->setProjectID($_POST["hfprojectid"]);
            $notification->setCommentID($comment->getCommentID());
            $notification->save();

            $id = $comment->getTaskID();
            header("location:ViewTask.php?taskid=$id");
        }
        else {
            $validationMsg = "Please Enter a Comment!";
        }
    }
    if(isset($_POST["DeleteComment"])){
        $commentid = $_POST["hfcommentid"];
        $comment = new Comments();
        $comment->load($commentid);
        $comment->setCommentID($comment->getCommentID());
        $comment->setDescription($comment->getDescription());
        $comment->setAccountID($comment->getAccountID());
        $comment->setTaskID($comment->getTaskID());
        $comment->setCommentStatusTypeID(2);
        $comment->setCreateDate($comment->getCreateDate());
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d H:i:s');
        $comment->setEditDate($date);
        $comment->save();
        $id = $comment->getTaskID();
        header("location:ViewTask.php?taskid=$id");
    }
    if(isset($_POST["EditComment"])){
        $returnVal = true;
        $_POST["commentArea"] == "" ? $returnVal = false : $commentArea = $_POST["commentArea"];
        $_POST["hfcommentid"] == "" ? $returnVal = false : $commentid = $_POST["hfcommentid"];
        if($returnVal){
            $comment = new Comments();
            $comment->load($commentid);
            $comment->setCommentID($comment->getCommentID());
            $comment->setDescription($commentArea);
            $comment->setAccountID($comment->getAccountID());
            $comment->setTaskID($comment->getTaskID());
            $comment->setCommentStatusTypeID(3);
            $comment->setCreateDate($comment->getCreateDate());
            date_default_timezone_set('America/New_York');
            $date = date('Y-m-d H:i:s');
            $comment->setEditDate($date);
            $comment->save();
            $id = $comment->getTaskID();
            header("location:ViewTask.php?taskid=$id");
        }
    }
    if(!isset($_POST["PostComment"]) && !isset($_POST["LikeComment"]) && !isset($_POST["EditComment"]) && !isset($_POST["DeleteComment"])){   //this post back was to update status types
        if(isset($_POST['hfstatustypeid']))
        {
            $statustypeid = $_POST['hfstatustypeid'];
        }
        else
        {
            header("location:.index.php");
        }
        if(isset($_POST['hftaskid']))
        {
            $taskid = $_POST['hftaskid'];
        }
        else
        {
            header("location:.index.php");
        }
        $task = new Tasks();
        $task->load($taskid);	//load this task to change status type
        $task->setStatusTypeID($statustypeid);//record dates
        date_default_timezone_set('America/New_York');
        $date = date('Y-m-d H:i:s');
        if($statustypeid == 6) //closed
        {
            $task->setCloseDate($date);
        }
        if($statustypeid == 5)
        {
            $task->setReopenDate($date);
        }

        $task->save();

        $notification = new Notifications();
        $notification->setNotificationTypeID(3);    //Update
        $notification->setAccountID($_POST["hfaccountid"]);
        $notification->setCreateDate($date);
        $notification->setSeenDate(null);
        $notification->setSeen(0);
        $notification->setTaskID($_POST["hftaskid"]);
        $notification->setProjectID($_POST["hfprojectid"]);
        $notification->setCommentID(null);
        $notification->save();


        $id = $task->getTaskID();
        header("location:ViewTask.php?taskid=$id");
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
          <li class="breadcrumb-item">
              <a href="ViewProject.php?projectid=<?php echo $projectid ?>">
                  <?php echo $project->getProjectName(); ?>
              </a>
          </li>
        <li class="breadcrumb-item active"><?php echo $task->getTaskName(); ?></li>
      </ol>
        <?php if(isset($validationMsg)) { ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4> <?php  echo $validationMsg; ?> </h4>
            </div>
        <?php } ?>
      <div class="row">
	  
        <div class="col-lg-8">
			<div class="card">
				<div class="bg-light" style="padding: 12px;">
					<div class="row">
						<div class="col-sm-10">
							<h3><?php echo $task->getTaskName(); ?></h3>
						</div>
						<div class="col-sm-2">
                        <script>
                            function setStatustType(e) {
                                switch (e){
                                    case "STATUS_1":	//open
                                        $("#hfstatustypeid").val(1);
                                        break;
                                    case "STATUS_2":	//in progress
                                        $("#hfstatustypeid").val(2);
                                        break;
                                    case "STATUS_3":	//resolved
                                        $("#hfstatustypeid").val(3);
                                        break;
                                    case "STATUS_4":	//ready for testing
                                        $("#hfstatustypeid").val(4);
                                        break;
                                    case "STATUS_5":	//reopened
                                        $("#hfstatustypeid").val(5);
                                        break;
                                    case "STATUS_6":	//closed
                                        $("#hfstatustypeid").val(6);
                                        break;
                                    default:
                                    //do nothing
                                    break;
                                }
                                return true;
                            }
                        </script>
						<form method="post" class="btn-group pull-right">
                            <input id="hfstatustypeid" type="hidden" name="hfstatustypeid">
                            <input type="hidden" name="hftaskid" value="<?php echo $task->getTaskID(); ?>">
                            <input type="hidden" name="hfaccountid" value="<?php echo $task->getAssigneeAccountID() ?>">
                            <input type="hidden" name="hfprojectid" value="<?php echo $task->getProjectID(); ?>">
                            <a class="btn btn-secondary" href="CreateTask.php?cmd=edit&taskid=<?php echo $taskid ?>">Edit</a>
							<?php
                            if(true)    //$task->getAssigneeAccountID() == $_SESSION["AccountID"]
                            {
                                $statustypeid = $task->getStatusTypeID();
                                switch($statustypeid)
                                {
                                    case 1:	//open
                                        ?>
                                        <button type="submit" id="STATUS_2" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Start Progress</button>
                                        <button type="submit" id="STATUS_3" class='btn btn-secondary' onclick="return setStatustType(this.id)">Resolve</button>
                                        <?php
                                        $badgecssclass = "primary";
                                        break;
                                    case 2:	//in progress
                                        ?>
                                        <button type="submit" id="STATUS_1" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Stop Progress</button>
                                        <button type="submit" id="STATUS_3" class='btn btn-secondary' onclick="return setStatustType(this.id)">Resolve</button>
                                        <?php
                                        $badgecssclass = "light";
                                        break;
                                    case 3:	//resolved
                                        ?>
                                        <button type="submit" id="STATUS_5" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Reopen</button>
                                        <button type="submit" id="STATUS_4" class='btn btn-secondary' onclick="return setStatustType(this.id)">Ready For Testing</button>
                                        <?php
                                        $badgecssclass = "success";
                                        break;
                                    case 4:	//ready for testing
                                        ?>
                                        <button type="submit" id="STATUS_5" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Reopen</button>
                                        <button type="submit" id="STATUS_6" class='btn btn-secondary' onclick="return setStatustType(this.id)">Close</button>
                                        <?php
                                        $badgecssclass = "warning";
                                        break;
                                    case 5:	//reopened
                                        ?>
                                        <button type="submit" id="STATUS_4" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Ready For Testing</button>
                                        <button type="submit" id="STATUS_3" class='btn btn-secondary' onclick="return setStatustType(this.id)">Resolve</button>
                                        <?php
                                        $badgecssclass = "danger";
                                        break;
                                    case 6:	//closed
                                        ?>
                                        <button type="submit" id="STATUS_5" class='btn btn-secondary' onclick="return setStatustType(this.id)" name="">Reopen</button>
                                        <?php
                                        $badgecssclass = "dark";
                                        break;
                                    default:
                                        //do nothing
                                        break;
                                }
                            }
							?>
						</form>
						</div>
					</div>
					
				</div>
			    <div class="card-body">
					<h4>Details</h4>
					<div class="row">
						<div class="col-sm-6">
                            <b>Status: </b><a href="#" class="badge badge-<?php echo isset($badgecssclass) ? $badgecssclass : "light" ?>"><?php echo $statustype->getStatus(); ?></a>
						</div>
						<div class="col-sm-6">
							<b>Priority: </b><?php echo $prioritytype->getPriorityType(); ?>
						</div>
						<div class="col-sm-6">
							<b>Type: </b><?php echo $tasktype->getTaskType(); ?>
						</div>
						<div class="col-sm-6">
							<b>Project: </b>
                            <a href="ViewProject.php?projectid=<?php echo $project->getProjectId(); ?>" title="View <?php echo $project->getProjectName(); ?>">
                                <?php echo $project->getProjectName(); ?>
                            </a>
						</div>
					</div>
					<hr>
					<h4>Description</h4>
					<p><?php echo $task->getDescription(); ?></p>
			    </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="CommentForm" class="form-group" method="post" onsubmit="return doValidation();">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <textarea id="inputDescription" type="text" class="form-control" rows="4" name="commentArea" placeholder="Leave a comment"><?php if(isset($editcommentdesc)) echo $editcommentdesc; ?></textarea>
                                            <button type="submit" name="<?php if(isset($editcommentdesc)) echo "EditComment"; else echo "PostComment"; ?>" class="input-group-addon btn btn-primary"><i class="fa fa-comment"></i>Comment</button>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="hfcommentid" value="<?php if(isset($editcommentid)) echo $editcommentid; else echo 0; ?>">
                                <input type="hidden" name="hftaskid" value="<?php echo $task->getTaskID(); ?>">
                                <input type="hidden" name="hfaccountid" value="<?php echo $accountid ?>">
                                <input type="hidden" name="hfprojectid" value="<?php echo $task->getProjectID(); ?>">
                            </form>

                        </div>
                    </div>
                    <hr>
                    <!--comments-->
                    <div class="row">
                        <div class="comments col-md-12" id="comments">

                            <?php
                            $commentsList = Comments::loadbytaskid($task->getTaskID());
                            if(!empty($commentsList)){
                                foreach($commentsList as $comment){
                                $account = new Accounts();
                                $account->load($comment->getAccountID());
                                $imgurl = $account->getImgURL();
                                ?>
                                <!-- comment -->
                                <div class="comment mb-2 row">
                                    <div class="comment-avatar col-md-1 col-sm-2 text-center pr-1">
                                        <a href=""><img class="mx-auto rounded-circle img-fluid img-avatar" src="<?php echo $imgurl ?>" alt="avatar"></a>
                                    </div>
                                    <div class="comment-content col-md-11 col-sm-10">
                                        <form method="post" class="pull-right">
                                            <input type="hidden" name="hfcommentid" value="<?php echo $comment->getCommentID(); ?>">
                                            <input type="hidden" name="hfcommenttaskid" value="<?php echo $comment->getTaskID(); ?>">
                                            <input type="hidden" name="hfcommentaccountid" value="<?php echo $comment->getAccountID(); ?>">
                                            <input type="hidden" name="hfcommentprojectid" value="<?php echo $project->getProjectID(); ?>">
                                            <input type="submit" name="LikeComment" value="Like" class="btn btn-link small">
                                    <?php
                                    if($comment->getAccountID() == SessionManager::getAccountID()) {
                                        ?>
                                        <input type="submit" name="DeleteComment" value="Delete" class="btn btn-link small">
                                        <?php
                                    }
                                        ?>
                                        </form>
                                        <?php
                                            if($comment->getAccountID() == SessionManager::getAccountID())
                                            {
                                                ?>
                                                <a class="btn btn-link pull-right" href="ViewTask.php?taskid=<?php echo $comment->getTaskID() ?>&cmd=editcomment&commentid=<?php echo $comment->getCommentID() ?>">Edit</a>
                                                <?php
                                            }
                                        ?>
                                        <h6 class="small comment-meta">
                                            <a href="ViewAccount.php?accountid=<?php echo $account->getAccountID(); ?>"><?php echo $account->getFirstName(). " " .$account->getLastName(); ?></a>
                                            <?php echo $comment->getCreateDate(); ?>
                                        </h6>
                                        <div class="comment-body">
                                            <p>
                                                <?php echo $comment->getDescription(); ?>
                                                <br>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <!-- /comment -->
                                <hr>
                                <?php
                                }   //end foreach
                            }
                            ?>
                        </div>
                    </div>

                </div>
			</div>
        </div>
        <div class="col-lg-4">
            <div class="card bg-light">
                <div class="card-body">
                    <b><i class="fa fa-users"></i> People</b><br>
                    <b>Reported By: </b><?php echo $reporter->getFirstName(). " " .$reporter->getLastName(); ?><br>
                    <b>Assigned To: </b><?php echo $assignee->getFirstName(). " " .$assignee->getLastName();  ?><br>
                    <hr>
                    <b><i class="fa fa-calendar"></i> Dates</b><br>
                    <b>Create Date: </b><?php echo $task->getCreateDate(); ?><br>
                    <?php if($task->getReopenDate() != 0) echo "<b>Reopen Date: </b>".$task->getReopenDate()."<br>"; ?>
                    <?php if($task->getCloseDate() != 0) echo "<b>Close Date: </b>".$task->getCloseDate()."<br>"; ?>
                </div>
            </div>

        </div>
      </div>

    </div>
    <!-- /.container-fluid-->
</div>
<!-- /.content-wrapper-->
<?php include "footer.php"?>
<?php include "modal.php"?>
<?php include "scripts.php" ?>
<script>
    function doValidation() {
        var isValid = true;
        var commentDescription = $("#inputDescription").val();
        if(commentDescription.length > 0)
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
