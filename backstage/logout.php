<?php
	session_start();
	session_unset();
  session_destroy();
	$_SESSION['enter_web']="";
    header("Location: index.php");
?>