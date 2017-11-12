<?php
/*
	includes footer, scroll-to-top button and logout modal
*/
?>
	<footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
		<b></b>

          <small>Hi, <?php echo SessionManager::getFirstName(); ?> &middot; <span class="text-muted">Copyright © TaskTracker <?php echo date("Y"); ?></span></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-primary" id="logout" onclick="logout(this.id)">Logout</button>
          </div>
        </div>
      </div>
    </div>
<script>
    function logout(e) {
        if(e == "logout"){
            var kill = "SessionManager::ResetSession();";
            window.location = "login.php"
        }
    }

</script>
