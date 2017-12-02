<?php
session_start();
include_once("Utilities/SessionManager.php");
if(SessionManager::getAccountID() == 0)
{
    header("location: login.php");
}
include "DAL/accounts.php";
include  "DAL/projects.php";
include  "DAL/projectcategorytypes.php";
include "DAL/notifications.php";
include "DAL/notificationtypes.php";
include "DAL/rolestopermissions.php";
include "DAL/messages.php";
include "DAL/permissions.php";
include "DAL/roles.php";

$PList = Permissions::loadall();
$RList = Roles::loadall();  //for dropdown

if($_SERVER["REQUEST_METHOD"] == "POST")    //check for postback (submit)
{
    if(isset($_POST["btnSubmit"])){
        $roleid = $_POST["ddlRoles"];
        $role = new Roles();
        $role->load($roleid);
        $RPL = Rolestopermissions::loadbyroleid($roleid);
    }

    if(isset($_POST["btnSave"])){
        $roleid = $_POST["hfRoleID"];
        $role = new Roles();
        $role->load($roleid);

        $permissionsToAdd = array();
        foreach ($PList as $P){
            if(isset($_POST['add'.$P->getPermissionID()]))   //there is a form input set for this permissionid
            {
                $add = $_POST['add'.$P->getPermissionID()];
                $permissionsToAdd[] = $add;     //these vals are the Permission ID's of checked rows in the grid (the ones the user wants to add)
            }
        }
        $RPL = Rolestopermissions::loadbyroleid($roleid);

        $currentPermissions = array();  //hold current permissionIDs of this role
        foreach ($RPL as $r){   //loop through Permissions this role already has
            $currentPermissions[] = $r->getPermissionID();  //fill array with IDs that role already has!s
        }

        if(isset($permissionsToAdd) && isset($currentPermissions)){
            $permissionsToAdd = array_diff($permissionsToAdd,$currentPermissions);  //get difference in PermissionID()
        }

        if(isset($permissionsToAdd)){
            foreach ($permissionsToAdd as $p){
                $rtp = new Rolestopermissions();
                $rtp->setRoleID($roleid);
                $rtp->setPermissionID($p);
                $rtp->save();
            }
        }
        header("location: Administration.php?roleid=$roleid"); //redirect for fresh changes
    }
}
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["roleid"]) && is_numeric($_GET["roleid"])
        && $_GET["roleid"] > 0){
        $roleid = $_GET["roleid"];
        $role = new Roles();
        $role->load($roleid);
        $RPL = Rolestopermissions::loadbyroleid($roleid); //reload list of RoleToPermissions
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

<?php include "navbar.php" ?>

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">
                Administration
            </li>
        </ol>

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-sm-4">
                        <form method="post">
                            <div class="input-group">
                                <select class="form-control" name="ddlRoles">
                                    <?php
                                    if(isset($roleid)){
                                        ?>
                                        <option value="<?php echo $roleid ?>">
                                            <?php echo $role->getRole() ?>
                                        </option>
                                        <?php
                                    }
                                    else{
                                        ?>
                                        <option value="0">--Select Role--</option>
                                        <?php
                                    }
                                    foreach ($RList as $r){
                                        if(isset($roleid) && $r->getRoleID() == $roleid){
                                            //skip
                                        }
                                        else{
                                            ?>
                                            <option value="<?php echo $r->getRoleID() ?>">
                                                <?php echo $r->getRole() ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <div class="input-group-btn">
                                    <button type="submit" name="btnSubmit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php if(isset($PList)) { ?>
                    <script>
                        $( document ).ready(function() {
                            if ($(window).width() < 769) {
                                $("#gridRoles").addClass("table-responsive");
                            }
                        });
                    </script>
                    <form method="post">
                        <button type="submit" name="btnSave" class="btn btn-success pull-right">Save</button>
                        <input type="hidden" name="hfRoleID" value="<?php if(isset($roleid)){ echo $roleid;} else echo "0" ?>">
                        <table id="gridRoles" class="table table-striped">
                            <thead class="">
                            <tr>
                                <th scope="col">Permission ID</th>
                                <th scope="col">Role Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Has Permission</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($PList as $permission)
                            {?>
                                <tr id="PermissionID<?php echo $permission->getPermissionID() ?>">
                                    <th scope="row">
                                        <?php echo $permission->getPermissionID() ?>
                                    </th>
                                    <td>
                                        <?php echo $permission->getPermissionName() ?>
                                    </td>
                                    <td>
                                        <?php echo $permission->getDescription() ?>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="add<?php echo $permission->getPermissionID() ?>" value="<?php echo $permission->getPermissionID() ?>"
                                <?php
                                if(isset($RPL)){
                                    foreach ($RPL as $p){
                                        if($permission->getPermissionID() == $p->getPermissionID()) {
                                            echo "checked";
                                        }
                                    }
                                }
                                    ?>>
                                    </td>
                                </tr>
                                <?php
                            }   //end foreach
                            ?>
                            </tbody>
                        </table>
                    </form>
                <?php } ?>
            </div>
            <div class="col-lg-4">
                <?php
                $rtpl = Rolestopermissions::loadall();
                $v = 0;
                $w = 0;
                $x = 0;
                $y = 0;
                $z = 0;
                foreach($rtpl as $r){

                    if($r->getRoleID() == 1)
                    {
                        $v = $v + 1;
                    }
                    if($r->getRoleID() == 2)
                    {
                        $w = $w + 1;
                    }
                    if($r->getRoleID() == 3)
                    {
                        $x = $x + 1;
                    }
                    if($r->getRoleID() == 4)
                    {
                        $y = $y + 1;
                    }
                    if($r->getRoleID() == 5)
                    {
                        $z = $z + 1;
                    }
                }
                ?>
                <div id="donut-example"></div>
                <script>
                    Morris.Donut({
                        element: 'donut-example',
                        data: [
                            {label: "Administrator", value: <?php echo $v; ?>},
                            {label: "Developer", value: <?php echo $w; ?>},
                            {label: "Project Manager", value: <?php echo $x; ?>},
                            {label: "Quality Assurance", value: <?php echo $y; ?>},
                            {label: "Client Role", value: <?php echo $z; ?>},
                        ]
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
