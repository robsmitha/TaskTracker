<?php
if($_SERVER["REQUEST_METHOD"] == "GET")
{
	if(isset($_GET['msg']))	
	{
		if($_GET['msg'] == "validate")
		{
			$validationMsg = "Please review your entries!";
		}
		else if($_GET['msg'] == "noresults")
		{
			$validationMsg = "Account not found!";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include "head.php" ?>

<body class="bg-dark">
  <div class="container">
  <?php if(isset($validationMsg)) { ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	  </button>
	  <h4> <?php  echo $validationMsg; ?> </h4>
	</div>
  <?php } ?>
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form id="formLogin" method="post" action="PHP/_Authenticate.php">
          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input class="form-control" name="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email" required>
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input class="form-control" name="exampleInputPassword1" type="password" placeholder="Password" required>
          </div>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox"> Remember Password</label>
            </div>
          </div>
            <div class="row">
                <div class="col-sm-6">
                    <button class="btn btn-primary btn-block" type="submit">Login</button>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-secondary btn-block" href="CreateAccount.php">Register</a>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
  <?php include "scripts.php" ?>
</body>

</html>
