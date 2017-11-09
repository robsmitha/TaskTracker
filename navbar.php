<?php

$session_accountid = SessionManager::getAccountID();
$session_roleid = SessionManager::getRoleID();
include "DAL/rolestopermissions.php";


?>
<!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a href="index.php">
		<!--<i class="fa fa-cloud"></i> TaskTracker-->
		<img src="tasktrackerlogo.png" style="height: 65px; margin-top: -10px;">
	</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="index.php">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Update Account Information">
              <a class="nav-link" href="ViewAccount.php?accountid=<?php echo $session_accountid ?>">
                  <i class="fa fa-fw fa-user-circle"></i>
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
                              <i class="fa fa-fw fa-plus-square-o"></i>
                              <span class="nav-link-text">Create Task</span>
                          </a>
                      </li>
              <?php
                  }
                  if($permission->getPermissionID() == 8){      //Can Create/Edit Projects
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Project">
                          <a class="nav-link" href="CreateProject.php">
                              <i class="fa fa-fw fa-pencil-square-o"></i>
                              <span class="nav-link-text">Create Project</span>
                          </a>
                      </li>
              <?php
                  }
                  if($permission->getPermissionID() == 9){      //Can Create/Edit Roles
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Role">
                          <a class="nav-link" href="CreateRole.php">
                              <i class="fa fa-fw fa-lock"></i>
                              <span class="nav-link-text">Create Role</span>
                          </a>
                      </li>
              <?php
                  }



                  if($permission->getPermissionID() == 14){  //Can Create/Edit Teams
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Team">
                          <a class="nav-link" href="CreateTeam.php">
                              <i class="fa fa-fw fa-users"></i>
                              <span class="nav-link-text">Create Team</span>
                          </a>
                      </li>
                      <?php
                  }

                  if($permission->getPermissionID() == 1){  //Can Create/Edit Accounts
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Create Account">
                          <a class="nav-link" href="CreateAccount.php">
                              <i class="fa fa-fw fa-user-plus"></i>
                              <span class="nav-link-text">Create Account</span>
                          </a>
                      </li>
                      <?php
                  }
                  if($permission->getPermissionID() == 17){  //Can Search tasks
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Search Tasks">
                          <a class="nav-link" href="SearchTasks.php">
                              <i class="fa fa-fw fa-search"></i>
                              <span class="nav-link-text">Search Tasks</span>
                          </a>
                      </li>
                      <?php
                  }
                  if($permission->getPermissionID() == 16){  //Can Search Accounts
                      ?>
                      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Search Accounts">
                          <a class="nav-link" href="SearchAccounts.php">
                              <i class="fa fa-fw fa-search"></i>
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
          <a class="nav-link dropdown-toggle mr-lg-2" id="messagesDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-envelope"></i>
            <span class="d-lg-none">Messages
              <span class="badge badge-pill badge-primary">12 New</span>
            </span>
            <span class="indicator text-primary d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="messagesDropdown">
            <h6 class="dropdown-header">New Messages:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>David Miller</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">Hey there! This new version of SB Admin is pretty awesome! These messages clip off when they reach the end of the box so they don't overflow over to the sides!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>Jane Smith</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I was wondering if you could meet for an appointment at 3:00 instead of 4:00. Thanks!</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <strong>John Doe</strong>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">I've sent the final files over to you for review. When you're able to sign off of them let me know and we can discuss distribution.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="#">View all messages</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Alerts
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
              <i class="fa fa-fw fa-circle"></i>
            </span>
          </a>
          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            <h6 class="dropdown-header">New Alerts:</h6>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            <div class="dropdown-divider"></div>
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
        }
    }
    function clearAll()
    {
        $("#NavSearchBar").attr("action", "");
        $("#lblSearchTable").text("");
        $("#aTasks").removeClass('active');
        $("#aAccounts").removeClass('active');
    }
</script>