<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindex_QA_view.php
  backindex_QAadd_view.php
  backindex_QAshow_view.php
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
//var_dump($action_mode);
if($action_mode=='view_all_data'){
  $pages = new sam_pages_class;
  $pages->setDb('qa','ORDER BY qa_id DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_qa.php');
  $Listpage = $pages->getListpage(2,'backindex_qa.php');
  $Endpage = $pages->getEndpage('backindex_qa.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_QA_view.php');
}
elseif($action_mode=='add'){
  include(VIEW.'/backindex_QAadd_view.php');
}
elseif($action_mode=='add_qa'){
  if(isset($_POST['qa_type'])){
    $data_function = new data_function;
    $data_function->setDb('qa');
    $qa_type = $_POST['qa_type'];  
    $qa_content = $_POST['qa_content'];
    $qa_date = $_POST['qa_date'];
    $expression = ' qa_type="'.$qa_type.'", qa_content="'.$qa_content.'", qa_date="'.$qa_date .'"';
    $data_function->insert($expression);
  }
  $pages = new sam_pages_class;
  $pages->setDb('qa','ORDER BY qa_id DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_qa.php');
  $Listpage = $pages->getListpage(2,'backindex_qa.php');
  $Endpage = $pages->getEndpage('backindex_qa.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_QA_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST['qa_id'])){
    $pages = new sam_pages_class;
    $pages->setDb("qa"," AND qa_id = '".$_POST['qa_id']."'","*");
    $row_Recordset = $pages->getData();
    
     
    $pages->setDb("qa_qa2","AND qa_yesno='yes' AND qa_id = '".$_POST['qa_id']."' GROUP BY qa_id ","count(1) as total");
    $yes = $pages->getData();
    if(empty($yes['1']['total'])){
      $yes['1']['total'] = '0';
    }
     
    $pages->setDb("qa_qa2","AND qa_yesno='no' AND qa_id = '".$_POST['qa_id']."' GROUP BY qa_id ","count(1) as total");
    $no = $pages->getData();
    if(empty($no['1']['total'])){
      $no['1']['total'] = '0';
    }
     
    $pages->setDb("qa_qa2","AND qa_yesno='no_opinion' AND qa_id = '".$_POST['qa_id']."' GROUP BY qa_id ","count(1) as total");
    $no_opinion = $pages->getData();
    if(empty($no_opinion['1']['total'])){
      $no_opinion['1']['total'] = '0';
    }
     
    include(VIEW.'/backindex_QAshow_view.php');
  }
}
elseif($action_mode=='delete'){
  if(isset($_POST['qa_id'])){
    $data_function = new data_function;
    $data_function->setDb('qa');
    $qa_id = $_POST['qa_id'];
    $where = "AND qa_id='".$qa_id."'";
    $data_function->delete($where);
  }
  $pages = new sam_pages_class;
  $pages->setDb('qa','ORDER BY qa_id DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_qa.php');
  $Listpage = $pages->getListpage(2,'backindex_qa.php');
  $Endpage = $pages->getEndpage('backindex_qa.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_QA_view.php');
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('qa','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_qa.php');
  $Listpage = $pages->getListpage(2,'backindex_qa.php');
  $Endpage = $pages->getEndpage('backindex_qa.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_QA_view.php');
}

include(BCLASS.'/foot.php');
?>
