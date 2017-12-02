<?php
session_start();

include_once("Utilities/Authentication.php");

$errorMessage = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $emailaddress = $_POST["emailaddress"];
    $password = $_POST["password"];

    $success = Authentication::authLogin($emailaddress,$password);
    if ($success)
    {
        header("location: index.php");
    }
    else
    {
        $validationMsg = "Incorrect username or password. Try again.";
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
                <form id="formLogin" method="post" onsubmit="return doValidation()">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input class="form-control" id="emailaddress" name="emailaddress" type="email" aria-describedby="emailHelp" placeholder="Enter email" autocomplete="off">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input class="form-control" id="password" name="password" type="password" placeholder="Password" autocomplete="off">
                  </div>
                  <div class="form-group">
                        <div class="form-check">
                          <label class="form-check-label">
                            <input class="form-check-input" type="checkbox"> Remember Password</label>
                        </div>
                  </div>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary btn-block" type="submit">Login</button>
                        </div>
                        <div class="col-6">
                            <a class="btn btn-secondary btn-block" href="register.php">Register</a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-12">
                            <a href="forgot-password.php" class="btn btn-link btn-block">Forgot Password?</a>
                        </div>
                    </div>
                </form>
          </div>
    </div>
</div>
  <?php include "scripts.php" ?>
  <script>
      function doValidation() {
          var isValid = true;
          var email = $("#inputEmail").val();
          var description = $("#inputPassword").val();

          if(email.length > 0)
          {
              $("#inputEmail").addClass("is-valid");
              $("#inputEmail").removeClass("is-invalid");
          }
          else
          {
              $("#inputEmail").addClass("is-invalid");
              $("#inputEmail").removeClass("is-valid");
              isValid = false;
          }
          if(description.length > 0)
          {
              $("#inputPassword").addClass("is-valid");
              $("#inputPassword").removeClass("is-invalid");
          }
          else
          {
              $("#inputPassword").addClass("is-invalid");
              $("#inputPassword").removeClass("is-valid");
              isValid = false;
          }
          return isValid;
      }
  </script>
</body>

</html>
