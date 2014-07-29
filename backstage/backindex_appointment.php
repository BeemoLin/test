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
  add_equipment_view.php
  add_order_view.php
  backindex_order_view.php
  edit_equipment_view.php
  order_show_view.php
  order_show_ps_view.php
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

if($action_mode=='view_all_data'){ //ok
  $pages = new sam_pages_class;
  $pages->setDb('order_rulepic','','*');
  
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_appointment.php');
  $Listpage = $pages->getListpage(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
}
elseif($action_mode=='add_equipment'){ //ok
  include(VIEW.'/add_equipment_view.php');
}
elseif($action_mode=='edit_equipment'){ //ok
  if(isset($_POST['rulepic_id'])){
    $pages = new sam_pages_class;
    $pages->setDb('order_rulepic'," AND rulepic_id = '".$_POST['rulepic_id']."'","*");
    $row_Recordset = $pages->getData();
    $pages->setDb("order_all_pic"," AND rulepic_id = '".$_POST['rulepic_id']."'","*");
    $row_Recordset2 = $pages->getData();
    include(VIEW.'/edit_equipment_view.php');
  }  
}
elseif($action_mode=='add'){ //ok
  if(!empty($_POST['name'])){
    $data_function = new data_function;
    $data_function->setDb('order_rulepic');
    $name = $_POST['name'];
    $pic_name = $files['pic']['name'];
    $tmp_name = $files['pic']['tmp_name'];
    $img_name = $data_function->add_image($img_dir,$pic_name,$tmp_name);
    $expression = ' pic="'.$img_name.'", name="'.$name.'"';
    $data_function->insert($expression); 
  }
  
  $pages = new sam_pages_class;
  $pages->setDb('order_rulepic','','*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_appointment.php');
  $Listpage = $pages->getListpage(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
} 
elseif($action_mode=='update1'){ //ok
  $name = $_POST['name'];
  $rulepic_id = $_POST['rulepic_id'];
  $data_function = new data_function;
  // order_rulepic 改資料名  
  $data_function->setDb('order_rulepic');
  $expression = ' name="'.$name.'"';
  $where = 'AND rulepic_id="'.$rulepic_id.'"';
  $data_function->update($where,$expression);
  // order_all_pic 改資料名
  $data_function->setDb('order_all_pic');
  $expression = ' oa_name = "'.$name.'"';
  $where = 'AND rulepic_id = "'.$rulepic_id.'"';
  $data_function->update($where,$expression);
  
  @$old_Pic_name = $_POST['old_Pic_name'];
  @$old_oa_pic_name = $_POST['old_oa_pic_name'];
  
  if (is_uploaded_file($_FILES['pic']['tmp_name'])) {
    $data_function->setDb('order_rulepic');
    $files_name = $files['pic']['name'];
    $tmp_name = $files['pic']['tmp_name'];
    $img_name = $data_function->add_image($img_dir,$files_name,$tmp_name);
    if(!empty($old_Pic_name)){
      unlink($img_dir.'/'.$old_Pic_name);
    }
    $expression = ' pic="'.$img_name.'"';
    $where = 'AND rulepic_id="'.$rulepic_id.'"';
    $data_function->update($where,$expression);
  }

  if (is_uploaded_file($_FILES['oa_pic']['tmp_name'])) {
    
    $data_function->setDb('order_all_pic');
    $pic_name = $files['oa_pic']['name'];
    $tmp_name = $files['oa_pic']['tmp_name'];
    $img_name = $data_function->add_image($img_dir2,$pic_name,$tmp_name);
    if(!empty($old_oa_pic_name)){
      @unlink($img_dir2.'/'.$old_oa_pic_name);
      $expression = ' oa_pic = "'.$img_name.'"';
      $where = 'AND rulepic_id = "'.$rulepic_id.'"';
      $data_function->update($where,$expression);
    }
    else{
      $expression = "rulepic_id = '".$rulepic_id."' , oa_pic = '".$img_name."' , oa_name = '".$name."'";
      $data_function->insert($expression);
    }
  }

  $pages = new sam_pages_class;
  $pages->setDb('order_rulepic'," AND rulepic_id = '".$_POST['rulepic_id']."'","*");
  $row_Recordset = $pages->getData();
  $pages->setDb("order_all_pic"," AND rulepic_id = '".$_POST['rulepic_id']."'","*");
  $row_Recordset2 = $pages->getData();
  
  include(VIEW.'/edit_equipment_view.php');

}
elseif($action_mode=='deltree_appointment'){ //ok
  if(isset($_POST['rulepic_id'])){
    $rulepic_id = $_POST['rulepic_id'];
    $data_function = new data_function;
    $data_function->setDb('order_rulepic');
    $where = "AND rulepic_id = '".$rulepic_id."'";
    $getdata = $data_function->select($where);
    
    if(is_array($getdata)){
      foreach ($getdata as $v1){
        $name = $v1['pic'];
        $data_function->delete_image($where,$img_dir,$name);
      }
    }
    $data_function->delete($where);
    $getdata = NULL;
    
    $data_function->setDb('order_all_pic');
    $getdata = $data_function->select($where);
    if(is_array($getdata)){
      foreach ($getdata as $v1){
        $name = $v1['oa_pic'];
        $data_function->delete_image($where,$img_dir2,$name);
      }
    }
    $data_function->delete($where);

    ////////////////////////////////
    $pages = new sam_pages_class;
    $pages->setDb('order_rulepic','','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindex_appointment.php');
    $Listpage = $pages->getListpage(2,'backindex_appointment.php');
    $Endpage = $pages->getEndpage('backindex_appointment.php');
    $data = $pages->getData();
    include(VIEW.'/backindex_order_view.php');  
  }
}
elseif($action_mode=='add_order_view'){ //ok
$data_function = new data_function;

//$query_Recordset1 = "SELECT m_username FROM memberdata";
$data_function->setDb('memberdata');
$expression = "ORDER BY `m_username` ASC";
$user_name = $data_function->select($expression);

//$query_Recordset2 = "SELECT name FROM order_rulepic WHERE 1 = 1";
$data_function->setDb('order_rulepic');
$expression = "";
$appointment_name = $data_function->select($expression);
include(VIEW.'/add_order_view.php'); 
}
elseif($action_mode=='add_order'){ //ok
  if (empty($_POST['rulepic_id'])||empty($_POST['order_name'])||empty($_POST['Adate'])||empty($_POST['order_time'])){
    die('有資料未輸入');
  }
  else{
    $rulepic_id = $_POST['rulepic_id'];
    $order_name = $_POST['order_name'];
    
    $Adate = $_POST['Adate'];
    $k = explode('-',$Adate);
    if(checkdate($k[1],$k[2],$k[0])){
      //echo "Adate is OK !!";
    }
    else{
      //die("Adate is Error !!");
    }
    
    $order_time = $_POST['order_time'];
    $os = array("08:00~10:00", "10:00~12:00", "12:00~14:00", "14:00~16:00", "16:00~18:00", "18:00~20:00", "20:00~22:00");
    if (!in_array($order_time, $os)){
      die("預約時間型態不合");
    }

  $data_function = new data_function;
  $data_function->setDb('order_rulepic');
  $expression = "AND rulepic_id='".$rulepic_id."'";
  $appointment_name = $data_function->select($expression);
  $name = $appointment_name['1']['name'];

  $data_function->setDb('order_all');
  $expression ="`name` = '".$name."', 
                `rulepic_id` = '".$rulepic_id."', 
                `year` = '".$k[0]."',  
                `month` = '".$k[1]."', 	
                `day` = '".$k[2]."', 
                `order_name` = '".$order_name."',
                `order_time` = '".$order_time."',
                `o_time` = '".$k[0].$k[1].$k[2]."' ";
  $data_function->insert($expression);
  }
  $pages = new sam_pages_class;
  $pages->setDb('order_all',' ORDER BY o_time DESC','*');
  $pages->action_mode('order_show_view');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage2('backindex_appointment.php');
  $Listpage = $pages->getListpage2(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage2('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/order_show_view.php');
}
elseif($action_mode=='order_show_view'){ //ok
  $pages = new sam_pages_class;
  $pages->setDb('order_all',' ORDER BY o_time DESC','*');
  $pages->action_mode('order_show_view');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage2('backindex_appointment.php');
  $Listpage = $pages->getListpage2(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage2('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/order_show_view.php');  
}
elseif($action_mode=='order_show_ps'){ //ok
  $order_id = $_POST['order_id'];
  $rulepic_id = $_POST['rulepic_id'];
  $data_function = new data_function;
  $data_function->setDb('order_all');
  $expression = "AND order_id = '".$order_id."' and rulepic_id ='".$rulepic_id."'";
  $row_Recbody = $data_function->select($expression);
  include(VIEW.'/order_show_ps_view.php');  
}
elseif($action_mode=='edit_ps'){ //應該要有,好像沒有用到
  $order_id = $_POST['order_id'];
  $o_ps = $_POST['o_ps'];
  $disable = $_POST['disable'];
  $data_function = new data_function;
  $data_function->setDb('order_all');
  $where = "AND order_id = '".$order_id."'";
  $expression = "o_ps = '".$o_ps."', disable = '".$disable."'";
  $row_Recbody = $data_function->update($where,$expression);
  
  $pages = new sam_pages_class;
  $pages->setDb('order_all',' ORDER BY o_time DESC','*');
  $pages->action_mode('order_show_view');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage2('backindex_appointment.php');
  $Listpage = $pages->getListpage2(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage2('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/order_show_view.php');  
  
  /*
  $rulepic_id = $_POST['rulepic_id'];
  $expression = "AND order_id = '".$order_id."' and rulepic_id ='".$rulepic_id."'";
  $row_Recbody = $data_function->select($expression);
  include(VIEW.'/order_show_ps_view.php');  
  */
}
elseif($action_mode=='delete'){ //----  NO
/*
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
  $Firstpage = $pages->getFirstpage('backindex_appointment.php');
  $Listpage = $pages->getListpage(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
*/
}
elseif($action_mode=='update'){ //----  NO
/*
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
  */
}
else{ //OK
  $pages = new sam_pages_class;
  $pages->setDb('order_rulepic','','*');  
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage('backindex_appointment.php');
  $Listpage = $pages->getListpage(2,'backindex_appointment.php');
  $Endpage = $pages->getEndpage('backindex_appointment.php');
  $data = $pages->getData();
  include(VIEW.'/backindex_order_view.php');
}

include(BCLASS.'/foot.php');
?>