<?php


require_once('define.php');
//require_once(CONNSQL);session檢查的機制
require_once(PAGECLASS);
require_once(INCLUDES.'/processdbcols.php');



//urldecode
//取HTML所有物件的內容使用action=get
if(isset($_GET))
{
	foreach($_GET as $key => $value){
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}
$page=(isset($_GET['page']))?$_GET['page']:1;
//echo "頁數問題:".$page;
//$m_id = $_SESSION['MM_UserID'];
//$logoutAction = 'logout.php';
//開始撈表身資料
	$select = '
		`equipment_reservation_list`.*, 
		`equipment_reservation`.`equipment_name`,	
		`equipment_reservation`.`equipment_exclusive`,	
		`equipment_reservation`.`equipment_max_people`,	
		`equipment_reservation`.`advance_end`,	
		`memberdata`.`m_username`
	';
	//equipment_reservation_list(訂約記錄) 與 equipment_reservation(設備資料) 聯集 條件是1.住戶自己的ID與訂約的住戶ID與2.設備的ID與訂約的設備ID
	$from_DB = '
		`equipment_reservation_list` 
		LEFT JOIN `equipment_reservation` 
			ON `equipment_reservation_list`.`equipment_id` = `equipment_reservation`.`equipment_id` 
		LEFT JOIN `memberdata`
			ON `equipment_reservation_list`.`m_id` = `memberdata`.`m_id`
	';

//先不要有頁數功能之後再加

//$pages = new sam_pages_class;
$pages = new data_function;
//---------------------------------------------------------------------
//當點已預約清單全撈
//超連結 a href="" 使用轉址,所以重要 href屬性很重要(a href="#")

if(isset($equipment_id)) //VIEW使用陣列跑回圈所以要判別是否有陣列
{
  //echo  "設備名稱:".$equipment_id;
  //die("各項設備名稱");
  //	AND
	//		`equipment_reservation_list`.`list_disable` = '0'
	
	//住戶的條件改成日期的條件
	$where = "
		AND 
			`equipment_reservation_list`.`equipment_id` = '".$equipment_id."'
		AND
			(`equipment_reservation_list`.`list_date`>='".$list_startdate."' AND `equipment_reservation_list`.`list_date`<='".$list_enddate."')
		AND
			`equipment_reservation_list`.`list_disable` = '0'
		ORDER BY 
		  `equipment_reservation_list`.`list_datetime` ASC, 
			`equipment_reservation_list`.`equipment_id`  ASC
		";
	//die($select.$from_DB.$where);
  $pages->setDb($from_DB);

  $array=$pages->select($where, $select);//傳回資料集合二維陣列
  
  /*
   $pages->setDb($from_DB, $where, $select);
  $pages->setPerpage(10,$page);//每頁10筆
  $pages->set_base_page("reservation_list.php?equipment_id=".$equipment_id);
  
  $pages->action_mode("view_equipment_detail");
 //20121110函數要帶入什麼參數;這要給參數,因為要帶?equipment_id參數這樣才能isset($equipment_id)選擇正確
 //20121111代這個參數
  $Firstpage = $pages->getFirstpage3($equipment_id);//第一頁
  //die($Firstpage);
   //$equipment_id,
  $Listpage = $pages->getListpage3($equipment_id,$page,2);//數字:1,2,3....$page點到的頁數
  //die($Listpage);
  
  $Endpage = $pages->getEndpage3($equipment_id);//;//最終頁
   //die($Endpage);
   
  $array = $pages->getData(); //取得內容*/
  
  if(is_array($array))//很重要的陣列判別否則會出錯
  {
    //$returnData["$i"]["$key"] = $value;
    $checklisttime=new processdbcols;//日期顯示的格式在這處理不要到VIEW處理
    foreach($array as $key2=>$value2)//$key2索引值
    {
      
      $timeformat= $checklisttime->equipment_reservation_list_list_endtime($value2['list_endtime'],$value2['list_time'],$value2['advance_end'],$value2['equipment_id'],$value2['list_datetime']);
      //echo "-->".$key2."----".$timeformat; //$value2['list_datetime']
      //使用多列一行
      $timeformatList[$key2]["0"]=$timeformat;//$key2為整數
      
    }
  }
}

//---------------------------------------------------------------------
include(PATH."/view/reservation_list__full_view.php");
/*
//跑左邊的LIST設備名稱
function select_sql($equipment_picture = NULL)
{
	return $a = "
		SELECT *
		FROM `equipment_reservation`
		WHERE 
			`equipment_hidden` = '0'
		AND
			`equipment_disable` = '0'
		".$equipment_picture."
		ORDER BY
			`equipment_reservation`.`equipment_id` ASC
	";
}

$equ_menu_sql = select_sql();
$equ_menu_data = mysql_query($equ_menu_sql) or die(mysql_error());
//跑左邊的LIST設備名稱
*/
?>
