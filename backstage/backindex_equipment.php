<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(BCLASS.'/equipment_class.inc.php');
require_once(INCLUDES.'/processdbcols.php'); 
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
 20121117:增加起迄時間;只要時分(秒不用)
          增加預約結束時間攔位 給insert用
 
 
 
 
 
 
 */
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$order_name = 'order';
$photo_name = 'order_photo';
$img_dir = 'newpic';



/*
20121109修改重要的命令模式判別
*/
//$action_mode = null;

$action_mode=(isset($_POST['action_mode']))?$_POST['action_mode']:null;
$page=(isset($_POST['page']))?$_POST['page']:1;

if(isset($_POST))
{
  //一維陣列
  foreach($_POST as $key => $value)
  {
    $$key = $value;
    //取出表單Submit的(畫面上)元件內容值
    //echo '$'.$key.'='.$value."<br />\n";
  }
}

/*
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
*/
include(BCLASS.'/head.php'); //表頭: 包在CLASS裡面 裡面有post_to_url參數重要因為轉址用

if(INPUT_DEBUG_MODE){
  include(BCLASS.'/debug.php');
}

//-----可以改成switch 更好閱讀

//一開始載入的模式
//var_dump($action_mode);
if($action_mode=='view_equipment_data')
{
	equipment_show_list($page);
}
elseif($action_mode=='add_equipment')
{
	$code = mt_rand(0,1000000);
	$_SESSION['add_equipment']= $code;
  include(view.'/backindex_equipment_add.php');
}
elseif($action_mode=='add_equipment_check')
{
	if($_POST['check_key'] == $_SESSION['add_equipment'])
  {
		$_SESSION['add_equipment'] = null;
		unset($_SESSION['add_equipment']);
		if(empty($equipment_name) || empty($equipment_max_people))
    {
			header("backindex_equipment.php");
			exit();
		}
		else{
			$data_function = new data_function;
			$data_function->set_image_dir($img_dir);
			if(is_uploaded_file($_FILES['equipment_rule_picture']['tmp_name']))
      {
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
elseif($action_mode=='set_equipment')//設定
{
  //die("TEST");
  $action_mode = 'update_equipment_check';
  
  $data_function = new data_function;
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
  //因為ID維一所以可以用一維
  $value = $returnData[1];//代表把一列的資料給$value;所以用$value[0],$value[1]....取欄位值;因為為一維陣列
 // die($returnData[1]);  
  include(view.'/backindex_equipment_set.php');
}
elseif($action_mode=='delete_pic')//刪除設備圖片
{
  $data_function = new data_function;
	$data_function->set_image_dir($img_dir);
  $data_function->setDb('equipment_reservation');
	if(isset($equipment_picture)){
		$null_sql = '';
		@$data_function->delete_image2($null_sql,$img_dir,$equipment_picture);
	}
	$where_expression = "AND `equipment_id` = '".$equipment_id."'";
	$update_expression = " `equipment_picture` = NULL";     //'' "; //改成NULL 這樣前台才不會SHOW出錯誤框框
	
  //die($where_expression."-----------".$update_expression);
	$data_function->update($where_expression,$update_expression); 
	
  $action_mode = 'update_equipment_check';
  $data_function = new data_function;
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
  $value = $returnData[1];
  include(view.'/backindex_equipment_set.php');
}
elseif($action_mode=='chang_pic')//更改設備圖片
{
  $data_function = new data_function;
	$data_function->set_image_dir($img_dir);
  $data_function->setDb('equipment_reservation');
  $where_expression = "AND `equipment_id` = '".$equipment_id."'";
  $returnData = $data_function->select($where_expression);
	$value = $returnData[1];

  //---------------上傳檔案----------------
	if(is_uploaded_file($_FILES['new_equipment_picture']['tmp_name']))
  {
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
	else
  {
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
elseif($action_mode=='update_equipment_check')
{
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
elseif($action_mode=='view_reservation_data')//查看訂約記錄
{
  //20121108 die("測試中");
  //20121117
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
elseif($action_mode=='add_reservation')
{
  //20121108修改
//------初始------
	$code = mt_rand(0,1000000);
	$_SESSION['add_equipment']= $code;
  
  //$action_mode = 'add_reservation_check';
  $action_mode = 'add_reservation';
  
  $data_function = new data_function; //建立資料庫物件
	
  //人員資料
  $data_function->setDb('`memberdata`');
	$select_expression = '`m_id`, `m_username`';
	$where_expression = "AND `m_level` = 'member'";
	$memberData = $data_function->select($where_expression,$select_expression);
	
  //設備資料
  $data_function->setDb('`equipment_reservation`');
	$select_expression = '*';
	$where_expression = "AND `equipment_disable` = '0' AND `equipment_advance` = '1' ";
	$equipmentData = $data_function->select($where_expression,$select_expression);
  //------初始------
  
  //-----summit新增-----
 // echo "1111".$_POST['insertmode'];
  if(isset($_POST['insertmode']))//使用html元件 input type=hidden好用可以用javascript去將mode分為1 insert 2 delete 3 update.....
  {
    //echo "新增模式";
    /*
    $query = "
    INSERT INTO 
    	`equipment_reservation_list`
    SET 
    	`equipment_id` = ".$equipment_id.", 
    	`list_date` = '".$set_list_date."', 
    	`list_time` = '".$set_list_time."', 
    	`list_datetime` = '".$set_list_date." ".$set_list_time."', 
    	`save_datetime` = NOW(), 
    	`m_id` = ".$m_id.", 
    	`list_using_number` = '1'
    ";
    */
    // die("模式:".$action_mode);
    
    
    //先取值 資料庫攔位與HTML物件名稱與變數名稱都統一一樣
    //----這邊應可以註解掉;因為上面有先取值ㄋ
    //$equipment_id=$_POST['set_equipment_id'];
    //$list_date=$_POST['set_list_date'];
    //$list_time=$_POST['set_list_time'];
    $list_datetime=$set_list_date." ".$set_list_time;
    $save_datetime="NOW()";//使用MYSQL的NOW函數
    //$m_id=$_POST['set_m_id'];
    $list_using_number="1";
   // $list_remarks=$_POST['list_remarks'];
    $list_disable='0'; 
    
    //20121117 增加新攔位
    //$list_endtime=$_POST['list_endtime'];
    //20121117 增加新攔位
    
    //先取值 資料庫攔位與HTML物件名稱與變數名稱都統一一樣
    //echo $equipment_id;
    
    $data_function->setDb("equipment_reservation_list");
    $expression = "`equipment_id`='".$set_equipment_id."',`list_date` = '".$set_list_date."',`list_time` = '".$set_list_time."',`list_endtime` = '".$list_endtime."',`list_datetime` = '".$list_datetime."',`save_datetime` = ".$save_datetime.",`m_id` = '".$set_m_id."',`list_using_number` = '".$list_using_number."',`list_remarks` = '".$list_remarks."',`list_disable` = '".$list_disable."'";//,`m_id` = '".$pic_subject."'"
    //die($expression);
    $data_function->insert($expression);
    
  }
  //-----summit新增-----
 
  //call View 
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
	$update_expression = " `list_disable` = '1' ,`save_datetime` = NOW(), `disable_man` = '".$_SESSION['MM_UserID']."'";
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
function equipment_show_list($page)
{
  
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

function reservation_show_list($equipment_id,$page)
{
  
	$c_equipment = new equipment; //IN equipment_class.inc.php裡面
	
	//1.查詢設備 只有一筆(一維陣列)
	$c_equipment->setDb('`equipment_reservation`');
	$select_expression = '*';
	$where_expression = "AND `equipment_id` = '".$equipment_id."'";
	$memberData = $c_equipment->select($where_expression,$select_expression);
	
  $equipment_name = $memberData[1]['equipment_name']; //取得設備名稱
	$equipment_exclusive = $memberData[1]['equipment_exclusive']; //專屬
	$equipment_max_people = $memberData[1]['equipment_max_people']; //人數上限
	//201211117:增加設備的時間
	$equipment_end_time = $memberData[1]['advance_end']; //設備結束時間
	
	//die($equipment_name);
	
	//2.查詢訂約記錄 依照設備的ID
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
	
	//3.頁數元件
	$all_page=$Firstpage.$Listpage.$Endpage; 
	
	$all_datetime_list = $c_equipment->e_list_datetime($page);

	$i=0;
	if(is_array($all_datetime_list))
  {
    //資料集二維陣列
    $timeformat=new processdbcols;
		foreach ($all_datetime_list as $key => $value)
    {
      
			$i++;
		  //var_dump($equipment_end_time);
      //var_dump($array[$i][1]['timerformat']);
		  //	var_dump($value['advance_end']);20121117增加此查詢攔位
			$c_equipment->set_datetime2($value['list_datetime']);
			$date_data = $c_equipment->e_datetime_data();
			
      $array[$i] = $date_data;//這邊要做CHECK 因為可能比數會>1要check
      
       //var_dump($array[$i][1]['list_datetime']);
		  
			$count_number = $c_equipment->count_number();
			//var_dump($count_number);
			//----20121117 陣列的存取-------
      for($cnt=1;$cnt<=$count_number;$cnt++)
			{
         $array[$i][$cnt]['list_datetime']=$timeformat->equipment_reservation_list_list_endtime($value['list_endtime'],$value['list_time'],$equipment_end_time,$value['equipment_id'],$value['list_datetime']);
      }
			//----20121117 陣列的存取-------
			$array[$i][1]['count_number'] = $count_number;
      
      if($array[$i][1]['equipment_exclusive']==1)
      {
        $array[$i][1]['sum_number'] = $count_number;
      }
      else
      {
        $sum_number = $c_equipment->sum_number();
        $array[$i][1]['sum_number'] = $sum_number;
      }
			//$sum_number = $c_equipment->sum_number();
			//$array[$i][1]['sum_number'] = $sum_number;
		}
		
		
	}
	
	//MARK
	
	include(VIEW.'/backindex_reservation_list.php');
}
//<!---------------------------------------------------------------------------------->//

include(BCLASS.'/foot.php');
?>
