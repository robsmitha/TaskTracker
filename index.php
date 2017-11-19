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

if($_SERVER["REQUEST_METHOD"] == "GET")
    if(isset($_GET['msg']))
        $alertmsg = $_GET['msg'];


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


            </div>
            <div class="col-lg-4">
                <?php //include "projects.php" ?>
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
