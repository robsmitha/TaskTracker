<?php
#region validate session & query
session_start();
if($_SESSION["LoggedIn"] == "")
{
    header("location:login.php?msg=notloggedin");
}
include "DAL/roles.php";
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    if(isset($_GET['msg']))
        $alertmsg = $_GET['msg'];
    //existing roles being edited
    if(isset($_GET['cmd']) && isset($_GET['roleid']))
    {
        if($_GET['cmd'] == "edit" && is_numeric($_GET['roleid']))
        {
            $editrole = new Roles();
            $editrole->load($_GET['roleid']);
            $editroleid = $editrole->getRoleID();
            $editrolename = $editrole->getRole();
            $editdescription = $editrole->getDescription();
        }
    }
}
#endregion
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
                <?php if(isset($editroleid)) { ?>
                    Edit <?php echo $editrolename ?> Role
                <?php } else { ?>
                    Create Role
                <?php } ?>
            </li>
        </ol>

        <div class="row">

            <div class="col-lg-8">
                <?php if(isset($alertmsg)) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4> <?php  echo $alertmsg; ?> </h4>
                    </div>
                <?php } ?>
                <div class="card">
                    <div class="card-header">
                        <?php if(isset($editroleid)) { ?>
                            <div class="row">
                                <div class="col-sm-9">
                                    Edit <?php echo $editrolename ?> Role
                                </div>
                                <div class="col-sm-3">

                                </div>
                            </div>

                        <?php } else { ?>
                            Create Role
                        <?php } ?>

                    </div>
                    <div class="card-body">

                        <form id="formCreateRole" method="post" action="PHP/_CreateRole.php" onsubmit="return doValidation()">
                            <div class="form-group">
                                <label for="dataRoleName">Role name</label>
                                <input id="inputRoleName" class="form-control" name="dataRoleName" type="text" aria-describedby="nameHelp" placeholder="Enter role name" value="<?php if(isset($editrolename)) echo $editrolename ?>">
                            </div>
                            <div class="form-group">
                                <label for="txtDescription">Description</label>
                                <textarea id="inputDescription" name="txtDescription" class="form-control" rows="5"><?php if(isset($editdescription)) echo $editdescription ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-sm-2"></div>
                                <?php if(isset($editroleid)) { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary btn-block" type="submit">Save Changes</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <a class="btn btn-secondary btn-block" href="ViewRole.php?roleid=<?php echo $editroleid ?>">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <button class="btn btn-primary btn-block" type="submit" onsubmit="">Create Role</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <a class="btn btn-secondary btn-block" href="index.php">Cancel</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <input type="hidden" name="editroleid" value="<?php if(isset($editroleid)) echo $editroleid ?>">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <?php include "roles.php" ?>
             </div>
        </div>

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
</div>
    <?php include "footer.php"?>
    <?php include "modal.php"?>
    <?php include "scripts.php" ?>

<script>
    function doValidation() {
        var isValid = true;
        var projectName = $("#inputRoleName").val();
        var description = $("#inputDescription").val();

        if(projectName.length > 0)
        {
            $("#inputRoleName").addClass("is-valid");
            $("#inputRoleName").removeClass("is-invalid");
        }
        else
        {
            $("#inputRoleName").addClass("is-invalid");
            $("#inputRoleName").removeClass("is-valid");
            isValid = false;
        }
        if(description.length > 0)
        {
            $("#inputDescription").addClass("is-valid");
            $("#inputDescription").removeClass("is-invalid");
        }
        else
        {
            $("#inputDescription").addClass("is-invalid");
            $("#inputDescription").removeClass("is-valid");
            isValid = false;
        }

        return isValid;
    }
</script>
</body>

</html>
