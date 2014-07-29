<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindex_shareadd_view.php(x)
  backindex_shareaddfix_view.php(x)
  add_and_edit_view.php
  backindex_share_view.php
mode_page:
  page_class.php
  
特例 function:
  update_image2($share_id,$img_dir,$files,$ap_subject)
  /下次可以規劃資料庫的話，$share_id 會改成 $album_id，資料會比較一致/
*/

//共用樣板設定
$form = 'backindex_share.php';          //指定網頁(幾乎都為本頁)

$subject = '分享園地';                  //本頁類別名稱(文字替換)
$title01 = '標題名稱';                  //(文字替換)
$title02 = '發佈時間';                  //(文字替換)
$title03 = '發表者';                    //(文字替換)
$title04 = '內容';                      //(文字替換)

$input_title = 'share_title';           //標題名稱                {與資料表表格名稱相同}
$input_id = 'share_id';                 //類別主鍵ID(PRIMARY KEY) {與資料表表格名稱相同}
$input_date = 'share_date';             //發佈時間                {與資料表表格名稱相同}
$input_location = 'share_sharename';    //發表者                  {與資料表表格名稱相同}
$input_desc = 'share_desc';             //內容                    {與資料表表格名稱相同}

$pic_url = 'ap_picurl';               //照片上傳後名稱
$pic_id = 'ap_id';                       //所附屬的照片資料表主鍵ID(PRIMARY KEY)
$pic_subject = 'ap_subject';            //照片的說明

$pic_max = '10';
$MM_UserGroup = $_SESSION['MM_UserGroup'];
$enable_pic_subject = 'true';
//

$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$share_name = 'share';    
$photo_name = 'share_photo'; 
$img_dir = 'share';
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
  $pages = new sam_pages_class;
  $pages->setDb($share_name,"ORDER BY $input_date DESC",'*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage($form);
  $Listpage = $pages->getListpage(2,$form);
  $Endpage = $pages->getEndpage($form);
  $data = $pages->getData();
  include(VIEW.'/backindex_share_view.php');
}
elseif($action_mode=='view_select_data'){
  if(isset($_POST[$input_id])){
    $action_mode='update';
    $pages = new sam_pages_class;
    $pages->setDb($share_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');
  }
}
elseif($action_mode=='add_share_view'){
  $action_mode='update';
  include(VIEW.'/add_and_edit_view.php');
}
elseif($action_mode=='update'){
  $data_function = new data_function;
  $data_function->setDb($share_name);
  $my_array = array($input_date, $input_location, $input_title, $input_desc);
  $expression = $data_function->postiswho2($my_array);
  
  if(!empty($_POST[$input_id])){
    $$pic_id = $_POST[$input_id];
    $where_expression = "AND `$input_id`='".$$pic_id."'"; 
    $update_expression = $expression;
    $data_function->update($where_expression,$update_expression); 
  }
  else{
    $insert_expression = $expression;
    $insert_id = $data_function->insert($insert_expression);
    $$pic_id = $insert_id;
  }

  $data_function->setDb($photo_name);
  $ufile = $data_function->assembly_files($_FILES);
  foreach($ufile as $v1){
    $files_name = $v1[$pic_url]['name'];
    if(!empty($files_name)){
    $file_tmp_name = $v1[$pic_url]['tmp_name'];
      $new_filename = $data_function->add_image($img_dir,$files_name,$file_tmp_name);
      sleep(1);
      $expression = "`$input_id`='".$$pic_id."', `$pic_url` = '".$new_filename."'";
      $data_function->insert($expression);
    }
  }

  $action_mode='update';
  $pages = new sam_pages_class;
  $pages->setDb($share_name," AND $input_id = '".$$pic_id."'","*");
  $row_Rec = $pages->getData();
  $pages->setDb($photo_name," AND $input_id = '".$$pic_id."'","*");
  $row_RecPhoto = $pages->getData();
  include(VIEW.'/add_and_edit_view.php');
  //include(VIEW.'/backindex_shareaddfix_view.php');

}
elseif($action_mode=='delete'){
  if(isset($_POST[$input_id])){
    $data_function = new data_function;
    $data_function->setDb($share_name);
    $$input_id = $_POST[$input_id];
    $where = "AND $input_id = '".$$input_id."'";
    $data_function->delete($where);
    $data_function->setDb($photo_name);
    $del_arrays = $data_function->select($where);
    foreach ($del_arrays as $key => $value){
      $name = $value[$pic_url];
      $data_function->delete_image($where,$img_dir,$name);
    }
  }
  
  $pages = new sam_pages_class;
  $pages->setDb($share_name,"ORDER BY $input_date DESC",'*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage($form);
  $Listpage = $pages->getListpage(2,$form);
  $Endpage = $pages->getEndpage($form);
  $data = $pages->getData();
  include(VIEW.'/backindex_share_view.php');
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
    $pages = new sam_pages_class;
    $pages->setDb($share_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');
}
elseif($action_mode=='update_pic_subject'){
  if(isset($_POST[$pic_id])){
    $$pic_id = $_POST[$pic_id];
    $$pic_subject = $_POST[$pic_subject];
    $where_expression = "AND `$pic_id` = '".$$pic_id."'";
    $update_expression = " `$pic_subject` = '".$$pic_subject."'";
    //$name = $_POST[$pic_url];
    $data_function = new data_function;
    $data_function->setDb($photo_name);
    //$data_function->delete_image($where,$img_dir,$name);
    $data_function->update($where_expression, $update_expression); 
  }
  
    $action_mode='update';
    $pages = new sam_pages_class;
    $pages->setDb($share_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');

}
else{
  $pages = new sam_pages_class;
  $pages->setDb($share_name,"ORDER BY $input_date DESC",'*');
  $pages->setPerpage(10,$page);
  $Firstpage = $pages->getFirstpage($form);
  $Listpage = $pages->getListpage(2,$form);
  $Endpage = $pages->getEndpage($form);
  $data = $pages->getData();
  include(VIEW.'/backindex_share_view.php');
}

include(BCLASS.'/foot.php');
?>