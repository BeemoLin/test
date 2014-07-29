<?php
if (!isset($_SESSION)) {
	session_start();
}
//define('INPUT_DEBUG_MODE', true);
define('INPUT_DEBUG_MODE', false);
//xdebug_enable();
//xdebug_disable();
//define('CONSTRUCTION_CASE', 'cc77'); /*    移到 define.php，如果登入有問題再打開 20120905

if(empty($_SESSION['enter_web'])){
  if(isset($_SESSION['from_web'])){
    if ($_SESSION['from_web']=='index.php'){
      //$from_web=$_SESSION['from_web'];
      //SQL query $from_web in to the logging data;
    }
    elseif($_SESSION['from_web']=='index_new.php'){
      //$from_web=$_SESSION['from_web'];
      //SQL query $from_web in to the logging data;
    }
    else{
      header("Location: logout.php");
      exit();
    }
  }
  else{
    header("Location: logout.php");
    exit();
  }
}
else{
  if($_SESSION['enter_web']!= CONSTRUCTION_CASE){
    header("Location: logout.php");
    exit();
  }
  else{
    //$from_web=$_SESSION['from_web'];
    //SQL query $from_web in to the logging data;
  }
}
/*    移到 define.php，如果資料庫連線有問題再打開 20120905
$hostname_connSQL = "localhost";
$database_connSQL = "cc77";
$username_connSQL = "cc77";
$password_connSQL = "cc77";
$connSQL = mysql_pconnect($hostname_connSQL, $username_connSQL, $password_connSQL) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES UTF8");
mysql_select_db($database_connSQL, $connSQL);
*/
?>