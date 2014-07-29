<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindexopinion_view.php
  backindexopinionre_view.php
mode_page:
  page_class.php
*/
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
//opinion
//ORDER BY opinion_date DESC
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
  $pages->setDb('opinion','AND disable=\'0\' ORDER BY opinion_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion.php');
  $Listpage = $pages->getListpage(2,'backindexopinion.php');
  $Endpage = $pages->getEndpage('backindexopinion.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST['opinion_id'])){
    $pages = new sam_pages_class;
    $pages->setDb('opinion'," AND `opinion_id` = '".$_POST['opinion_id']."'","*");
    $row_Recordset = $pages->getData();
    include(VIEW.'/backindexopinionre_view.php');
  }
}
elseif($action_mode=='update'){
  if(isset($_POST['opinion_id'])){
    $opinion_name = $_POST['opinion_name'];
    $opinion_id = $_POST['opinion_id'];
    $opinion_type = $_POST['opinion_type'];
    $opinion_date = $_POST['opinion_date'];
    $opinion_content = $_POST['opinion_content'];
    $opinion_response = $_POST['opinion_response'];
    $opinion_time = $_POST['opinion_time'];
    $data_function = new data_function;
    $data_function->setDb('opinion');
    $where = "AND `opinion_id` = '".$opinion_id."'";
    $expression = " opinion_name='".$opinion_name."', opinion_type='".$opinion_type."', opinion_date='".$opinion_date."', opinion_content='".$opinion_content."', opinion_response='".$opinion_response."', opinion_time='".$opinion_time."'";
    $data_function->update($where,$expression); 
    
    $pages = new sam_pages_class;
    $pages->setDb('opinion','AND disable=\'0\' ORDER BY opinion_date DESC','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexopinion.php');
    $Listpage = $pages->getListpage(2,'backindexopinion.php');
    $Endpage = $pages->getEndpage('backindexopinion.php');
    $data = $pages->getData();
    include(VIEW.'/backindexopinion_view.php');
  }
}
elseif($action_mode=='delete'){
  if(isset($_POST['opinion_id'])){
    $data_function = new data_function;
    $data_function->setDb('opinion');
    $opinion_id = $_POST['opinion_id'];
    $where = "AND opinion_id='".$opinion_id."'";
    $data_function->delete($where);
    //$data_function->delete_category($opinion_id);
  }
  $pages = new sam_pages_class;
  $pages->setDb('opinion','AND disable=\'0\' ORDER BY opinion_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion.php');
  $Listpage = $pages->getListpage(2,'backindexopinion.php');
  $Endpage = $pages->getEndpage('backindexopinion.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion_view.php');
}
elseif($action_mode=='disable'){
  $data_function = new data_function;
  $data_function->setDb('opinion');
  $opinion_id = $_POST['opinion_id'];
  $where = "AND `opinion_id` = '".$opinion_id."'";
  $expression = " disable='1'";
  $data_function->update($where,$expression); 
  $pages = new sam_pages_class;
  $pages->setDb('opinion','AND disable=\'0\' ORDER BY opinion_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion.php');
  $Listpage = $pages->getListpage(2,'backindexopinion.php');
  $Endpage = $pages->getEndpage('backindexopinion.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion_view.php');
    
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('opinion','AND disable=\'0\' ORDER BY opinion_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion.php');
  $Listpage = $pages->getListpage(2,'backindexopinion.php');
  $Endpage = $pages->getEndpage('backindexopinion.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion_view.php');
}

include(BCLASS.'/foot.php');
?>