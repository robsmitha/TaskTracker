

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-users"></i> Teams</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 my-auto">
                <?php
                $TeamList = Teams::loadall();
                foreach($TeamList as $team)
                {
                    $teamid = $team->getTeamID();
                    $teamname = $team->getName();
                    echo "<a href='ViewTeam.php?teamid=$teamid' class='lead'>$teamname</a><br>";
                }
                ?>
            </div>
        </div>
    </div>
</div>