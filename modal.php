<!-- Modal -->
<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div>
  
		<?php if(isset($validationMsg)) { ?>
			<div class="alert alert-danger alert-dismissible fade show mx-auto mt-5" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			  <h4> <?php  echo $validationMsg; ?> </h4>
			</div>
		<?php } ?>
			<div class="card mx-auto mt-5">
			  <div class="card-header">Create Task</div>
			  <div class="card-body">
			  
				<form id="formRegister" method="post" action="php/ManageTask.php">
				  <div class="form-group">
					<div class="form-row">
					  <div class="col-md-6">
						<label for="exampleInputName">First name</label>
						<input class="form-control" name="exampleInputName" type="text" aria-describedby="nameHelp" placeholder="Enter first name">
					  </div>
					  <div class="col-md-6">
						<label for="exampleInputLastName">Last name</label>
						<input class="form-control" name="exampleInputLastName" type="text" aria-describedby="nameHelp" placeholder="Enter last name">
					  </div>
					</div>
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input class="form-control" name="exampleInputEmail1" type="email" aria-describedby="emailHelp" placeholder="Enter email">
				  </div>
				  <div class="form-group">
					<div class="form-row">
					  <div class="col-md-6">
						<label for="exampleInputPassword1">Password</label>
						<input class="form-control" name="exampleInputPassword1" type="password" placeholder="Password">
					  </div>
					  <div class="col-md-6">
						<label for="exampleConfirmPassword">Confirm password</label>
						<input class="form-control" name="exampleConfirmPassword" type="password" placeholder="Confirm password">
					  </div>
					</div>
				  </div>
				  <button class="btn btn-primary btn-block" type="submit">Register</button>
				</form>
				<div class="text-center">
				  <a class="d-block small mt-3" href="login.php">Login Page</a>
				  <!--<a class="d-block small" href="forgot-password.html">Forgot Password?</a> -->
				</div>
			  </div>
			</div>
		  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>