<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
舊模式用兩個資料夾放圖片，下次改版會改成只用一個資料夾
$img_dir = 'upfildes';
$img_dir2 = 'newpic';

view_page:
  backindexbasic_view.php
mode_page:
  page_class.php
*/
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$order_name = 'order';    
$photo_name = 'order_photo'; 
$img_dir = 'upfildes';
$img_dir2 = 'newpic';
if(isset($_POST['action_mode'])){
  $action_mode = $_POST['action_mode'];
}else{
  $action_mode = null;
}
if(isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 1;
}

include(BCLASS.'/head.php');
if(INPUT_DEBUG_MODE){
  include(BCLASS.'/debug.php');
}

if (isset($_FILES)){
  $files=$_FILES;
}

if($_SESSION['MM_UserGroup'] == '權限管理者'){
  if($action_mode=='view_all_data'){ //
    $pages = new sam_pages_class;
    $pages->setDb('adminuser','','*');
    $data = $pages->getData();
    include(VIEW.'/backindexbasic_view.php');
  }
  elseif($action_mode=='add'){ //ok 但是延伸性低
    $mail1=$_POST['mail1'];
    $mail2=$_POST['mail2'];
    $expression="";
    $data_function = new data_function;
    $data_function->setDb('adminuser');
    $where = " AND id = '1' ";
    $expression = " mail='$mail1'";
    $data_function->update($where,$expression);
    $where = " AND id = '2' ";
    $expression = " mail='$mail2'";
    $data_function->update($where,$expression);
    $pages = new sam_pages_class;
    $pages->setDb('adminuser','','*');
    $data = $pages->getData();
    include(VIEW.'/backindexbasic_view.php');
  }else{ //ok
    $pages = new sam_pages_class;
    $pages->setDb('adminuser','','*');
    $data = $pages->getData();
    include(VIEW.'/backindexbasic_view.php');
  }
}
include(BCLASS.'/foot.php');
?>