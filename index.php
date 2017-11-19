<?php
session_start();
include_once("Utilities/SessionManager.php");
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}

include "DAL/projects.php";
include "DAL/tasks.php";
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
include_once("DAL/accounts.php");
include "DAL/comments.php";

if($_SERVER["REQUEST_METHOD"] == "GET")
    if(isset($_GET['msg']))
        $alertmsg = $_GET['msg'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        header("location:index.php");
    }
}

$alertmsg = "This product is still under active development, but feel free to try the BETA version.";
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php include "navbar.php" ?>

  <div class="content-wrapper">
    <div class="container-fluid">
        <?php if(isset($alertmsg)) { ?>
            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4> <?php  echo $alertmsg; ?> </h4>
            </div>
        <?php } ?>
      <?php include "cardcounters.php" ?>
        <div class="row">
            <div class="col-lg-8">
                <!-- Card Columns Example Social Feed-->
                <style>
                    .card-img-top {
                        width: min-content;
                        height: auto;
                    }
                </style>
                <div class="mb-0 mt-4">
                    <i class="fa fa-newspaper-o"></i> News Feed
                </div>
                <hr class="mt-2">
                <div class="card-columns">


                    <?php
                    $commentsList = Comments::loadall();
                    if(!empty($commentsList)){
                        $counter = 0;
                        foreach($commentsList as $comment){
                            if($counter > 5){
                                break;  //limit number of comments
                            }
                            $account = new Accounts();
                            $account->load($comment->getAccountID());
                            $task = new Tasks();
                            $task->load($comment->getTaskID());
                            $project = new Projects();
                            $project->load($task->getProjectID());
                            ?>
                            <!-- Example Social Card-->
                            <div class="card mb-3">
                                <a href="ViewTask.php?taskid=<?php echo $task->getTaskID(); ?>">
                                    <img class="rounded mx-auto d-block card-img-top img-fluid" src="<?php echo $project->getImgURL(); ?>" alt="<?php echo $project->getProjectName(); ?>">
                                </a>
                                <div class="card-body">
                                    <h6 class="card-title mb-1"><a href="ViewAccount.php?accountid=<?php echo $account->getAccountID(); ?>"><?php echo $account->getFirstName()." ". $account->getLastName();  ?></a></h6>
                                    <p class="card-text small"><?php echo $comment->getDescription(); ?>
                                        <a href="ViewProject.php?projectid=<?php echo $project->getProjectId(); ?>">#<?php echo $project->getProjectName(); ?></a>
                                    </p>
                                </div>
                                <hr class="my-0">
                                <div class="card-body py-2 small">
                                    <form method="post" class="mr-3 d-inline-block"">
                                    <input type="hidden" name="hfcommentid" value="<?php echo $comment->getCommentID(); ?>">
                                    <input type="hidden" name="hfcommenttaskid" value="<?php echo $comment->getTaskID(); ?>">
                                    <input type="hidden" name="hfcommentaccountid" value="<?php echo $comment->getAccountID(); ?>">
                                    <input type="hidden" name="hfcommentprojectid" value="<?php echo $project->getProjectId(); ?>">
                                    <button type="submit" name="LikeComment" class="btn btn-link">
                                        <i class="fa fa-fw fa-thumbs-up"></i>Like</button>
                                    </form>
                                    <a class="mr-3 d-inline-block btn btn-link" href="ViewTask.php?taskid=<?php echo $task->getTaskID(); ?>">
                                        <i class="fa fa-fw fa-comment"></i>Comment</a>
                                    <a class="d-inline-block btn btn-link" href="ViewAccount.php?accountid=<?php echo $account->getAccountID(); ?>">
                                        <i class="fa fa-fw fa-share"></i>Message</a>
                                </div>
                                <hr class="my-0">
                                <!--<div class="card-body small bg-faded">
                                    <div class="media">
                                        <img class="d-flex mr-3" src="http://placehold.it/45x45" alt="">
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-1"><a href="#">Jessy Lucas</a></h6>Where did you get that camera?! I want one!
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="#">Like</a>
                                                </li>
                                                <li class="list-inline-item">·</li>
                                                <li class="list-inline-item">
                                                    <a href="#">Reply</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>-->
                                <div class="card-footer small text-muted">Posted <?php echo $comment->getCreateDate(); ?></div>
                            </div>
                            <?php
                            $counter = $counter + 1;
                        } //END foreach
                    }
                    ?>

                </div>
                <!-- /Card Columns-->

            </div>
            <div class="col-lg-4">
                <br>
                <br>
                <div id="statustypebarchart" style="height: 250px;"></div>
                <script>
                    Morris.Bar({
                        element: 'statustypebarchart',
                        data: [
                            { y: 'Open', a: <?php echo $numOfOpenTasks ?>},
                            { y: 'Ready For Testing', a:<?php echo $numOfReadyForTestingTasks ?>},
                            { y: 'Reopened', a: <?php echo $numOfReopenedTasks ?>},
                            { y: 'Closed', a: <?php echo $numOfClosedTasks ?> }
                        ],
                        xkey: 'y',
                        ykeys: ['a'],
                        labels: ['Series A'],
                        barColors: function (row, series, type) {
                            console.log("--> "+row.label, series, type);
                            if(row.label == "Open") return "#007bff";
                            else if(row.label == "Ready For Testing") return "#ffc107";
                            else if(row.label == "Reopened") return "#28a745";
                            else if(row.label == "Closed") return "#dc3545";
                        },
                        hoverCallback: function (index, options, content, row) {
                            return row.y + " Tasks";
                        }
                    });
                </script>
            </div>
        </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

<?php include "footer.php" ?>
<?php include "modal.php" ?>
<?php include "scripts.php" ?>

  </div>
</body>

</html>
