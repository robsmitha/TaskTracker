<?php
/*
 * requires
include "DAL/tasks.php" in parent page
 *
 */
if(isset($paramAssigneeaccountid))
{
    $TasksList = Tasks::loadbyaccountid($paramAssigneeaccountid);
}
else if(isset($paramProjectid ))
{
    $TasksList = Tasks::loadbyprojectid($paramProjectid);
}
else
{
    $TasksList = Tasks::loadall();
}
?>
<!-- Tasks Feed-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-tasks"></i> Tasks</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 my-auto">
                <?php

                foreach($TasksList as $task)
                {
                    $taskid = $task->getTaskID();
                    $taskname = $task->getTaskName();
                    echo "<a href='ViewTask.php?taskid=$taskid' class='lead'>$taskname</a><br>";
                    $lastupdated = $task->getCreateDate();
                }
                ?>
            </div>
        </div>
    </div>
    <div class="card-footer small text-muted">Last updated on <?php echo $lastupdated ?></div>
</div>
