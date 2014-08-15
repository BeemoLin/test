<?php 
session_start();
header("Content-type: text/xml"); 
header("Cache-Control: no-cache");
$xml = true;
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

define("Gym","1000");
define("PartyRoom","1003");
define("HearCenter","1002");
define("Barbecue","1001");

define("HearRoom","10");
 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 
echo "<response>"; 

/*function CheckUseCount($equipmentid,$listdate){
  //跑步機.....,非專屬預約的公設
  $count="N";//給空值;reservation.js取值會有問題;給N,不屬於跑步機
  switch($equipmentid){
    case Gym:
    case PartyRoom:
    case HearCenter:
      $sql = "SELECT `equipment_max_people` as max,`equipment_id`
              FROM `equipment_reservation`
              WHERE 1
              AND `equipment_id` = '".$equipmentid."'";
    $returndata = mysql_query($sql);
	  $data = mysql_fetch_assoc($returndata);
		$maxpeople=$data['max'];
 
    $sql = "
  			SELECT sum(`list_using_number`) AS cntn
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipmentid."' 
          AND `list_date` = '".$listdate."'";
		  
      $returndata = mysql_query($sql);
	    $data = mysql_fetch_assoc($returndata);
		  $usingpeople=(is_null($data['cntn']))?0:$data['cntn']; 
		   
		  
      $count=$maxpeople-$usingpeople;
		  $count=($count<1)?"nouse":$count;
    
    break;
  
  
  }
  
  
  return $count;
}*/


function GetEquCount($equipmentid){
     $sql = "SELECT `equipment_max_people` as max,`equipment_id`
              FROM `equipment_reservation`
              WHERE 1
              AND `equipment_id` = '".$equipmentid."'";
    $returndata = mysql_query($sql);
	  $data = mysql_fetch_assoc($returndata);
		$maxpeople=$data['max'];
    return $maxpeople;
}

function StaticListEquCount($returnData,$equipment_id,$equipment_endtimemin,$list_startmin,$list_endmin,&$ordered,&$usecount){
    
    $equpeople=(int)GetEquCount($equipment_id);
    $list_endmin=($list_endmin>=$equipment_endtimemin)?$equipment_endtimemin: $list_endmin;
    
    //非專屬預約的公設:時間區段的預約人數統計
    $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin);
    
    if(mysql_num_rows($returnData)>0) {
        while($row = mysql_fetch_assoc($returnData)){//把重疊時段的人數加總,先預約的優先權最高
            $usingcount+=$row["list_using_number"];
        }  
        $usecount=($usingcount>=$equpeople)?"nouse":(string)$equpeople-$usingcount;   
    }else{
        $usecount=(string)$equpeople;
    }
}

function CheckOtherEqu($returnData,$equipment_endtimemin,$list_startmin,$list_endmin,&$ordered,&$usecount){
    //專屬預約的公設:時間區段的預約是否重疊
          $usecount="N"; //不能空值;否則無法顯示(重要)
          if(mysql_num_rows($returnData)>0)  //如果資料筆數出過0，代表有資料
          {
              //XML的變數不要有中文字 且變數不要空白找文字代表意義
              //$ordered="Someone ordered";
              //$i=0;
              //預約總分數:唯一
              //3.比對時間機制
              
              while($row = mysql_fetch_assoc($returnData)){    //有1.排序過時間;所以可以用2.逼近法 3.相等代表無區間
              
                  $matchTime= split(":", $row["list_time"]);
                  $match_startmin=TimetoMin($matchTime[0],$matchTime[1],"+","0");
                  
                  
                  if($row["list_endtime"]=="00:00:00")
                  {
                    $match_endmin=TimetoMin($matchTime[0],$matchTime[1],"+",$matchmin);
                  }
                  else
                  {
                    $matchTime= split(":", $row["list_endtime"]);
                    $match_endmin=TimetoMin($matchTime[0],$matchTime[1],"+","0");
                  }
                 // $sayendtime=$sayendtime."-----".$match_endmin.">>";
                  if($match_startmin<=$list_startmin)
                  {
                      $list_startmin=$match_endmin;
                      if($list_startmin>=$list_endmin){ $flag="N";break;}
                  }
                  /*併到條件式1
                  elseif($match_startmin==$list_startmin)
                  {
                    $flag="N";
                    break; //this time block is same  so break;
                  }*/
                  elseif($match_startmin>$list_startmin)
                  {
                    $list_endmin=$match_startmin;
                    if($list_endmin<=$list_startmin){ $flag="N";break;}
                    break;//201407 by akai
                  }
                  //$ordered=$ordered."start1".$list_startmin."~end1".$list_endmin.">>";
                  //$ordered=$ordered."start2".$list_startmin."~end2".$list_endmin.">>";
              }  
              //---------------------------------------------------------------------------
              if($list_startmin==$list_endmin || $flag=="N")//時間逼近法相等代表無區間
              {
                $ordered="NO";
              }
              else
              {
                // $equipment_endtime check 結束時間
                $list_endmin=($list_endmin>=$equipment_endtimemin)?$equipment_endtimemin: $list_endmin; 
                $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin); 
              }
              
          } 
          else
          {
              // $equipment_endtime check 結束時間
              $list_endmin=($list_endmin>=$equipment_endtimemin)?$equipment_endtimemin: $list_endmin;
              $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin);
          }

}




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
 //1.Define listtime with start~end
function EquUseMin($equipment_id,&$matchmin){

        switch($equipment_id){
          case HearRoom:
            $matchmin=180;
            break;
          case Gym:
          case PartyRoom:
          case HearCenter:
            $matchmin=60;
            break;
          case Barbecue:
            $matchmin=240;
            break;
          default:
            $matchmin=120;
        }
}
function SeekListRecord($equipment_id,$list_date,$list_time,$processTime,&$sql){
    /*-----------------------艾美健身房1小時------------------------------------*/
    /*-----------------------奧斯卡視聽室要3小時--------------------------------*/
    /*-----------------------其他2小時------------------------------------------*/
     switch($equipment_id){
      case HearRoom:
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
  			SELECT *
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."' OR `list_time` = '".$timeblock[7]."' OR `list_time` = '".$timeblock[8]."' OR `list_time` = '".$timeblock[9]."' OR `list_time` = '".$timeblock[10]."')                                 
          ORDER BY list_time ASC
		  ";
      break;
      
      case Gym:
      case PartyRoom:
      case HearCenter:
        $timeblock[0]=$list_time;
		  $sql = "
  			SELECT *
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."')                                 
          ORDER BY list_time ASC
		  ";
      break;
      
      case Barbecue:
          $timeblock[0]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","60"));
       
          $timeblock[1]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","120"));
          
          $timeblock[2]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","180"));
          
          $timeblock[3]=$list_time;
          
          $timeblock[4]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","60"));
          
          $timeblock[5]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","120"));
          
          $timeblock[6]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","180"));
          
  		  $sql = "
    			SELECT *
    			FROM `equipment_reservation_list` 
    			WHERE `list_disable` = '0'
            AND `equipment_id` = '".$equipment_id."' 
            AND `list_date` = '".$list_date."' 
            AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."')                                 
            ORDER BY list_time ASC
  		  ";
  		  break;
      
      
      default:
         $timeblock[0]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","30"));
   
        $timeblock[1]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","60"));
        
        $timeblock[2]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"-","90"));
        
        $timeblock[3]=$list_time;
        
        $timeblock[4]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","30"));
        
        $timeblock[5]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","60"));
        
        $timeblock[6]=TimeToHourMinSec(TimetoMin($processTime[0],$processTime[1],"+","90"));
      
  			$sql = "
  			SELECT *
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."')
          ORDER BY list_time ASC
  		";
      }

}



//POST Submit
if(!empty($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
	}
}

if(isset($equipment_id) && isset($m_id)){
  if(isset($list_date) && isset($list_time)){     //時間的CHECK
      
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
		//$returnData = mysql_query($sql);
		//$data = mysql_fetch_assoc($returnData);
		//$data['check_reservation']
		
		//echo '<check_reservation2>'.$data['count_number'].'</check_reservation2>'; 
		echo '<check_reservation2>""</check_reservation2>'; 
		$sql = "
			SELECT SUM(`list_using_number`) as `accumulative`
			FROM `equipment_reservation_list` 
			WHERE `list_disable` = '0'
        AND `equipment_id` = '".$equipment_id."' 
        AND `list_date` = '".$list_date."' 
        AND `list_time` = '".$list_time."' 
		";
		//$returnData = mysql_query($sql);
		//$data = mysql_fetch_assoc($returnData);
		//$data['accumulative']
		echo '<sqlb>'.$sql.'</sqlb>'; //** 
    /*
    if($data['accumulative']==null)
    {
      $data['accumulative']=0;
    }
    */
  	echo '<accumulative>""</accumulative>'; 
    
    
    //20121120 ADD equipment end time
    	$sql = "
			SELECT advance_end AS `equipment_endtime` 
			FROM `equipment_reservation` 
			WHERE `equipment_disable` = '0' 
				AND `equipment_id` = '".$equipment_id."'
		";
  
		$returnData = mysql_query($sql);
		if(mysql_num_rows($returnData)>0){  
		  	$data = mysql_fetch_assoc($returnData);
		    $equipment_endtime=$data['equipment_endtime'];
		}
		else{
        $equipment_endtime="23:00:00";
    }
    $processTime=split(":", $equipment_endtime); 
    $equipment_endtimemin=TimetoMin($processTime[0],$processTime[1],"+","0");
    
		//echo '<equipment_endtime>'.$equipment_endtimemin.'</equipment_endtime>'; 
    //20121120 ADD equipment end time
    
  
    $processTime= split(":", $list_time); //訂票時間
    
    SeekListRecord($equipment_id,$list_date,$list_time,$processTime,$sql);
    
		$returnData = mysql_query($sql);  
	  // $data = mysql_fetch_assoc($returnData);	//return Arrary;index with string not int
       
        EquUseMin($equipment_id,$matchmin);
        $list_startmin= TimetoMin($processTime[0],$processTime[1],"+","0");
        $list_endmin=TimetoMin($processTime[0],$processTime[1],"+",$matchmin);
        
        //$ordered=$list_startmin."~".$list_endmin."@@".$matchmin;
    
    
    switch($equipment_id){
      case Gym:
      case PartyRoom:
      case HearCenter:
      case Barbecue:
        //非專屬預約:人數統計
         StaticListEquCount($returnData,$equipment_id,$equipment_endtimemin,$list_startmin,$list_endmin,$ordered,$usecount);
      break;
      
      default:
        //專屬預約:判斷區間是否重疊
        CheckOtherEqu($returnData,$equipment_endtimemin,$list_startmin,$list_endmin,$ordered,$usecount);
    }
                        
     
    
    

    echo '<ordered>'.$ordered.'</ordered>';
    
    echo '<usecount>'.$usecount.'</usecount>';
    
    //echo '<equipmentid>'.$equipment_id.'</equipmentid>';
    
		//echo '<sqlc>'.$sql.'</sqlc>';
    //echo '<count_list>112222222</count_list>';//統計的數量
    	
    /*
    if($data['count_list']==null)
    {
      $data['count_list']=0;
    }
		echo '<count_list>'.$data['count_list'].'</count_list>';//統計的數量
		*/
		
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
