<?php
/*
if(isset($paramAssigneeaccountid))
{
    $ProjectList = Projects::loadbyaccountid($paramAssigneeaccountid);
}
else if(isset($paramProjectid ))
{
    $ProjectList = Projects::loadbyprojectid($paramProjectid);
}
else
{

}
*/
$ProjectList = Projects::loadall();
?>
<!-- Open Tasks Feed-->
<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-bar-chart"></i> Projects</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 my-auto">
                <?php

                foreach($ProjectList as $project)
                {
                    $projectid = $project->getProjectId();
                    $projectname = $project->getProjectName();
                    echo "<a href='ViewProject.php?projectid=$projectid' class='lead'>$projectname</a><br>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>
