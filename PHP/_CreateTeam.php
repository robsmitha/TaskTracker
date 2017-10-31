<?php
include "../DAL/teams.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $returnValue = true;
    if($_POST['dataTeamName'] == "")
    {
        $returnValue = false;
    }
    else
    {
        $rolename = $_POST['dataTeamName'];
    }
    if($_POST['txtDescription'] == "")
    {
        $returnValue = false;
    }
    else
    {
        $description = $_POST['txtDescription'];
    }
    if($returnValue)
    {
        if(isset($_POST["editteamid"]) && $_POST["editteamid"] > 0)
        {
            $tid = $_POST["editteamid"];
            if(is_numeric($tid))
            {
                $team = new Teams();
                $team->load($tid);
                $team->setName($teamname);
                $role->setDescription($description);
                $role->save();
                header("location:../ViewTeam.php?teamid=$tid");
            }
        }
        else
        {
            $role = new Roles();
            $role->load(0);
            $role->setName($teamname);
            $role->setDescription($description);
            $role->save();
            header("location:../index.php?msg=Created Team: $teamname!");
        }
    }
    else
    {
        header("location:../CreateTeam.php?msg=validate");
    }
}




?>