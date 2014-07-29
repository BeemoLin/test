<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(BCLASS.'/equipment_class.inc.php');
/*
  $img_dir2 = 'newpic';

  view_page:
    backindex_equipment_add.php
    backindex_equipment_set.php
    backindex_reservation_set.php
    backindex_reservation_add.php
    backindex_equipment_list.php
    backindex_reservation_list.php
  mode_page:
    page_class.php          //父類別庫
    equipment_class.inc.php //原本的 data_function 不堪使用，重寫子類別庫
 */
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$order_name = 'order';
$photo_name = 'order_photo';
$img_dir = 'newpic';

$action_mode = null;

if(isset($_POST)){
  foreach($_POST as $key => $value){
    $$key = $value;
    //echo '$'.$key.'='.$value."<br />\n";
  }
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

if($action_mode=='view_equipment_data'){
	equipment_show_list($page);
}
elseif($action_mode=='add_equipment'){
	$code = mt_rand(0,1000000);
	$_SESSION['add_equipment']= $code;
  include(view.'/backindex_equipment_add.php');
}
elseif($action_mode=='add_equipment_check'){
	if($_POST['check_key'] == $_SESSION['add_equipment']){
		$_SESSION['add_equipment'] = null;
		unset($_SESSION['add_equipment']);
		if(empty($equipment_name) || empty($equipment_max_people)){
			header("backindex_equipment.php");
			exit();
		}
		else{
			$data_function = new data_function;
			$data_function->set_image_dir($img_dir);
			if(is_uploaded_file($_FILES['equipment_rule_picture']['tmp_name'])){
				$name = $_FILES['equipment_rule_picture']['name'];
				$tmp_name = $_FILES['equipment_rule_picture']['tmp_name'];
				$front_name ='equipment_rule_';
				$height = '800';
				$width = '600';
				$new_rule_name = $data_function->add_image2($name,$tmp_name,$front_name,$height,$width);
				if(is_uploaded_file($_FILES['equipment_picture']['tmp_name'])){
					$name = $_FILES['equipment_picture']['name'];
					$tmp_name = $_FILES['equipment_picture']['tmp_name'];
					$front_name ='equipment_pic_';
					$new_picture_name = $data_function->add_image2($name,$tmp_name,$front_name,$height,$width);
				}
				else{
					$new_picture_name = '';
				}
			}
			else{
				header("backindex.php");
				exit;
			}
	//
			$data_function->setDb('equipment_reservation');
			$expression = '
				`equipment_name` = "'.$equipment_name.'", 
				`equipment_rule_picture` = "'.$new_rule_name.'", 
				`equipment_picture` = "'.$new_picture_name.'", 
				`advance_start` = "'.$advance_start.'", 
				`advance_end` = "'.$advance_end.'", 
				`equipment_advance` = "'.$equipment_advance.'", 
				`equipment_exclusive` = "'.$equipment_exclusive.'", 
				`equipment_max_people` = "'.$equipment_max_people.'", 
				`equipment_stop` = "'.$equipment_stop.'", 
				`equipment_hidden` = "'.$equipment_hidden.'"
				';
		}
		$data_function->insert($expression);

		equipment_show_list($page);
	}
	else{  
		echo "<script>alert('請不要刷新本頁面或重複提交表單！');</script>";  
		echo '<div style="text-align : center;"><div><a src="#" onclick="post_to_url'."('backindex_equipment.php', {'action_mode':'view_equipment_data'})".'" >按我返回</a></div></div>';
	}
}
elseif($action_mode=='set_equipment'){
  $action_mode = 'update_equipment_check';
  $data_function = new data_function;
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
  $value = $returnData[1];
  include(view.'/backindex_equipment_set.php');
}
elseif($action_mode=='delete_pic'){
  $data_function = new data_function;
	$data_function->set_image_dir($img_dir);
  $data_function->setDb('equipment_reservation');
	if(isset($equipment_picture)){
		$null_sql = '';
		@$data_function->delete_image2($null_sql,$img_dir,$equipment_picture);
	}
	$where_expression = "AND `equipment_id` = '".$equipment_id."'";
	$update_expression = " `equipment_picture` = '' ";
	$data_function->update($where_expression,$update_expression); 
	
  $action_mode = 'update_equipment_check';
  $data_function = new data_function;
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
  $value = $returnData[1];
  include(view.'/backindex_equipment_set.php');
}
elseif($action_mode=='chang_pic'){
  $data_function = new data_function;
	$data_function->set_image_dir($img_dir);
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
	$value = $returnData[1];

	if(is_uploaded_file($_FILES['new_equipment_picture']['tmp_name'])){
		if(isset($value['equipment_picture'])){
			$null_sql = '';
			@$data_function->delete_image2($null_sql,$img_dir,$value['equipment_picture']);
		}
		$name = $_FILES['new_equipment_picture']['name'];
		$tmp_name = $_FILES['new_equipment_picture']['tmp_name'];
		$front_name ='equipment_pic_';
    $height = '800';
    $width = '600';
		$new_picture_name = $data_function->add_image2($name,$tmp_name,$front_name,$height,$width);
		$update_expression = " `equipment_picture` = '".$new_picture_name."' ";
		$data_function->update($where_expression,$update_expression); 
	}
	else{
		//die('no upload file!! ');
	}
	
  $action_mode = 'update_equipment_check';
  $data_function = new data_function;
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
  $value = $returnData[1];
  include(view.'/backindex_equipment_set.php');
}
elseif($action_mode=='update_equipment_check'){
  if(empty($equipment_name) || empty($equipment_max_people)){
    header("Location: backindex_equipment.php");
    exit();
  }
	$data_function = new data_function;
	$data_function->set_image_dir($img_dir);
	$data_function->setDb('equipment_reservation');
	$update_expression = '
		`equipment_name` = "'.$equipment_name.'", 
		`advance_start` = "'.$advance_start.'", 
		`advance_end` = "'.$advance_end.'", 
		`equipment_advance` = "'.$equipment_advance.'", 
		`equipment_exclusive` = "'.$equipment_exclusive.'", 
		`equipment_max_people` = "'.$equipment_max_people.'", 
		`equipment_stop` = "'.$equipment_stop.'", 
		`equipment_hidden` = "'.$equipment_hidden.'"
		';

	$where_expression = "AND `equipment_id` = '".$equipment_id."'";
	$data_function->update($where_expression,$update_expression); 
	
	equipment_show_list($page);
}
elseif($action_mode=='del_equipment'){
	//die('設計中');
  if(isset($equipment_id)){
    $data_function = new data_function;
    $data_function->setDb('`equipment_reservation`');
    $where = "AND `equipment_id` = '".$equipment_id."'";
    $getdata = $data_function->select($where);
    if(is_array($getdata)){
      foreach ($getdata as $v1){
        $name = $v1['equipment_rule_picture'];
        $data_function->delete_image($where,$img_dir,$name);
        $name = $v1['equipment_picture'];
        $data_function->delete_image($where,$img_dir,$name);
      }
    }
    $data_function->setDb('`equipment_reservation`');
    $data_function->delete($where);
  }
	
	equipment_show_list($page);
}
elseif($action_mode=='view_reservation_data'){
	reservation_show_list($equipment_id,$page);
}
elseif($action_mode=='set_reservation'){
  $action_mode = 'update_reservation_check';
  $data_function = new data_function;
	$select_expression = "	
		`equipment_reservation_list`.*,
		`equipment_reservation`.`equipment_name`,
		`memberdata`.`m_username`
	";
  $data_function->setDb('
		`equipment_reservation_list` 
			LEFT JOIN `equipment_reservation` 
				ON `equipment_reservation_list`.`equipment_id` = `equipment_reservation`.`equipment_id` 
			LEFT JOIN `memberdata`
				ON `equipment_reservation_list`.`m_id` = `memberdata`.`m_id`
	');
  $where_expression = "AND `equipment_reservation_list`.`list_id` = '".$list_id."'";
  $returnData = $data_function->select($where_expression,$select_expression);
  $value = $returnData[1];

  include(view.'/backindex_reservation_set.php');
}
elseif($action_mode=='add_reservation'){
	$code = mt_rand(0,1000000);
	$_SESSION['add_equipment']= $code;
  $action_mode = 'add_reservation_check';
  $data_function = new data_function;
	$data_function->setDb('`memberdata`');
	$select_expression = '`m_id`, `m_username`';
	$where_expression = "AND `m_level` = 'member'";
	$memberData = $data_function->select($where_expression,$select_expression);
	$data_function->setDb('`equipment_reservation`');
	$select_expression = '*';
	$where_expression = "AND `equipment_disable` = '0' AND `equipment_advance` = '1' ";
	$equipmentData = $data_function->select($where_expression,$select_expression);
	
	include(view.'/backindex_reservation_add.php');
}
elseif($action_mode=='add_reservation_check'){
	if($_POST['check_key'] == $_SESSION['add_equipment']){
		$_SESSION['add_equipment'] = null;
		unset($_SESSION['add_equipment']);
		if(empty($set_m_id) || empty($set_equipment_id) || empty($set_list_date) || empty($set_list_time) || !isset($equipment_exclusive)){
			exit('error 01');
			header("Location: backindex_equipment.php");
		}
		else{
			$list_datetime = $set_list_date.' '.$set_list_time;
			$data_function = new data_function;
      $data_function->setDb('equipment_reservation');
      $expression = 'AND `equipment_id` = "'.$set_equipment_id.'"';
      $getdata = $data_function->select($expression);
      $max_people = $getdata[1]['equipment_max_people'];
      
      
			$data_function->setDb('equipment_reservation_list');
      if($equipment_exclusive=="1"){
        /* 要用最大人數為一戶的語法
        $expression = '
          `equipment_id` = "'.$set_equipment_id.'", 
          `list_date` = "'.$set_list_date.'", 
          `list_time` = "'.$set_list_time.'", 
          `list_datetime` = "'.$list_datetime.'", 
          `save_datetime` = NOW(), 
          `m_id` = "'.$set_m_id.'", 
          `list_using_number` = "'.$max_people.'", 
          `list_remarks` = "'.$list_remarks.'"
				';
        */
        
        $expression = '
          `equipment_id` = "'.$set_equipment_id.'", 
          `list_date` = "'.$set_list_date.'", 
          `list_time` = "'.$set_list_time.'", 
          `list_datetime` = "'.$list_datetime.'", 
          `save_datetime` = NOW(), 
          `m_id` = "'.$set_m_id.'", 
          `list_using_number` = "1", 
          `list_remarks` = "'.$list_remarks.'"
				';
      }
      elseif($equipment_exclusive=="0"){
        $expression = '
          `equipment_id` = "'.$set_equipment_id.'", 
          `list_date` = "'.$set_list_date.'", 
          `list_time` = "'.$set_list_time.'", 
          `list_datetime` = "'.$list_datetime.'", 
          `save_datetime` = NOW(), 
          `m_id` = "'.$set_m_id.'", 
          `list_using_number` = "'.$equipment_max_people.'", 
          `list_remarks` = "'.$list_remarks.'"
				';
      }
      else{
        exit('error 02');
        header("Location: backindex_equipment.php");
      }

		}
		$data_function->insert($expression);

		reservation_show_list($equipment_id,$page);
	}
	else{
		echo "<script>alert('請不要刷新本頁面或重複提交表單！');</script>";  
		echo '<div style="text-align : center;"><div><a src="#" onclick="post_to_url'."('backindex_equipment.php', {'action_mode':'view_reservation_data','equipment_id':'$equipment_id'})".'" >按我返回</a></div></div>';
	}
}
elseif($action_mode=='update_reservation_check'){
  $data_function = new data_function;
  $data_function->setDb(' `equipment_reservation_list` ');
	$where_expression = "AND `equipment_reservation_list`.`list_id` = '".$list_id."'";
	$update_expression = "`equipment_reservation_list`.`list_remarks` = '".$list_remarks."'";
  $data_function->update($where_expression,$update_expression);

	reservation_show_list($equipment_id,$page);
}
elseif($action_mode=='disable_reservation'){
	$c_equipment = new equipment;
  $c_equipment->setDb('`equipment_reservation_list`');
	$where_expression = "AND `list_id` = '".$list_id."'";
	$update_expression = " `list_disable` = '1' , `disable_man` = '".$_SESSION['MM_UserID']."'";
	$c_equipment->update($where_expression,$update_expression); 
	
	reservation_show_list($equipment_id,$page);
}
elseif($action_mode=='del_reservation'){
	$c_equipment = new equipment;
  $c_equipment->setDb('`equipment_reservation_list`');
	$where_expression = "AND `list_id` = '".$list_id."'";
	$c_equipment->delete($where_expression); 
	
	reservation_show_list($equipment_id,$page);
}
else{ 
	equipment_show_list($page);
}


//<!--function------------------------------------------------------------------------>//
function equipment_show_list($page){
  $pages = new sam_pages_class;
  $pages->setDb('equipment_reservation',"AND `equipment_disable` = '0' ",'*');
	$pages->action_mode('view_equipment_data');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_equipment.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_equipment_list.php');
}

function reservation_show_list($equipment_id,$page){
	$c_equipment = new equipment;
	$c_equipment->setDb('`equipment_reservation`');
	$select_expression = '*';
	$where_expression = "AND `equipment_id` = '".$equipment_id."'";
	$memberData = $c_equipment->select($where_expression,$select_expression);
	$equipment_name = $memberData[1]['equipment_name']; //取得設備名稱
	$equipment_exclusive = $memberData[1]['equipment_exclusive']; //專屬
	$equipment_max_people = $memberData[1]['equipment_max_people']; //人數上限
	
	//die($equipment_name);
	$c_equipment->setDb('`equipment_reservation_list`');
	$c_equipment->action_mode('view_reservation_data');
	$c_equipment->set_equipment_id($equipment_id);
	$c_equipment->set_equipment_max_people($equipment_max_people);
	$c_equipment->e_set_sql();
  $c_equipment->setPerpage("10",$page); //可取得 limit $start , $this->records_per_page
  $c_equipment->set_base_page('backindex_equipment.php');
	
  $Firstpage = $c_equipment->getFirstpage2();
  $Listpage = $c_equipment->getListpage2(2);
  $Endpage = $c_equipment->getEndpage2();
	
	$all_page=$Firstpage.$Listpage.$Endpage;
	
	$all_datetime_list = $c_equipment->e_list_datetime($page);

	$i=0;
	if(is_array($all_datetime_list)){
		foreach ($all_datetime_list as $key => $value){
			$i++;
			$c_equipment->set_datetime2($value['list_datetime']);
			$date_data = $c_equipment->e_datetime_data();
			$array[$i] = $date_data;
			$count_number = $c_equipment->count_number();
			$array[$i][1]['count_number'] = $count_number;
      if($array[$i][1]['equipment_exclusive']==1){
        $array[$i][1]['sum_number'] = $count_number;
      }
      else{
        $sum_number = $c_equipment->sum_number();
        $array[$i][1]['sum_number'] = $sum_number;
      }
			//$sum_number = $c_equipment->sum_number();
			//$array[$i][1]['sum_number'] = $sum_number;
		}
	}
	
	include(VIEW.'/backindex_reservation_list.php');
}
//<!---------------------------------------------------------------------------------->//

include(BCLASS.'/foot.php');
?>