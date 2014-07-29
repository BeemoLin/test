<?php
session_start();
//$_SESSION['from_web'] = 'login.php';
require_once('../define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/common.php');

if(isset($_POST['security_code'])){
	if(($_SESSION['security_code'] != $_POST['security_code'])||(empty($_SESSION['security_code']))){
    foreach ($_SESSION as $key => $v){
      echo '$_SESSION['.$key.']='.$v."<br>\n";
    }
    foreach ($_POST as $key => $v){
      echo '$_POST['.$key.']='.$v."<br>\n";
    }
    header("Location: logout.php");
		break;
	}
}

if (isset($_POST['username'])) {
  $loginUsername = $_POST['username'];
  $password = $_POST['passwd'];
  mysql_select_db($database_connSQL, $connSQL);
  	
  //$LoginRS__query=sprintf("SELECT m_username, m_passwd, m_level FROM memberdata WHERE m_username=%s AND m_passwd=%s", GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
  $LoginRS__query = "SELECT m_id,m_username, m_passwd, m_level FROM memberdata WHERE m_username='".$loginUsername."' AND m_passwd='".$password."'";
  $LoginRS = mysql_query($LoginRS__query, $connSQL) or die(mysql_error());
  $row = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
//die($loginFoundUser);
  if ($loginFoundUser) {
  //die($row['m_level']);
    if($row['m_level']=='權限管理者' || $row['m_level'] =='使用發布者'){
      //$loginStrGroup  = mysql_result($LoginRS,0,'m_level');
      $_SESSION['MM_Username'] = $loginUsername;
      $_SESSION['MM_UserGroup'] = $row['m_level'];	      
      $_SESSION['MM_UserID'] = $row['m_id'];
      $_SESSION['enter_web'] = CONSTRUCTION_CASE;
      $_SESSION['from_web'] = "login.php";
      header("Location: backindex.php");
    }
    else{
      session_unset();
      header("Location: logout.php");
    }
    exit;
  }
  else {
    session_unset();
    header("Location: index.php");
    exit;
  }
}

?>
