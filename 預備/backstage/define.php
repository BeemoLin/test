<?php
include($_SERVER['DOCUMENT_ROOT'].'/ccq1/define.php');

if($_SESSION['from_web'] != 'index.php' && $_SESSION['from_web'] != 'login.php'){
  if($_SESSION['MM_UserGroup']!='權限管理者' && $_SESSION['MM_UserGroup']!='使用發布者'){
    header("Location: index.php");
    exit();
  }
}

?>