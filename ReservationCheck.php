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
  //�]�B��.....,�D�M�ݹw�������]
  $count="N";//���ŭ�;reservation.js���ȷ|�����D;��N,���ݩ�]�B��
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
    
    //�D�M�ݹw�������]:�ɶ��Ϭq���w���H�Ʋέp
    $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin);
    
    if(mysql_num_rows($returnData)>0) {
        while($row = mysql_fetch_assoc($returnData)){//�⭫�|�ɬq���H�ƥ[�`,���w�����u���v�̰�
            $usingcount+=$row["list_using_number"];
        }  
        $usecount=($usingcount>=$equpeople)?"nouse":(string)$equpeople-$usingcount;   
    }else{
        $usecount=(string)$equpeople;
    }
}

function CheckOtherEqu($returnData,$equipment_endtimemin,$list_startmin,$list_endmin,&$ordered,&$usecount){
    //�M�ݹw�������]:�ɶ��Ϭq���w���O�_���|
          $usecount="N"; //����ŭ�;�_�h�L�k���(���n)
          if(mysql_num_rows($returnData)>0)  //�p�G��Ƶ��ƥX�L0�A�N�����
          {
              //XML���ܼƤ��n������r �B�ܼƤ��n�ťէ��r�N��N�q
              //$ordered="Someone ordered";
              //$i=0;
              //�w���`����:�ߤ@
              //3.���ɶ�����
              
              while($row = mysql_fetch_assoc($returnData)){    //��1.�ƧǹL�ɶ�;�ҥH�i�H��2.�G��k 3.�۵��N��L�϶�
              
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
                  /*�֨����1
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
              if($list_startmin==$list_endmin || $flag=="N")//�ɶ��G��k�۵��N��L�϶�
              {
                $ordered="NO";
              }
              else
              {
                // $equipment_endtime check �����ɶ�
                $list_endmin=($list_endmin>=$equipment_endtimemin)?$equipment_endtimemin: $list_endmin; 
                $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin); 
              }
              
          } 
          else
          {
              // $equipment_endtime check �����ɶ�
              $list_endmin=($list_endmin>=$equipment_endtimemin)?$equipment_endtimemin: $list_endmin;
              $ordered= TimeToHourMinSec($list_startmin)."~".TimeToHourMinSec($list_endmin);
          }

}




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
    /*-----------------------���������1�p��------------------------------------*/
    /*-----------------------�����d��ť�ǭn3�p��--------------------------------*/
    /*-----------------------��L2�p��------------------------------------------*/
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
  if(isset($list_date) && isset($list_time)){     //�ɶ���CHECK
      
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
    
  
    $processTime= split(":", $list_time); //�q���ɶ�
    
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
        //�D�M�ݹw��:�H�Ʋέp
         StaticListEquCount($returnData,$equipment_id,$equipment_endtimemin,$list_startmin,$list_endmin,$ordered,$usecount);
      break;
      
      default:
        //�M�ݹw��:�P�_�϶��O�_���|
        CheckOtherEqu($returnData,$equipment_endtimemin,$list_startmin,$list_endmin,$ordered,$usecount);
    }
                        
     
    
    

    echo '<ordered>'.$ordered.'</ordered>';
    
    echo '<usecount>'.$usecount.'</usecount>';
    
    //echo '<equipmentid>'.$equipment_id.'</equipmentid>';
    
		//echo '<sqlc>'.$sql.'</sqlc>';
    //echo '<count_list>112222222</count_list>';//�έp���ƶq
    	
    /*
    if($data['count_list']==null)
    {
      $data['count_list']=0;
    }
		echo '<count_list>'.$data['count_list'].'</count_list>';//�έp���ƶq
		*/
		
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
