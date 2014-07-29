<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

/*

view_page:
  backindex_vote_list_view.php
  backindex_vote_add_list_view.php
  backindex_vote_add_options_view.php
  backindex_vote_add_statistics_view.php
  backindex_vote_group_list_view.php
  backindex_vote_statistics_list_view.php
  backindex_vote_statistics_view.php
  backindex_vote_add_group_view.php

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

if($action_mode=='view_all_data'){
  $pages = new sam_pages_class;
  $pages->setDb('vote_1_topic','AND `topic_hidden` = "0" AND `topic_disable` = "0" ORDER BY `vote_1_topic`.`topic_id` DESC','*');
  $pages->set_base_page('backindex_vote.php');
  $pages->setPerpage(10,$page);
  $pages->action_mode('view_all_data');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_vote_list_view.php'); 
}
elseif($action_mode=='add_topic'){
  $action_mode='add_topic_check';
  include(VIEW.'/backindex_vote_add_topic_view.php');
}
elseif($action_mode=='add_topic_check'){
  if(isset($_POST)){
    foreach($_POST as $key => $value){
      $$key = $value;
      //echo '$'.$key.'='.$value."<br />\n";
    }
  }
  if(empty($topic_title) || empty($topic_period_start) || empty($topic_period_end)){
      header("backindex_vote.php");
      exit();
  }
  else{
    $data_function = new data_function;
    $data_function->setDb('vote_1_topic');
    if($topic_short_time == '0'){
      $expression = '
        `topic_title` = "'.$topic_title.'", 
        `topic_content` = "'.$topic_content.'", 
        `topic_period_start` = "'.$topic_period_start.'", 
        `topic_period_end` = "'.$topic_period_end.'", 
        `topic_publish` = "'.$topic_publish.'", 
        `topic_short_time` = "'.$topic_short_time.'", 
        `topic_chang` = "'.$topic_chang.'", 
        `topic_hidden` = "0"
        ';
    }
    elseif(isset($topic_show_start) && isset($topic_show_end)){
      $expression = '
        `topic_title` = "'.$topic_title.'", 
        `topic_content` = "'.$topic_content.'", 
        `topic_period_start` = "'.$topic_period_start.'", 
        `topic_period_end` = "'.$topic_period_end.'", 
        `topic_publish` = "'.$topic_publish.'", 
        `topic_short_time` = "'.$topic_short_time.'", 
        `topic_show_start` = "'.$topic_show_start.'", 
        `topic_show_end` = "'.$topic_show_end.'", 
        `topic_chang` = "'.$topic_chang.'", 
        `topic_hidden` = "0"
        ';
    }
    else{
      header("Location: backindex_vote.php");
      exit();
    }
  }
  $data_function->insert($expression);
  
  $pages = new sam_pages_class;
  $pages->setDb('vote_1_topic','AND `topic_hidden` = "0" AND `topic_disable` = "0" ORDER BY `vote_1_topic`.`topic_id` DESC','*');
  $pages->set_base_page('backindex_vote.php');
  $pages->setPerpage(10,$page);
  $pages->action_mode('view_all_data');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_vote_list_view.php');
}
elseif($action_mode=='group_list'){
  if(isset($_POST)){
    foreach($_POST as $key => $value){
      $$key = $value;
    }
  }
  //$topic_id;
  
  $action_mode = 'add_group';
  $data_function = new data_function;
  $data_function->setDb('vote_1_topic');
  $where_expression = "AND `topic_id` = '".$topic_id."'";
  $returnData = $data_function->select($where_expression);
  $topicData = $returnData['1'];
  
  $data_function->foreach_checked($returnData);
  
  $data_function->setDb('vote_2_group');
  $where_expression = "AND `topic_id` = '".$topic_id."'";
  $groupData = $data_function->select($where_expression);
  
  echo "<br />\n";
  $data_function->foreach_checked($groupData);
  echo "<br />\n";
  
  echo "--------------------------------------------------------------------------------<br>\n";
  if(isset($groupData)){
    $data_function->setDb('vote_3_options');
    foreach($groupData as $key => $value){
      //$groupData[$key][]=
      $where_expression = "AND `group_id` = '".$groupData[$key]['group_id']."'";
      $optionsData = $data_function->select($where_expression);
      foreach($optionsData as $key1 => $value1){
        foreach($value1 as $key2 => $value2){
          $groupData[$key]['options'][$key1][$key2]=$value2;
        }
      }
      
      $data_function->foreach_checked($optionsData);
      
      echo "--------------------------------------------------------------------------------<br>\n";
    }
  }


  

  include(VIEW.'/backindex_vote_group_list_view.php');
}
elseif($action_mode=='add_group'){
  if(isset($_POST)){
    foreach($_POST as $key => $value){
      $$key = $value;
    }
  } 
  $action_mode = 'add_group_check';
  $data_function = new data_function;
  $data_function->setDb('vote_1_topic');
  $where_expression = "AND `topic_id` = '".$topic_id."'";
  $returnData = $data_function->select($where_expression);
  $topicData = $returnData['1'];
  include(VIEW.'/backindex_vote_add_group_view.php');
}
elseif($action_mode=='add_group_check'){
  if(isset($_POST)){
    foreach($_POST as $key => $value){
      $$key = $value;
    }
  }
  
  $action_mode = 'add_group_check';
  $data_function = new data_function;
  $data_function->setDb('vote_2_group');
  $expression="
    `topic_id` = '".$topic_id."', 
    `group_name` = '".$group_name."', 
    `group_content` = '".$group_content."', 
    `group_multiple` = '".$group_multiple."', 
    `group_disable` = '0'
  ";
  
  
  $data_function->insert($expression);
  
  $where_expression = "AND `topic_id` = '".$topic_id."'";
  $returnData = $data_function->select($where_expression);
  $topicData = $returnData['1'];
  include(VIEW.'/backindex_vote_add_group_view.php');
}
//////////////////////////////////////////////
elseif($action_mode=='add_options'){
  if(isset($_POST)){
    foreach($_POST as $key => $value){
      $$key = $value;
      //echo '$'.$key.'='.$value."<br />\n";
    }
  }
  //$topic_id;
  $action_mode = 'add_options_check';
  include(VIEW.'/backindex_vote_add_statistics_view.php');
}
elseif($action_mode=='add_options_check'){
  include(VIEW.'/backindex_vote_add_options_view.php');
}
///////////////////////////////////////////////////////////////////////////
elseif($action_mode=='add_options'){
  if(isset($_POST)){
    foreach($_POST as $key => $value){
      $$key = $value;
      //echo '$'.$key.'='.$value."<br />\n";
    }
  }
  //$topic_id;
  $action_mode = 'add_options_check';
  include(VIEW.'/backindex_vote_add_options_view.php');
}
elseif($action_mode=='add_options_check'){
  include(VIEW.'/backindex_vote_add_options_view.php');
}
elseif($action_mode=='add'){

/*   include(VIEW.'/backindex_QAadd_view.php'); */

}
elseif($action_mode=='add_qa'){

/*   if(isset($_POST['qa_type'])){
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
  include(VIEW.'/backindex_QA_view.php'); */
  
}
elseif($action_mode=='view_select_data'){

/*   if(isset($_POST['qa_id'])){
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
    include(VIEW.'/backindex_QAshow_view.php');
  } */
  
}
elseif($action_mode=='delete'){

/*   if(isset($_POST['qa_id'])){
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
  include(VIEW.'/backindex_QA_view.php'); */
  
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('vote_1_topic','AND `topic_hidden` = "0" AND `topic_disable` = "0" ORDER BY `vote_1_topic`.`topic_id` DESC','*');
  $pages->set_base_page('backindex_vote.php');
  $pages->setPerpage(10,$page);
  $pages->action_mode('view_all_data');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_vote_list_view.php');
}

include(BCLASS.'/foot.php');
?>