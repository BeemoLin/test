<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

/*
if (!function_exists("GetSQLValueString")) {
	require_once('includes/common.php');
}

if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
*/
 $ip = $_SERVER["REMOTE_ADDR"];

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  //$MM_fldUserAuthorization = "m_level";
  //$MM_redirectLoginSuccess = "index2.php";
  //$MM_redirectLoginFailed = "index.php";
  //$MM_redirecttoReferrer = false;
  mysql_select_db($database_connSQL, $connSQL);
  	
  //$LoginRS__query=sprintf("SELECT m_username, m_passwd, m_level, m_id FROM memberdata WHERE m_username=%s AND m_passwd=%s",GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
  
  $LoginRS__query="
  SELECT 
    m_username, 
    m_passwd, 
    m_level, 
    m_id 
  FROM 
    memberdata 
  WHERE 
    m_username='".$loginUsername."'
  AND 
    m_passwd='".$password."'
  ";
  
  $LoginRS = mysql_query($LoginRS__query, $connSQL) or die(mysql_error());
  $loginFoundUser = mysql_fetch_assoc($LoginRS);

  if (isset($loginFoundUser['m_username'])) {
    $loginStrGroup  = mysql_result($LoginRS,0,'m_level');
    $loginUserID  = mysql_result($LoginRS,0,'m_id');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginFoundUser['m_username'];//$loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      
    $_SESSION['MM_UserID'] = $loginUserID;
    /*
    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    */
    $_SESSION['enter_web'] = CONSTRUCTION_CASE;
    $_SESSION['from_web'] = "";
    $now = date('Y-m-d H:i:s');
    
    // 計數器+1
    $webcont__query ='
    INSERT INTO 
      `webcount` 
    SET
      `count_ip` = \''.$ip.'\', 
      `count_time` = \''.$now.'\'
    ';
    $CountRS = mysql_query($webcont__query, $connSQL) or die(mysql_error());    
	   $_SESSION['from_web'] = "index2.php";
    header("Location: index2.php");
    exit();
  }
  else {
  	$_SESSION['enter_web']="";
  	$_SESSION['from_web'] = "";
    header("Location: logout.php");
    exit();
  }
}

/* 目前未完全改版 以下目前不會用到
if (isset($_GET['p_ip'])) {
	$qaz=$_GET['p_ip'];
	$sql="SELECT *,count(*) as inname FROM memberdata WHERE p_ip='$qaz' GROUP BY m_username";
	$sql="SELECT *,count(*) as inname FROM memberdata WHERE p_ip='$qaz' GROUP BY m_passwd";
	$result = mysql_query($sql);
	while($row=mysql_fetch_array($result)){
		$username = $row["m_username"];
		$passwd = $row["m_passwd"];
		}
  $loginUsername=$username;
  $password=$passwd;
  $MM_fldUserAuthorization = "m_level";
  $MM_redirectLoginSuccess = "index2.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_connSQL, $connSQL);
  	
  $LoginRS__query=sprintf("SELECT m_username, m_passwd, m_level FROM memberdata WHERE m_username=%s AND m_passwd=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connSQL) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'m_level');
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	$_SESSION['enter_web'] = CONSTRUCTION_CASE;
	$_SESSION['from_web'] = "";
	//exit;
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	$_SESSION['enter_web']="";
	$_SESSION['from_web'] = "";
    header("Location: ". $MM_redirectLoginFailed );
  }
}
*/
?>
