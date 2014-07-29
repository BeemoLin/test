<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once CONNSQL;
require_once PAGECLASS;
/*
view_page:
  add_and_edit_view.php'
  backindex_rules_view.php
mode_page:
  page_class.php
  
特例 function:
  update_image2($share_id,$img_dir,$files,$ap_subject)
  /下次可以規劃資料庫的話，$share_id 會改成 $album_id，資料會比較一致/
*/

//共用樣板設定
$form = 'backindex_rules.php';          //指定網頁(幾乎都為本頁)

$subject = '規約辦法';                  //本頁類別名稱(文字替換)
$title01 = '規約名稱';                  //(文字替換)
$title02 = '發佈時間';                  //(文字替換)
$title03 = '發佈者';                    //(文字替換)
$title04 = '內容';                      //(文字替換)
$title05 = '新增規約';                  //(文字替換)
$title06 = '規約';                      //(文字替換)

$input_title = 'rules_title';           //標題名稱                {與資料表表格名稱相同}
$input_id = 'rules_id';                 //類別主鍵ID(PRIMARY KEY) {與資料表表格名稱相同}
$input_date = 'rules_date';             //發佈時間                {與資料表表格名稱相同}
$input_location = 'rules_sharename';    //發表者                  {與資料表表格名稱相同}
$input_desc = 'rules_desc';             //內容                    {與資料表表格名稱相同}

$pic_url = 'ap_picurl';                 //照片上傳後名稱
$pic_id = 'ap_id';                      //所附屬的照片資料表主鍵ID(PRIMARY KEY)
$pic_subject = 'ap_subject';            //照片的說明

$pic_max = '10';
$MM_UserGroup = $_SESSION['MM_UserGroup'];
$enable_pic_subject = 'true';
//

$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$rules_name = 'rules';    
$photo_name = 'rules_photo'; 
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

$MM_UserGroup = $_SESSION['MM_UserGroup'];

if($action_mode=='view_all_data'){
  $pages = new sam_pages_class();
  $pages->setDb($rules_name,"ORDER BY $input_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page($form);
  $pages->action_mode('view_all_data');
  $Firstpage = $pages->getFirstpage();
  $Listpage = $pages->getListpage(2);
  $Endpage = $pages->getEndpage();
  $data = $pages->getData();
  include(VIEW.'/backindex_rules_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST[$input_id])){
    $action_mode='update';
    $pages = new sam_pages_class();
    $pages->setDb($rules_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');
  }
}
elseif($action_mode=='add_rules_view'){
  $action_mode='update';
  include(VIEW.'/add_and_edit_view.php');
}
elseif($action_mode=='update'){
  $data_function = new data_function;
  $data_function->setDb($rules_name);
  $my_array = array($input_date, $input_location, $input_title, $input_desc);
  $expression = $data_function->postiswho2($my_array);
  
  if(!empty($_POST[$input_id])){
    $$input_id = $_POST[$input_id];
//  $rules_id   = $_POST[$input_id];
    $where_expression = "AND `$input_id`='".$$input_id."'"; 
//  $where_expression = "AND `rules_id` ='".$rules_id."'"; 
    $update_expression = $expression;
    $data_function->update($where_expression,$update_expression); 
  }
  else{
    $insert_expression = $expression;
    $insert_id = $data_function->insert($insert_expression);
    $$input_id = $insert_id;
//  $rules_id  = $insert_id;
  }

  $data_function->setDb($photo_name);
  $ufile = $data_function->assembly_files($_FILES,$pic_subject);
  foreach($ufile as $key1 => $value1){
    foreach($value1 as $key2 => $value2){
      foreach ($value2 as $key3 =>$value3){
        //echo '$ufile['.$key1.']['.$key2.']['.$key3.']='.$value3."<br />\n";
      }
    }
  }
  //die();
  foreach($ufile as $v1){
    $files_name = $v1[$pic_url]['name'];
    if(!empty($files_name)){
      $file_tmp_name = $v1[$pic_url]['tmp_name'];
      $$pic_subject = $v1[$pic_url][$pic_subject];
      $new_filename = $data_function->add_image($img_dir,$files_name,$file_tmp_name);
      sleep(1);
      $expression = "`$input_id`='".$$input_id."', `$pic_url` = '".$new_filename."', `$pic_subject` = '".$$pic_subject."'";
  //  $expression = "`rules_id`='".$rules_id."', `ap_picurl` = '".$new_filename."', `$pic_subject` = '".$$pic_subject."'";      
  //  $expression = "`$input_id`='".$$pic_id."', `$pic_url` = '".$new_filename."'";
  //  $expression = "`rules_id` ='".$rules_id."',   `ap_picurl`= '".$new_filename."'";
      //die($expression);
      $data_function->insert($expression);
    }
  }

  $action_mode='update';
  $pages = new sam_pages_class;
  $pages->setDb($rules_name," AND $input_id = '".$$input_id."'","*");
//$pages->setDb($rules_name," AND rules_id = '".$ap_id."'",  "*");
  $row_Rec = $pages->getData();
  $pages->setDb($photo_name," AND $input_id = '".$$input_id."'","*");
//$pages->setDb($photo_name," AND rules_id = '".$ap_id."'",  "*");
  $row_RecPhoto = $pages->getData();
  include(VIEW.'/add_and_edit_view.php');
  //include(VIEW.'/backindex_rulesaddfix_view.php');

}
elseif($action_mode=='delete'){
  if(isset($_POST[$input_id])){
    $data_function = new data_function;
    $data_function->setDb($rules_name);
    $$input_id = $_POST[$input_id];
//  $rules_id  = $_POST[$input_id];
    $where = "AND $input_id = '".$$input_id."'";
//  $where = "AND rules_id  = '".$rules_id."'";
    $data_function->delete($where);
    $data_function->setDb($photo_name);
    $del_arrays = $data_function->select($where);
    if(is_array($del_arrays)){
      foreach ($del_arrays as $key => $value){
        $name = $value[$pic_url];
        $data_function->delete_image($where,$img_dir,$name);
      }
    }
  }
  
  $pages = new sam_pages_class();
  $pages->setDb($rules_name,"ORDER BY $input_date DESC",'*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage($form);
  $Listpage = $pages->getListpage(2,$form);
  $Endpage = $pages->getEndpage($form);
  $data = $pages->getData();
  include(VIEW.'/backindex_rules_view.php');
}
elseif($action_mode=='delete_image'){
//die($_POST[$pic_id]);
  if( isset($_POST[$pic_id]) && isset($_POST[$pic_url]) ){
    $where = "AND `$pic_id` = '".$_POST[$pic_id]."'";
    $name = $_POST[$pic_url];
    $data_function = new data_function;
    $data_function->setDb($photo_name);
    $data_function->delete_image($where,$img_dir,$name);
  }
  
    $action_mode='update';
    $pages = new sam_pages_class();
    $pages->setDb($rules_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');
}
elseif($action_mode=='update_pic_subject'){
  if(isset($_POST[$pic_id])){
    $$pic_id = $_POST[$pic_id];
//  $ap_id   = $_POST[$pic_id];
    $$pic_subject = $_POST[$pic_subject];
//  $ap_subject   = $_POST[$pic_subject];
    $where_expression = "AND `$pic_id` = '".$$pic_id."'";
//  $where_expression = "AND `ap_id`   = '".$ap_id."'";
    $update_expression = " `$pic_subject` = '".$$pic_subject."'";
//  $update_expression = " `ap_subject`   = '".$ap_subject."'";
//  $name = $_POST[$pic_url];
    $data_function = new data_function;
    $data_function->setDb($photo_name);
    //$data_function->delete_image($where,$img_dir,$name);
    $data_function->update($where_expression, $update_expression); 
  }
  
    $action_mode='update';
    $pages = new sam_pages_class();
    $pages->setDb($rules_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');

}
else{
  $pages = new sam_pages_class();
  $pages->setDb($rules_name,"ORDER BY $input_date DESC",'*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage($form);
  $Listpage = $pages->getListpage(2,$form);
  $Endpage = $pages->getEndpage($form);
  $data = $pages->getData();
  include(VIEW.'/backindex_rules_view.php');
}

include(BCLASS.'/foot.php');
?>