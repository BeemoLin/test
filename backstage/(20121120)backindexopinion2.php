<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindexopinion2_view.php
  backindexopinionre2_view.php
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
/*
"
SELECT 
  `t1`.* , `t2`.`m_username`
FROM
  `opinion_tab1` AS `t1` INNER JOIN `memberdata` AS `t2`
   ON `t1`.`ot1_uid`=`t2`.`m_id`'
WHERE
  1=1 
ORDER BY 
  `ot2_datetime` DESC
"  
*/  
  $pages->setDb('`opinion_tab1` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot1_uid`=`t2`.`m_id`', " AND `ot1_disable` = '0' ORDER BY `ot1_datetime` DESC",'`t1`.* ,`t2`.`m_username`');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion2.php');
  $Listpage = $pages->getListpage(2,'backindexopinion2.php');
  $Endpage = $pages->getEndpage('backindexopinion2.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion2_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST['ot1_id'])){
    $ot1_id = $_POST['ot1_id'];
    
    $pages = new sam_pages_class;
    $pages->setDb('opinion_tab1',"AND ot1_id  = '".$ot1_id."'",'*');
    $data = $pages->getData();
    $title = $data[1]['ot1_title'];
    $title_datetime = $data[1]['ot1_datetime'];
    $type = $data[1]['type'];
    
    $pages->setDb('`opinion_tab2` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot2_uid`=`t2`.`m_id`', "AND `ot1_id` = '".$ot1_id."' ORDER BY `ot2_datetime` ASC",'`t1`.* ,`t2`.`m_username`');
    //$pages->setDb('opinion'," AND `ot1_id` = '".$_POST['ot1_id']."'","*");
    $row_Recordset = $pages->getData();
    include(VIEW.'/backindexopinionre2_view.php');
  }
}
elseif($action_mode=='insert'){ 
  if(isset($_POST['ot1_id'])){
    $ot1_id = $_POST['ot1_id'];
    $ot2_content = $_POST['content'];
    $ot2_uid = $_SESSION['MM_UserID'];
    $now = date('Y-m-d H:i:s', time());
    $data_function = new data_function;
    $data_function->setDb('opinion_tab2');
    $insert_expression = "
      `ot1_id` = '".$ot1_id."', 
      `ot2_uid` = '".$ot2_uid."', 
      `ot2_content` = '".$ot2_content."', 
      `ot2_datetime` = '".$now."'
    ";
    $data_function->insert($insert_expression);
    
    
    $data_function->setDb('opinion_tab1');
    $where = "AND `ot1_id` = '".$ot1_id ."'";
    $expression = " `ot1_type` = '1' ";
    $data_function->update($where,$expression); 
    
    
    
    $pages = new sam_pages_class;
    $pages->setDb('opinion_tab1',"AND ot1_id  = '".$ot1_id."'",'*');
    $data = $pages->getData();
    $title = $data[1]['ot1_title'];
    $title_datetime = $data[1]['ot1_datetime'];
    $type = $data[1]['type'];
    
    $pages->setDb('`opinion_tab2` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot2_uid`=`t2`.`m_id`', "AND `ot1_id` = '".$ot1_id."' ORDER BY `ot2_datetime` ASC",'`t1`.* ,`t2`.`m_username`');
    $row_Recordset = $pages->getData();
    include(VIEW.'/backindexopinionre2_view.php');
  }
}
elseif($action_mode=='update'){ //¨S¥Î¨ì
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
  if(isset($_POST['ot1_id'])){
    $ot1_id = $_POST['ot1_id'];
    $data_function = new data_function;
    $data_function->setDb('opinion_tab1');
    $where = "AND `ot1_id` = '".$ot1_id."' ";
    $expression = " `ot1_disable` = '1' ";
    $data_function->update($where,$expression); 
    //$data_function->delete_category($opinion_id);
  }
  $pages = new sam_pages_class; 
  $pages->setDb('`opinion_tab1` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot1_uid`=`t2`.`m_id`', " AND `ot1_disable` = '0' ORDER BY `ot1_datetime` DESC",'`t1`.* ,`t2`.`m_username`');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion2.php');
  $Listpage = $pages->getListpage(2,'backindexopinion2.php');
  $Endpage = $pages->getEndpage('backindexopinion2.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion2_view.php');
}
elseif($action_mode=='disable'){
  $data_function = new data_function;
  $data_function->setDb('opinion_tab1');
  $ot1_id = $_POST['ot1_id'];
  $where = "AND `ot1_id` = '".$ot1_id."'";
  $expression = " ot1_disable='1'";
  $data_function->update($where,$expression); 
  
  $pages = new sam_pages_class; 
  $pages->setDb('`opinion_tab1` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot1_uid`=`t2`.`m_id`', " AND `ot1_disable` = '0' ORDER BY `ot1_datetime` DESC",'`t1`.* ,`t2`.`m_username`');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion2.php');
  $Listpage = $pages->getListpage(2,'backindexopinion2.php');
  $Endpage = $pages->getEndpage('backindexopinion2.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion2_view.php');
    
}
else{
  $pages = new sam_pages_class; 
  $pages->setDb('`opinion_tab1` as `t1` INNER JOIN `memberdata` AS `t2` ON `t1`.`ot1_uid`=`t2`.`m_id`', " AND `ot1_disable` = '0' ORDER BY `ot1_datetime` DESC",'`t1`.* ,`t2`.`m_username`');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindexopinion2.php');
  $Listpage = $pages->getListpage(2,'backindexopinion2.php');
  $Endpage = $pages->getEndpage('backindexopinion2.php');
  $data = $pages->getData();
  include(VIEW.'/backindexopinion2_view.php');
}

include(BCLASS.'/foot.php');
?>