<?php
$session_accountid = SessionManager::getAccountID();
$session_roleid = SessionManager::getRoleID();
    $TaskList = Tasks::loadbyaccountid($session_accountid);
    $numOfOpenTasks = 0;
    $numOfReadyForTestingTasks = 0;
    $numOfReopenedTasks = 0;
    $numOfClosedTasks = 0;
    foreach ($TaskList as $task){
        switch ($task->getStatusTypeID()){
            case 1:	//open
                $numOfOpenTasks = $numOfOpenTasks + 1;
                break;
            /*case 2:	//in progress

                break;
            case 3:	//resolved

                break;*/
            case 4:	//ready for testing
                $numOfReadyForTestingTasks = $numOfReadyForTestingTasks + 1;
                break;
            case 5:	//reopened
                $numOfReopenedTasks = $numOfReopenedTasks + 1;
                break;
            case 6:	//closed
                $numOfClosedTasks = $numOfClosedTasks + 1;
                break;
            default:
                //do nothing
                break;
        }
    }
?>

<!-- Icon Cards-->
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-primary o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-circle-o"></i>
              </div>
              <div class="mr-5"><?php echo $numOfOpenTasks ?> Open Tasks!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="SearchTasks.php?statustypeid=1&accountid=<?php echo $session_accountid ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-warning o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-check-circle-o"></i>
              </div>
              <div class="mr-5"><?php echo $numOfReadyForTestingTasks ?> Tasks Ready For Testing!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="SearchTasks.php?statustypeid=4&accountid=<?php echo $session_accountid ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-success o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-repeat"></i>
              </div>
              <div class="mr-5"><?php echo $numOfReopenedTasks ?> Reopened Tasks!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="SearchTasks.php?statustypeid=5&accountid=<?php echo $session_accountid ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-3">
          <div class="card text-white bg-danger o-hidden h-100">
            <div class="card-body">
              <div class="card-body-icon">
                <i class="fa fa-fw fa-times"></i>
              </div>
              <div class="mr-5"><?php echo $numOfClosedTasks ?> Closed Tasks!</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="SearchTasks.php?statustypeid=6&accountid=<?php echo $session_accountid ?>">
              <span class="float-left">View Details</span>
              <span class="float-right">
                <i class="fa fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>
      </div>
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
