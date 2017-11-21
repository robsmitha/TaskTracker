<?php

$session_accountid = SessionManager::getAccountID();
$session_roleid = SessionManager::getRoleID();

?>
<!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="index.php">
		<i class="fa fa-cloud"></i> TaskTracker
		<!--<img src="tasktrackerlogo.png" style="height: 50px; margin-top: -10px;">-->
	</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
              <i class="icon-graph m-auto"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Update Account Information">
              <a class="nav-link" href="ViewAccount.php?accountid=<?php echo $session_accountid ?>">
                  <i class="icon-user m-auto"></i>
                  <span class="nav-link-text">My Account</span>
              </a>
          </li>
          <?php
          if($session_roleid != 0) {

              ?>

<!--              <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create">
                  <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseExamplePages" data-parent="#exampleAccordion">
                      <i class="fa fa-fw fa-file"></i>
                      <span class="nav-link-text">Create</span>
                  </a>
                  <ul class="sidenav-second-level collapse" id="collapseExamplePages">
-->
              <?php

              $PermissionsList = Rolestopermissions::loadbyroleid($session_roleid);
              foreach($PermissionsList as $permission)
              {

                  if($permission->getPermissionID() == 12){     //Can Create/Edit Tasks
                ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Task">
                          <a class="nav-link" href="CreateTask.php">
                              <i class="icon-plus m-auto"></i>
                              <span class="nav-link-text">Create Task</span>
                          </a>
                      </li>
              <?php
                  }
                  if($permission->getPermissionID() == 8){      //Can Create/Edit Projects
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Project">
                          <a class="nav-link" href="CreateProject.php">
                              <i class="icon-briefcase m-auto"></i>
                              <span class="nav-link-text">Create Project</span>
                          </a>
                      </li>
              <?php
                  }
                  if($permission->getPermissionID() == 9){      //Can Create/Edit Roles
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Role">
                          <a class="nav-link" href="CreateRole.php">
                              <i class="icon-organization m-auto"></i>
                              <span class="nav-link-text">Create Role</span>
                          </a>
                      </li>
              <?php
                  }



                  if($permission->getPermissionID() == 14){  //Can Create/Edit Teams
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Team">
                          <a class="nav-link" href="CreateTeam.php">
                              <i class="icon-people m-auto"></i>
                              <span class="nav-link-text">Create Team</span>
                          </a>
                      </li>
                      <?php
                  }

                  if($permission->getPermissionID() == 1){  //Can Create/Edit Accounts
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Account">
                          <a class="nav-link" href="CreateAccount.php">
                              <i class="icon-user-follow m-auto"></i>
                              <span class="nav-link-text">Create Account</span>
                          </a>
                      </li>
                      <?php
                  }
                  if($permission->getPermissionID() == 19){  //Can Search Projects
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Project">
                          <a class="nav-link" href="SearchProjects.php">
                              <i class="icon-folder m-auto"></i>
                              <span class="nav-link-text">Search Projects</span>
                          </a>
                      </li>
                      <?php
                  }
                  if($permission->getPermissionID() == 17){  //Can Search tasks
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Search Tasks">
                          <a class="nav-link" href="SearchTasks.php">
                              <i class="icon-magnifier m-auto"></i>
                              <span class="nav-link-text">Search Tasks</span>
                          </a>
                      </li>
                      <?php
                  }
                  if($permission->getPermissionID() == 16){  //Can Search Accounts
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Search Accounts">
                          <a class="nav-link" href="SearchAccounts.php">
                              <i class="icon-user-following m-auto"></i>
                              <span class="nav-link-text">Search Accounts</span>
                          </a>
                      </li>
                      <?php
                  }
              }//end foreach


              ?>
<!--            </ul>
              </li>
-->
          <?php
          }//end if
          ?>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <?php
            $MessagesList = Messages::loadbyrecipientaccountid($session_accountid);
            $messageCount = 0;
            if(!empty($MessagesList)) {
                foreach ($MessagesList as $message) {
                    $messageCount = $messageCount + 1;
                }
            }
            ?>
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary"><?php echo $messageCount; ?> New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i><?php echo $messageCount; ?>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
              <?php
              if(!empty($MessagesList)){
                  foreach($MessagesList as $message) {
                        $senderaccount = new Accounts();
                        $senderaccount->load($message->getSenderAccountID());
                      ?>
                      <a class="dropdown-item" href="ViewAccount.php?accountid=<?php echo $message->getSenderAccountID(); ?>&messageid=<?php echo $message->getMessageID(); ?>">
                          <strong><?php echo $senderaccount->getFirstName(). " " .$senderaccount->getLastName(); ?></strong>
                          <span class="small float-right text-muted"><?php echo $message->getSentDate(); ?></span>
                          <div class="dropdown-message small"><?php echo $message->getDescription(); ?>
                          </div>
                      </a>
                      <?php
                  }
              }
              ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
          <?php
          $NotificationsList = Notifications::loadbyaccountid($session_accountid);
          $notificationCount = 0;
          if(!empty($NotificationsList)){
              foreach($NotificationsList as $notification){

                  $notificationCount = $notificationCount + 1;
              }
          }
          ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning"><?php echo $notificationCount; ?> New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i><?php echo $notificationCount; ?>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
              <?php
              $NotificationsList = Notifications::loadbyaccountid($session_accountid);
              $notificationCount = 0;
              if(!empty($NotificationsList)) {
              foreach($NotificationsList as $notification){
                  ?>
                  <div class="dropdown-divider"></div>
                      <a id="<?php echo $notification->getNotificationID() ?>" class="dropdown-item" href="ViewTask.php?taskid=<?php echo $notification->getTaskID() ?>&notificationid=<?php echo $notification->getNotificationID()?>">
                          <?php
                          $notificationtype = new Notificationtypes();
                          $notificationtype->load($notification->getNotificationTypeID());
                          switch ($notification->getNotificationTypeID()){
                              case 1: //likes
                                    $cssclass = "text-primary";
                                  break;
                              case 2:   //comments
                                  $cssclass = "text-warning";
                                  break;
                              case 3:   //status update
                                  $cssclass = "text-success";
                                  break;
                              default:
                                  break;
                          }
                          ?>
                          <span class="<?php echo $cssclass; ?>">
                            <strong>
                              <i class="fa fa-long-arrow-up fa-fw"></i><?php echo $notificationtype->getNotification(); ?></strong>
                          </span>
                          <span class="small float-right text-muted"><?php echo $notification->getCreateDate(); ?></span>
                          <div class="dropdown-message small"><?php echo $notificationtype->getDescription(); ?></div>
                      </a>
                  <form class="notification-form" id="FORM_<?php echo $notification->getNotificationID() ?>">
                    <input type="hidden" name="hfnotificationid" value="<?php echo $notification->getNotificationID() ?>">
                  </form>
              <?php
                } //end foreach
              }
              ?>


            <a class="dropdown-item small" href="#">View all alerts</a>
          </div>
        </li>
        <li class="nav-item">
          <form id="NavSearchBar" class="form-inline my-2 my-lg-0 mr-lg-2" method="post" action="SearchTasks.php">
            <div class="input-group">
                <div class="input-group-btn">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <span id="lblSearchTable">Tasks</span>
                    </button>
                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item" id="aTasks" onclick='setFormAction(this);'>Tasks</a>
                        <a href="#" class="dropdown-item" id="aAccounts" onclick='setFormAction(this);'>Accounts</a>
                        <a href="#" class="dropdown-item" id="aProjects" onclick='setFormAction(this);'>Project</a>
                    </div>
                </div>
              <input class="form-control" name="searchBox" type="text" placeholder="Search for...">
              <span class="input-group-btn">
                <button class="btn btn-primary" type="submit">
                  <i class="fa fa-search"></i>
                </button>
              </span>
            </div>
          </form>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
<script>

    function setFormAction(el){
        switch($(el).attr("id"))
        {
            case "aTasks":
                clearAll();
                $("#NavSearchBar").attr("action", "SearchTasks.php");
                $("#lblSearchTable").text("Tasks");
                $("#aTasks").addClass('active');

                break;
            case "aAccounts":
                clearAll();
                $("#NavSearchBar").attr("action", "SearchAccounts.php");
                $("#lblSearchTable").text("Accounts");
                $("#aAccounts").addClass('active');
                break;
            case "aProjects":
                clearAll();
                $("#NavSearchBar").attr("action", "SearchProjects.php");
                $("#lblSearchTable").text("Projects");
                $("#aProjects").addClass('active');
                break;
        }
    }
    function clearAll()
    {
        $("#NavSearchBar").attr("action", "");
        $("#lblSearchTable").text("");
        $("#aTasks").removeClass('active');
        $("#aAccounts").removeClass('active');
        $("#aProjects").removeClass('active');
    }
</script>