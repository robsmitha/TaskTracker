<?php
include "../DAL/roles.php";

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $returnValue = true;
    if($_POST['dataRoleName'] == "")
    {
        $returnValue = false;
    }
    else
    {
        $rolename = $_POST['dataRoleName'];
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
        if(isset($_POST["editroleid"]) && $_POST["editroleid"] > 0)
        {
            $rid = $_POST["editroleid"];
            if(is_numeric($rid))
            {
                $role = new Roles();
                $role->load($rid);
                $role->setRole($rolename);
                $role->setDescription($description);
                $role->save();
                header("location:../ViewRole.php?roleid=$rid");
            }
        }
        else
        {
            $role = new Roles();
            $role->load(0);
            $role->setRole($rolename);
            $role->setDescription($description);
            $role->save();
            header("location:../index.php?msg=Created Role: $rolename!");
        }
    }
    else
    {
        header("location:../CreateRole.php?msg=validate");
    }
}




?>