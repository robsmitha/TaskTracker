

<div class="card mb-3">
    <div class="card-header">
        <i class="fa fa-tasks"></i> Roles</div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 my-auto">
                <?php
                $RoleList = Roles::loadall();
                foreach($RoleList as $role)
                {
                    $roleid = $role->getRoleID();
                    $rolename = $role->getRole();
                    echo "<a href='ViewRole.php?roleid=$roleid' class='lead'>$rolename</a><br>";
                }
                ?>
            </div>
        </div>
    </div>
</div>