<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindex_info_view.php
  backindex_reinfo_view.php
  backindex_addinfo_view.php
mode_page:
  page_class.php
*/
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$img_dir = 'rule';
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


if($action_mode=='view_all_data'){
  $pages = new sam_pages_class;
  $pages->setDb('info','ORDER BY info_id DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_info.php');
  $Listpage = $pages->getListpage(2,'backindex_info.php');
  $Endpage = $pages->getEndpage('backindex_info.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_info_view.php');
}
elseif($action_mode=='add'){
  include(VIEW.'/backindex_addinfo_view.php');
}
elseif($action_mode=='add_info'){
  if(isset($_POST['info_name'])){
    $data_function = new data_function;
    $data_function->setDb('info');
    $info_name = $_POST['info_name'];  
    $info_url = $_POST['info_url'];
    $expression = ' info_name="'.$info_name.'", info_url="'.$info_url.'"';
    $data_function->insert($expression);
  }
  $pages = new sam_pages_class;
  $pages->setDb('info','ORDER BY info_id DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_info.php');
  $Listpage = $pages->getListpage(2,'backindex_info.php');
  $Endpage = $pages->getEndpage('backindex_info.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_info_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST['info_id'])){
    $pages = new sam_pages_class;
    $pages->setDb("info"," AND info_id = '".$_POST['info_id']."'","*");
    $row_RecInfo = $pages->getData();
    include(VIEW.'/backindex_reinfo_view.php');
  }
}
elseif($action_mode=='update'){
  if(isset($_POST['info_id'])){
    $data_function = new data_function;
    $data_function->setDb('info');
    $info_id = $_POST['info_id'];  
    $info_name = $_POST['info_name'];  
    $info_url = $_POST['info_url'];
    $where = " AND info_id='".$info_id."'";
    $expression = ' info_name="'.$info_name.'", info_url="'.$info_url.'"';
    $data_function->update($where,$expression);
    $pages = new sam_pages_class;
    $pages->setDb('info',$where,"*");
    $row_RecInfo = $pages->getData();
    include(VIEW.'/backindex_reinfo_view.php');
  }
}
elseif($action_mode=='delete'){
  if(isset($_POST['info_id'])){
    $data_function = new data_function;
    $data_function->setDb('info');
    $info_id = $_POST['info_id'];
    $where = "AND info_id='".$info_id."'";
    $data_function->delete($where);
  }
  $pages = new sam_pages_class;
  $pages->setDb('info','ORDER BY info_id DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_info.php');
  $Listpage = $pages->getListpage(2,'backindex_info.php');
  $Endpage = $pages->getEndpage('backindex_info.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_info_view.php');
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('info','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_info.php');
  $Listpage = $pages->getListpage(2,'backindex_info.php');
  $Endpage = $pages->getEndpage('backindex_info.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_info_view.php');
}

include(BCLASS.'/foot.php');
?>