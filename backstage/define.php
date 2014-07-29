<?php
require_once('../define.php');

// 測試用：印出session 變數
// echo $_SESSION['from_web']."</br>".$_SESSION['MM_UserGroup'];

// 只認從login.php 登入的session
if($_SESSION['from_web'] != 'login.php'){
  if($_SESSION['MM_UserGroup'] != '權限管理者' || $_SESSION['MM_UserGroup'] != '使用發布者'){
    header("Location: index.php");
    exit();
  }
}

?>
