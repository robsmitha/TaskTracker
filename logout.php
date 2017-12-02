<?php
session_start();
include "Utilities/SessionManager.php";
SessionManager::ResetSession();
session_unset();
header("location:login.php");
?>