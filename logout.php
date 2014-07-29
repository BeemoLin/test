<?php
	session_start();
	session_unset();
	$_SESSION['enter_web']="";
	$_SESSION['from_web']="";
    header("Location: index.php");
?>