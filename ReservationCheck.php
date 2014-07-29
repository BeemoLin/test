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

function CheckUseCount($equipmentid,$listdate){
  //跑步機
  $count="N";//給空值;reservation.js取值會有問題;給N,不屬於跑步機
  if($equipmentid=="1000"){
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
  }
  return $count;
}


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

function CheckEquRunMachine($returnData,$equipment_id,$equipment_endtimemin,$list_startmin,$list_endmin,&$ordered,&$usecount){
    
    $equpeople=(int)GetEquCount($equipment_id);
    $list_endmin=($list_endmin>=$equipment_endtimemin)?$equipment_endtimemin: $list_endmin;
    $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin);
    
    if(mysql_num_rows($returnData)>0) {
        while($row = mysql_fetch_assoc($returnData)){//把重疊時段的人數加總,先預約的優先權最高
            $usingcount+=$row["list_using_number"];
        }  
        //---------------------------------------------------------------------------
        
        $usecount=($usingcount>=$equpeople)?"nouse":(string)$equpeople-$usingcount;
        
        /*if($usingcount>=$equpeople){

          $usecount="nouse"; //不能空值;否則無法顯示(重要)
        }
        else{
          $usecount=$equpeople-$usingcount;
        }*/
        
    }else{
        $usecount=(string)$equpeople;
    }
}

function CheckOtherEqu($returnData,$equipment_endtimemin,$list_startmin,$list_endmin,&$ordered,&$usecount){
          
          $usecount="N"; //不能空值;否則無法顯示(重要)
          if(mysql_num_rows($returnData)>0)  //如果資料筆數出過0，代表有資料
          {
              //XML的變數不要有中文字 且變數不要空白找文字代表意義
              //$ordered="Someone ordered";
              //$i=0;
              //預約總分數:唯一
              //3.比對時間機制
              
              while($row = mysql_fetch_assoc($returnData))//有1.排序過時間;所以可以用2.逼近法 3.相等代表無區間
              {
                  //寫成一個FUNCTION
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
//ADD 20121120
function ListEndtimeCheck()
{
//listendtime equipment end time


}

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
		if(mysql_num_rows($returnData)>0)  //如果資料筆數出過0，代表有資料
    {
		  	$data = mysql_fetch_assoc($returnData);
		    $equipment_endtime=$data['equipment_endtime'];
		}
		else
		{
        $equipment_endtime="23:00:00";
    }
    $processTime=split(":", $equipment_endtime); 
    $equipment_endtimemin=TimetoMin($processTime[0],$processTime[1],"+","0");
    
		//echo '<equipment_endtime>'.$equipment_endtimemin.'</equipment_endtime>'; 
    //20121120 ADD equipment end time
    
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
   /*
      	$sql = "
  			SELECT count(1) as `count_list`
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."' OR `list_time` = '".$timeblock[7]."' OR `list_time` = '".$timeblock[8]."' OR `list_time` = '".$timeblock[9]."' OR `list_time` = '".$timeblock[10]."')                                 
        
		  ";
		   */ 
		  $sql = "
  			SELECT *
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."' OR `list_time` = '".$timeblock[7]."' OR `list_time` = '".$timeblock[8]."' OR `list_time` = '".$timeblock[9]."' OR `list_time` = '".$timeblock[10]."')                                 
          ORDER BY list_time ASC
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
      
      /*
      	$sql = "
  			SELECT count(1) as `count_list`
  			FROM `equipment_reservation_list` 
  			WHERE `list_disable` = '0'
          AND `equipment_id` = '".$equipment_id."' 
          AND `list_date` = '".$list_date."' 
          AND (`list_time` = '".$timeblock[0]."' OR `list_time` = '".$timeblock[1]."' OR `list_time` = '".$timeblock[2]."' OR `list_time` = '".$timeblock[3]."' OR `list_time` = '".$timeblock[4]."' OR `list_time` = '".$timeblock[5]."' OR `list_time` = '".$timeblock[6]."')
          
  		";
  			*/
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
	
	
		$returnData = mysql_query($sql);  //return True Or False
	
	 // $data = mysql_fetch_assoc($returnData);	//return Arrary;index with string not int
    
    //20121120 ADD CHECK 
    //未增加預約結束時間,不過應該
		//不行 因為有取消的機制會使時段取消  13:30:00~16:30:00(取消)  16:30~18:00:00(所以訂16:30 要顯示18:00~19:30
        
        //1.Define listtime with start~end
        $matchmin=($equipment_id=="10")?180:120;
        
        $list_startmin= TimetoMin($processTime[0],$processTime[1],"+","0");
        $list_endmin=TimetoMin($processTime[0],$processTime[1],"+",$matchmin);
        
        //$ordered=$list_startmin."~".$list_endmin."@@".$matchmin;
    
  
    if($equipment_id=="1000"){
      CheckEquRunMachine($returnData,$equipment_id,$equipment_endtimemin,$list_startmin,$list_endmin,$ordered,$usecount);
    }else{
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
