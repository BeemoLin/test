<?php 
session_start();
header("Content-type: text/xml"); 
header("Cache-Control: no-cache"); 
$xml = true;
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
	if((isset($set_list_date))&&(isset($set_list_time))){
		$list_date=$set_list_date;
		$list_time=$set_list_time;
    
		$sql = "
			SELECT *
			FROM `equipment_reservation` 
			WHERE `equipment_id` = '".$equipment_id."' 
		";
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
    $equipment_exclusive = $data['equipment_exclusive'];
		echo '<equipment_exclusive>'.$equipment_exclusive.'</equipment_exclusive>';  
  
		$sql = "
			SELECT COUNT(*) AS `check_reservation`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `m_id` = '".$m_id."' 
        AND `list_date` = '".$list_date."' 
        AND `list_time` = '".$list_time."' 
		";
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		echo '<check_reservation>'.$data['check_reservation'].'</check_reservation>'; 
		
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
  $sql = "SELECT * FROM `equipment_reservation` WHERE `equipment_id` = '".$equipment_id."' ";
  $returnData = mysql_query($sql);
  $data = mysql_fetch_assoc($returnData);
	//echo '<advance_start>'.$sql.'</advance_start>'; 
	echo '<advance_start>'.$data['advance_start'].'</advance_start>'; 
	echo '<advance_end>'.$data['advance_end'].'</advance_end>'; 
	echo '<equipment_exclusive>'.$data['equipment_exclusive'].'</equipment_exclusive>'; 
	echo '<equipment_max_people>'.$data['equipment_max_people'].'</equipment_max_people>'; 
	}
}
echo "</response>"; 
	  
?>