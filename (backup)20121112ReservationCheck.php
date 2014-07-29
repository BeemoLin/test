<?php 
session_start();
header("Content-type: text/xml"); 
header("Cache-Control: no-cache");
$xml = true;
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
echo '<?xml version="1.0" encoding="UTF-8"?>'; 
echo "<response>"; 
if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
	}
}

if(isset($equipment_id) && isset($m_id)){
  if(isset($list_date) && isset($list_time)){
		$sql = "
			SELECT COUNT(*) AS `check_reservation` 
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0' 
				AND `equipment_id` = '".$equipment_id."'
        AND `m_id` = '".$m_id."' 
				AND `list_date` = '".$list_dat."'
				AND `list_time` = '".$list_time."'
		";
    //echo '<sql>'.$sql.'</sql>'; 	
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		//echo '<check_reservation2>'.$data['count_number'].'</check_reservation2>'; 
		echo '<check_reservation2>'.$data['check_reservation'].'</check_reservation2>'; 
    
		$sql = "
			SELECT SUM(`list_using_number`) as `accumulative`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `list_date` = '".$list_date."' 
        AND `list_time` = '".$list_time."' 
		";
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		//echo '<accumulative>'.$sql.'</accumulative>'; 
    if($data['accumulative']==null){
      $data['accumulative']=0;
    }
		echo '<accumulative>'.$data['accumulative'].'</accumulative>'; 
    
		$sql = "
			SELECT count(1) as `count_list`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `list_date` = '".$list_date."' 
        AND `list_time` = '".$list_time."' 
		";
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		//echo '<accumulative>'.$sql.'</accumulative>'; 
    if($data['count_list']==null){
      $data['count_list']=0;
    }
		echo '<count_list>'.$data['count_list'].'</count_list>'; 
		//echo '<sql>'.$sql.'</sql>'; 
  }
  else{
		$sql = "
			SELECT COUNT(*) AS `check_reservation`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `m_id` = '".$m_id."' 
        AND `list_date` = '".$list_date."' 
		";
		//echo '<sql>'.$sql.'</sql>'; 	
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		echo '<check_reservation1>'.$data['check_reservation'].'</check_reservation1>'; 
  }

}
echo "</response>"; 
	  
?>