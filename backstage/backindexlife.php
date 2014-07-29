<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindexlife_view.php
  backindex_show_list_view.php
  backindex_add_things_view.php
mode_page:
  page_class.php
*/
include(BCLASS.'/head.php');
if(INPUT_DEBUG_MODE){
  include(BCLASS.'/debug.php');
}

if (isset($_FILES)){
  $files=$_FILES;
} 

if(isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 1;
}

if(!empty($_POST['life_name'])){
  $life_name = $_POST['life_name'];
  switch ($life_name) {
    case "food":
      $life_cname = '餐廳';
      break;
    case "cloth":
      $life_cname = '服飾店';
      break;
    case "living":
      $life_cname = '住宿';
      break;
    case "walk":
      $life_cname = '交通';
      break;
    case "teach":
      $life_cname = '教育';
      break;
    case "happy":
      $life_cname = '樂點子';
      break;
  }
  $action_mode = $_POST['action_mode'];
//////////////////////////////////////////////////////////////////////
  if($action_mode=='view_all_data'){ //ok
    $pages = new sam_pages_class;
    $pages->setDb("$life_name",'','*');
    $pages->action_mode($action_mode);
    $pages->setPerpage(10,$page);
    $pages->set_base_page('backindexlife.php');
   
    $Firstpage = $pages->getFirstpageForBackStage3($life_name);
    $Listpage = $pages->getListpageForBackStage3($life_name,2);
    $Endpage = $pages->getEndpageForBackStage3($life_name);
    $data = $pages->getData();

    include(VIEW.'/backindexlife_show_list_view.php');
  }
  elseif($action_mode=='add_things'){ //ok
    include(VIEW.'/backindexlife_add_things_view.php');
  }
  elseif($action_mode=='add'){ //ok & ok  //update也寫在這
    $data_function = new data_function;
    $photo = $life_name."_photo2";
    $id_name = $life_name."_id";
    
    if ($_POST['MM_upsert']=='form1'){
      if(!empty($_POST['name'])){
        $name = $_POST['name'];
        $time = $_POST['time'];
        $adj = $_POST['adj'];
        $date = $_POST['date'];
        $phone = $_POST['phone'];
        $copyphone = $_POST['copyphone'];
        $address = $_POST['address'];
        $url = $_POST['url'];
        $data_function->setDb($life_name);
        $expression = "
          ".$life_name."_name = '$name', 
          ".$life_name."_phone = '$phone', 
          ".$life_name."_copyphone = '$copyphone', 
          ".$life_name."_address = '$address', 
          ".$life_name."_time = '$time', 
          ".$life_name."_adj = '$adj', 
          ".$life_name."_date = '$date', 
          ".$life_name."_url = '$url'
        ";
        
        if(!empty($_POST[$id_name])){
          $id = $_POST[$id_name];
          $where = " AND $id_name = '$id' ";
          $data_function->update($where,$expression); 
          
          $expression = " AND $id_name = '$id' ";
          $data = $data_function->select($expression);
          $value = $data['1'];
          $name = $value[$life_name.'_name'];
          $time = $value[$life_name.'_time'];
          $adj = $value[$life_name.'_adj'];
          $date = $value[$life_name.'_date'];
          $phone = $value[$life_name.'_phone'];
          $copyphone = $value[$life_name.'_copyphone'];
          $address = $value[$life_name.'_address'];
          $url = $value[$life_name.'_url'];
          $data_function->setDb($photo);
          $data = $data_function->select($expression);
      
          include(VIEW.'/backindexlife_add_things_view.php');
        }
        else{
          $data_function->insert($expression); 
          $pages = new sam_pages_class;
          $pages->setDb("$life_name",'','*');
          $pages->setPerpage(10,$page);
          $pages->set_base_page('backindex_info.php');
          $Firstpage = $pages->getFirstpage2();
          $Listpage = $pages->getListpage2(2);
          $Endpage = $pages->getEndpage2();
          $data = $pages->getData();
          
          include(VIEW.'/backindexlife_show_list_view.php');
        }
      }
    }

    if ($_POST['MM_upsert']=='form3'){
      $img_dir = $life_name;
      $id = $_POST[$id_name];
      $file_name = 'ap_picurl';
      $data_function->setDb($photo);
      foreach ($_FILES as $k1 => $v1){
        foreach ($v1 as $k2 => $v2){
          foreach ($v2 as $k3 => $v3){
            $ufile[$k3][$k1][$k2] = $v3;
          }
        }
      }
      foreach($ufile as $v1){
        $files_name = $v1['ap_picurl']['name'];
        $file_tmp_name = $v1['ap_picurl']['tmp_name'];
        if(!empty($files_name)){
          //echo $files_name."<br>\n";
          $new_filename = $data_function->add_image($img_dir,$files_name,$file_tmp_name);
          sleep(1);
          $expression = " $id_name = '$id', ap_picurla = '$new_filename' ";
          //echo $expression."<br>\n";
          //echo "<br>\n";
          $data_function->insert($expression);
        }
      }
      
      $expression = " AND $id_name = '$id' ";
      $data = $data_function->select($expression);
      $value = $data['1'];
      $name = $value[$life_name.'_name'];
      $time = $value[$life_name.'_time'];
      $adj = $value[$life_name.'_adj'];
      $date = $value[$life_name.'_date'];
      $phone = $value[$life_name.'_phone'];
      $copyphone = $value[$life_name.'_copyphone'];
      $address = $value[$life_name.'_address'];
      $url = $value[$life_name.'_url'];
      $data_function->setDb($photo);
      $data = $data_function->select($expression);
  
      include(VIEW.'/backindexlife_add_things_view.php');
    }
  }
  elseif($action_mode=='edit_things'){ //ok
    $data_function = new data_function;
    $id_name = $life_name."_id";
    $id = $_POST[$id_name];
    $data_function->setDb($life_name);
    $expression = " AND $id_name = '$id' ";
    $data = $data_function->select($expression);
    $value = $data['1'];
    $name = $value[$life_name.'_name'];
    $time = $value[$life_name.'_time'];
    $adj = $value[$life_name.'_adj'];
    $date = $value[$life_name.'_date'];
    $phone = $value[$life_name.'_phone'];
    $copyphone = $value[$life_name.'_copyphone'];
    $address = $value[$life_name.'_address'];
    $url = $value[$life_name.'_url'];
    
    $photo = $life_name."_photo2";
    $data_function->setDb($photo);
    $data = $data_function->select($expression);
    
    include(VIEW.'/backindexlife_add_things_view.php');
  }
  elseif($action_mode=='delete'){ //
    $photo = $life_name."_photo2";
    $id_name = $life_name."_id";
    $img_dir = $life_name;
    
    $data_function = new data_function;
    if(!empty($_POST[$id_name])){
      $id = $_POST[$id_name];
      $where = " AND $id_name = '$id' ";
      $data_function->setDb($photo);
      $name = $data_function->select($where);
      foreach($name as $v){
        $name = $v['ap_picurla'];
        $data_function->delete_image($where,$img_dir,$name);
      }
      $data_function->setDb($life_name);
      $data_function->delete($where);
    }
  
    $pages = new sam_pages_class;
    $pages->setDb("$life_name",'','*');
    
    $pages->setPerpage(10,$page);
    $pages->set_base_page('backindexlife.php');
    $Firstpage = $pages->getFirstpage2();
    $Listpage = $pages->getListpage2(2);
    $Endpage = $pages->getEndpage2();
    $data = $pages->getData();

    include(VIEW.'/backindexlife_show_list_view.php');
  }
  elseif($action_mode=='delete_image'){
    if(isset($_POST['app_id'])){
      $photo = $life_name."_photo2";
      $where = "AND `app_id` = '".$_POST['app_id']."'";
      $ap_picurla = $_POST['ap_picurla'];
      $data_function = new data_function;
      $data_function->setDb($photo);
      $data_function->delete_image($where,$life_name,$ap_picurla);
    }
    $id_name = $life_name."_id";
    $id = $_POST[$id_name];
    $data_function->setDb($life_name);
    $expression = " AND $id_name = '$id' ";
    $data = $data_function->select($expression);
    $value = $data['1'];
    $name = $value[$life_name.'_name'];
    $time = $value[$life_name.'_time'];
    $adj = $value[$life_name.'_adj'];
    $date = $value[$life_name.'_date'];
    $phone = $value[$life_name.'_phone'];
    $copyphone = $value[$life_name.'_copyphone'];
    $address = $value[$life_name.'_address'];
    $url = $value[$life_name.'_url'];
    
    $photo = $life_name."_photo2";
    $data_function->setDb($photo);
    $data = $data_function->select($expression);
    
    include(VIEW.'/backindexlife_add_things_view.php');
  }
  else{
    include(VIEW.'/backindexlife_view.php');
  }
}
else{
  include(VIEW.'/backindexlife_view.php');
}

include(BCLASS.'/foot.php');
?>