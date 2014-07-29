<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
if (isset($_POST['username']) && isset($_POST['password'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $pages = new data_function;
  $pages->setDb('memberdata');
  $where_expression="AND `m_username`='".$loginUsername."' AND `m_passwd`='".$password."'";
  //die($pages->sql);
  $userdate=$pages->select($where_expression);
  
  if(isset($userdate)){
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $userdate['1']['m_level'];
    $_SESSION['enter_web'] = CONSTRUCTION_CASE;
    $_SESSION['from_web'] = "login_new.php";
    header("Location: home.php");
    exit();
  }
  else {
    $_SESSION['enter_web']="";
    $_SESSION['from_web'] = "";
    header("Location: logout.php");
    exit();
  }
}
?>