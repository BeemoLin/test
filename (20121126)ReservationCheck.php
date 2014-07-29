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
//因為使用POST Submit;所以使用$_POST取值
if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
	}
}

if(isset($equipment_id) && isset($m_id))
{
  if(isset($list_date) && isset($list_time))//時間的CHECK
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
    
    
    
    /*-----------------------奧斯卡視聽室要3小時--------------------------------*/
    /*-----------------------其他2小時--------------------------------*/
    $processTime= split(":", $list_time); //訂票時間
    
    //要開陣列出來麼
    /*
    $my_array = array("Dog","Cat","Horse");
    list($a, $b, $c) = $my_array;
    echo "I have several animals, a $a, a $b and a $c.";
    */
    //$blocktime=strtotime("now");//"+1 hours",$list_time
    //想一個FUNCTION(都變成秒數/)
    
   
    

function TimetoMin($hour,$min,$spot,$addorsubmin) //return 分鐘
{
  
  switch($spot)
  {
    case "+":
      $totalMin=((int)$hour*60+(int)$min+(int)$addorsubmin>=1440)?1440:(int)$hour*60+(int)$min+(int)$addorsubmin;  //相減可以判別ˋ24點 暫時不用
    break;

    case "-":
      $totalMin=((int)$hour*60+(int)$min-(int)$addorsubmin<=480)?480:(int)$hour*60+(int)$min-(int)$addorsubmin;    //相減可以判別ˋ8點 暫時不用
    break;

  }
  return $totalMin;
  
}

 
function TimeToHourMinSec($totalmin) //return 時間格式 字串
{
  //---------轉型--------
  
  $hour=(int)($totalmin/60);//(int)3.9;
  $Hour=($hour<10)?"0".(string)$hour:(string)$hour;
  
  $min=(int)$totalmin % 60;
  $Min=($min<10)?"0".(string)$min:(string)$min;

  $Sec="00";
  
  return $Hour.":".$Min.":".$Sec;
  
}
    //奧斯卡視聽室要3小時
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
    //其他兩小時
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
    
    
    
    
    //foreach陣列巡迴好用
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
  else //日期的CHECK:check_reservation>0代表有筆數 ==0代表無筆數
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
