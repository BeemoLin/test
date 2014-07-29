<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once 'define.php';
require_once(CONNSQL);
require_once(PAGECLASS);

//require_once(CONNECTIONS.'/connSQL.php');
//require_once(BCLASS.'/page_class.php');
/*
 view_page:
 backindex_rule_view.php
 backindex_ruleadd_view.php
 backindex_rulere_view.php
 mode_page:
 page_class.php
 */

$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$img_dir = 'rule';

if(isset($_POST['action_mode'])){
  $action_mode = $_POST['action_mode'];
}
else{
  $action_mode = null;
}
if(isset($_POST['page'])){
  $page = $_POST['page'];
}
else{
  $page = 1;
}
include BCLASS.'/head.php';
if(INPUT_DEBUG_MODE){
  include(BCLASS.'/debug.php');
}

if (isset($_FILES)){
  $files=$_FILES;
}


if($action_mode=='view_all_data'){
  $pages = new sam_pages_class;
  $pages->setDb('rule','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_rule.php');
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage(2);
  $Endpage = $pages->getEndpage();
  $data = $pages->getData();
  include(VIEW.'/backindex_rule_view.php');
}
elseif($action_mode=='add'){
  include(VIEW.'/backindex_ruleadd_view.php');
}
elseif($action_mode=='add_rule'){
  if(!empty($_POST['r_title'])){
    $data_function = new data_function;
    $data_function->setDb('rule');
    $r_title = $_POST['r_title'];
    $r_date = $_POST['r_date'];
    $name = $files['r_pic']['name'];
    $tmp_name = $files['r_pic']['tmp_name'];
    $img_name = $data_function->add_image($img_dir,$name,$tmp_name);
    $expression = ' r_title="'.$r_title.'", r_date="'.$r_date.'", r_pic="'.$img_name.'"';
    $data_function->insert($expression);
  }

  $pages = new sam_pages_class;
  $pages->setDb('rule','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_rule.php');
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage(2);
  $Endpage = $pages->getEndpage();
  $data = $pages->getData();
  include(VIEW.'/backindex_rule_view.php');
}
elseif($action_mode=='view_select_data'){
  if(!empty($_POST['r_id'])){
    $pages = new sam_pages_class;
    $pages->setDb("rule"," AND r_id = '".$_POST['r_id']."'","*");
    $row_Recordset = $pages->getData();
    include(VIEW.'/backindex_rulere_view.php');
  }
}
elseif($action_mode=='update'){
  if(!empty($_POST['r_id'])){
    $data_function = new data_function;
    $data_function->setDb('rule');
    $r_id = $_POST['r_id'];
    $r_title = $_POST['r_title'];
    $r_date = $_POST['r_date'];
    $oldPic = $_POST['oldPic'];

    $name = $files['r_pic']['name'];
    $tmp_name = $files['r_pic']['tmp_name'];
    $img_name = $data_function->add_image($img_dir,$name,$tmp_name);

    $where = " AND r_id='".$r_id."'";
    $data_function->delete_image2($where,$img_dir,$oldPic);
    $expression = ' r_title="'.$r_title.'", r_date="'.$r_date.'", r_pic="'.$img_name.'"';
    //$data_function->insert($expression);
    $data_function->update($where,$expression);
  }
  $pages = new sam_pages_class;
  $pages->setDb('rule','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_rule.php');
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage(2);
  $Endpage = $pages->getEndpage();
  $data = $pages->getData();
  include(VIEW.'/backindex_rule_view.php');
}
elseif($action_mode=='delete'){
  if(!empty($_POST['r_id'])){
    $data_function = new data_function;
    $data_function->setDb('rule');
    $r_id = $_POST['r_id'];
    $where = "AND r_id='".$r_id."'";
    $getdata = $data_function->select($where);
    $name = $getdata['1']['r_pic'];
    $data_function->delete_image($where,$img_dir,$name);
    $data_function->delete($where);
  }
  $pages = new sam_pages_class;
  $pages->setDb('rule','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_rule.php');
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage(2);
  $Endpage = $pages->getEndpage();
  $data = $pages->getData();
  include(VIEW.'/backindex_rule_view.php');
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('rule','ORDER BY r_id ASC','*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_rule.php');
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage(2);
  $Endpage = $pages->getEndpage();
  $data = $pages->getData();
  include(VIEW.'/backindex_rule_view.php');
}

include(BCLASS.'/foot.php');
?>