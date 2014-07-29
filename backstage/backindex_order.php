<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindex_order_view.php
  backindex_orderfix_view.php
  backindex_orderadd_view.php
  back_addannouncementfix_view.php
  backindex_share_view.php
mode_page:
  page_class.php
  
特例 function:
  update_image2($share_id,$img_dir,$files,$ap_subject)
  /下次可以規劃資料庫的話，$share_id 會改成 $album_id，資料會比較一致/
*/
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$order_name = 'order';    
$photo_name = 'order_photo'; 
$img_dir = 'order';
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

if (isset($_POST)){
  foreach ($_POST as $k1 => $v1){
    if(is_array($v1)){
      foreach ($v1 as $k2 => $v2){
        echo '1: $_POST['.$k1.']['.$k2.']='.$v2."<br>\n";
      }
    }
    else{
      echo '1: $_POST['.$k1.']='.$v1."<br>\n";
    }
  }
}

if (isset($_GET)){
  foreach ($_GET as $k => $v){
    echo '1: $_GET['.$k.']='.$v."<br>\n";
  }
}

if (isset($_FILES)){
  foreach ($_FILES as $k1 => $v1){
    foreach ($v1 as $k2 => $v2){
      if(is_array($v2)){
        foreach ($v2 as $k3 => $v3){
          //echo '1: $_FILES['.$k1.']['.$k2.']['.$k3.']='.$v3."<br>\n";
          //$file[$k1][$k2][$k3]=$v3;        
          //echo 'q: $file['.$k3.']['.$k1.']['.$k2.']='.$v3."<br>\n";
        }
      }
      else{
        //echo '1: $_FILES['.$k1.']['.$k2.']='.$v2."<br>\n";      
      }
    }
  }
}


if (isset($_FILES)){
  $files=$_FILES;
}


if($action_mode=='view_all_data'){
  $pages = new sam_pages_class;
  $pages->setDb('order_rulepic','','*');
  
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_order.php');
  $Listpage = $pages->getListpage(2,'backindex_order.php');
  $Endpage = $pages->getEndpage('backindex_order.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST['order_id'])){
    $pages = new sam_pages_class;
    $pages->setDb('order'," AND order_id = '".$_POST['order_id']."'","*");
    $row_Recorder = $pages->getData();
    $pages->setDb("order_photo"," AND order_id = '".$_POST['order_id']."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/backindex_orderaddfix_view.php');
  }
}
elseif($action_mode=='add_order_view'){
  include(VIEW.'/backindex_orderadd_view.php');
}
elseif($action_mode=='add_equipment'){
  include(VIEW.'/add_equipment_view.php');
}
elseif($action_mode=='add_appointment_list'){
  include(VIEW.'/add_appointment_list_view.php');
}
elseif($action_mode=='appointment_list1.php'){
  include(VIEW.'/appointment_list1_view.php');
}
elseif($action_mode=='appointment_list2.php'){
  include(VIEW.'/appointment_list2_view.php');
}
elseif($action_mode=='edit_equipment.php'){
  include(VIEW.'/edit_equipment_view.php');
}
elseif($action_mode=='add_order'){
  if(isset($_POST['order_title'])){
    $data_function = new data_function;
    $data_function->setDb('order');
    $order_title = $_POST['order_title'];  
    $order_date = $_POST['order_date'];
    @$order_ordername = $_POST['order_ordername'];
    if(isset($_POST['order_desc'])){
      $order_desc = $_POST['order_desc'];
    }
    $set = ' order_date="'.$order_date.'", order_ordername="'.$order_ordername.'", order_title="'.$order_title.'", order_desc="'.$order_desc.'"';
    $data_function->add_category($set);
  }
  
  $pages = new sam_pages_class;
  $pages->setDb('order','ORDER BY order_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_order.php');
  $Listpage = $pages->getListpage(2,'backindex_order.php');
  $Endpage = $pages->getEndpage('backindex_order.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
}
elseif($action_mode=='delete'){
  if(isset($_POST['order_id'])){
    $data_function = new data_function;
    $data_function->setDb('order_photo');
    $order_id = $_POST['order_id'];
    $where = "AND order_id='".$order_id."'";
    $getdata = $data_function->select($where);
    if(is_array($getdata)){
      foreach ($getdata as $v1){
        $name = $v1['ap_picurl'];
        $data_function->delete_image($where,$img_dir,$name);
      }
    }
    $data_function->setDb('order');
    $data_function->delete($where);
  }
  
  $pages = new sam_pages_class;
  $pages->setDb('order','ORDER BY order_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_order.php');
  $Listpage = $pages->getListpage(2,'backindex_order.php');
  $Endpage = $pages->getEndpage('backindex_order.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
}
elseif($action_mode=='update'){
  if (isset($_POST['MM_update'])){
    if ($_POST['MM_update']=='form1'){
      $data_function = new data_function;
      $data_function->setDb('order_photo');
      $order_id = $_POST['order_id'];
      if(isset($_POST['ap_subject'])){
        $ap_subject = $_POST['ap_subject'];
      }
      else{
        $ap_subject = NULL;
      }
      
      $data_function->update_image2($order_id,$img_dir,$files,$ap_subject);
      $data_function->setDb('order');
      $order_title = $_POST['order_title'];  
      $order_date = $_POST['order_date'];
      @$order_ordername = $_POST['order_ordername'];
      if(isset($_POST['order_desc'])){
        $order_desc = $_POST['order_desc'];
      }
      $where = "AND `order_id`='".$order_id."'";
      $expression = ' order_date="'.$order_date.'", order_ordername="'.$order_ordername.'", order_title="'.$order_title.'", order_desc="'.$order_desc.'"';
      $data_function->update($where,$expression); 
    }
    if ($_POST['MM_update']=='form3'){
      if(isset($_POST['ap_subject']) && isset($_POST['ap_id']) ){
        $ap_subject = $_POST['ap_subject'];
        $order_id = $_POST['order_id'];
        $ap_id = $_POST['ap_id'];
        $data_function = new data_function;
        $data_function->setDb('order_photo');
        $where = "AND `ap_id` = '".$ap_id."'";
        $expression = " ap_subject='".$ap_subject."'";
        $data_function->update($where,$expression); 
      }
    }
    $pages = new sam_pages_class;
    $pages->setDb('order'," AND order_id = '".$_POST['order_id']."'","*");
    $row_Recorder = $pages->getData();
    $pages->setDb("order_photo"," AND order_id = '".$_POST['order_id']."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/backindex_orderaddfix_view.php');
  }
  
}
elseif($action_mode=='delete_image'){
  if( isset($_POST['ap_id']) && isset($_POST['ap_picurl']) ){
    $where = "AND `ap_id` = '".$_POST['ap_id']."'";
    $name = $_POST['ap_picurl'];
    $data_function = new data_function;
    $data_function->setDb('order_photo');
    $data_function->delete_image($where,$img_dir,$name);
  }
  
    $pages = new sam_pages_class;
    $pages->setDb('order'," AND order_id = '".$_POST['order_id']."'","*");
    $row_Recorder = $pages->getData();
    $pages->setDb("order_photo"," AND order_id = '".$_POST['order_id']."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/backindex_orderaddfix_view.php');
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('order','ORDER BY order_date DESC','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_order.php');
  $Listpage = $pages->getListpage(2,'backindex_order.php');
  $Endpage = $pages->getEndpage('backindex_order.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
}

include(BCLASS.'/foot.php');
?>