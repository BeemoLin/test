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
//�]���ϥ�POST Submit;�ҥH�ϥ�$_POST����
if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
	}
}

if(isset($equipment_id) && isset($m_id))
{
  if(isset($list_date) && isset($list_time))//�ɶ���CHECK
  {
		$sql = "
			SELECT COUNT(*) AS `check_reservation` 
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0' 
				AND `equipment_id` = '".$equipment_id."'
        AND `m_id` = '".$m_id."' 
				AND `list_date` = '".$list_dat."'
				AND `list_time` = '".$list_time."'
		";
    echo '<sqla>'.$sql.'</sqla>'; //**	
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
		echo '<sqlb>'.$sql.'</sqlb>'; //** 
    if($data['accumulative']==null)
    {
      $data['accumulative']=0;
    }
		echo '<accumulative>'.$data['accumulative'].'</accumulative>'; 
    
    
    
    /*-----------------------�����d��ť�ǭn3�p��--------------------------------*/
    /*-----------------------��L2�p��--------------------------------*/
    $processTime= split(":", $list_time); //�q���ɶ�
    
    //�n�}�}�C�X�ӻ�
    /*
    $my_array = array("Dog","Cat","Horse");
    list($a, $b, $c) = $my_array;
    echo "I have several animals, a $a, a $b and a $c.";
    */
    //$blocktime=strtotime("now");//"+1 hours",$list_time
    //�Q�@��FUNCTION(���ܦ����/)
    
   
    

function TimetoMin($hour,$min,$spot,$addorsubmin) //return ����
{
  
  switch($spot)
  {
    case "+":
      $totalMin=((int)$hour*60+(int)$min+(int)$addorsubmin>=1440)?1440:(int)$hour*60+(int)$min+(int)$addorsubmin;  //�۴�i�H�P�O��24�I �Ȯɤ���
    break;

    case "-":
      $totalMin=((int)$hour*60+(int)$min-(int)$addorsubmin<=480)?480:(int)$hour*60+(int)$min-(int)$addorsubmin;    //�۴�i�H�P�O��8�I �Ȯɤ���
    break;

  }
  return $totalMin;
  
}

 
function TimeToHourMinSec($totalmin) //return �ɶ��榡 �r��
{
  //---------�૬--------
  
  $hour=(int)($totalmin/60);//(int)3.9;
  $Hour=($hour<10)?"0".(string)$hour:(string)$hour;
  
  $min=(int)$totalmin % 60;
  $Min=($min<10)?"0".(string)$min:(string)$min;

  $Sec="00";
  
  return $Hour.":".$Min.":".$Sec;
  
}
    //�����d��ť�ǭn3�p��
    if($equipment_id=="10")
    {
        $timeblock[0]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","30"));
       
        $timeblock[1]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","60"));
        
        $timeblock[2]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","90"));
         
        $timeblock[3]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","120"));
        
        $timeblock[4]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","150"));
        
        $timeblock[5]=$list_time;
        
        $timeblock[6]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","30"));
        
        $timeblock[7]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","60"));
        
        $timeblock[8]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","90"));
        
        $timeblock[9]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","120"));
         
        $timeblock[10]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","150"));
    
      	$sql = "
  			SELECT count(1) as `count_list`
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."' OR `list_time` = '".$timeblock[7]."' OR `list_time` = '".$timeblock[8]."' OR `list_time` = '".$timeblock[9]."' OR `list_time` = '".$timeblock[10]."')                                 
        
		  ";
    }
    //��L��p��
    else
    {
      $timeblock[0]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","30"));
   
      $timeblock[1]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","60"));
      
      $timeblock[2]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","90"));
      
      $timeblock[3]=$list_time;
      
      $timeblock[4]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","30"));
      
      $timeblock[5]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","60"));
      
      $timeblock[6]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","90"));
      	$sql = "
  			SELECT count(1) as `count_list`
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."')
          
  		";
    }
  
    
    
    /*
    $timeblock[0]=TimetoMin($processTime[0],$processTime[1],"-","30");
   
    $timeblock[1]=TimetoMin($processTime[0],$processTime[1],"-","60");
    
    $timeblock[2]=TimetoMin($processTime[0],$processTime[1],"-","90");
    
    $timeblock[3]=$list_time;
    
    $timeblock[4]=TimetoMin($processTime[0],$processTime[1],"+","30");
    
    $timeblock[5]=TimetoMin($processTime[0],$processTime[1],"+","60");
    
    $timeblock[6]=TimetoMin($processTime[0],$processTime[1],"+","90");
    */
    
    
    
    
    //foreach�}�C���j�n��
   /*
    foreach($timeblock as $tindex=>$tvalue)
    {
      echo '<blocktime>'.$tindex."::".$tvalue.'</blocktime>';
    }
    */
    
    
    /*
    $preTime=$processTime[0]-1;
    $strpreTime=($preTime<10)?"0".(string)$preTime.":00:00":(string)$preTime.":00:00";
    $endTime=$processTime[0]+1;
    $strendTime=($endTime<10)?"0".(string)$endTime.":00:00":(string)$endTime.":00:00";
    
 
  
		$sql = "
			SELECT count(1) as `count_list`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `list_date` = '".$list_date."' 
        AND (`list_time` = '".$strpreTime."' OR `list_time` = '".$list_time."' OR `list_time` = '".$strendTime."')
        
		";
		*/
	
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		echo '<sqlc>'.$sql.'</sqlc>';
    if($data['count_list']==null)
    {
      $data['count_list']=0;
    }

		echo '<count_list>'.$data['count_list'].'</count_list>';
    //echo '<accumulative>'.$sql.'</accumulative>';   
		//echo '<sql>'.$sql.'</sql>'; 
  }
  else //�����CHECK:check_reservation>0�N������ ==0�N��L����
  {
		$sql = "
			SELECT COUNT(*) AS `check_reservation`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `m_id` = '".$m_id."' 
        AND `list_date` = '".$list_date."' 
		";
		echo '<sql>'.$sql.'</sql>';  //**	
		$returnData = mysql_query($sql);
		$data = mysql_fetch_assoc($returnData);
		echo '<check_reservation1>'.$data['check_reservation'].'</check_reservation1>'; 
  }

}
echo "</response>"; 
	  
?>
