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
  //�]�B��
  $count="N";//���ŭ�;reservation.js���ȷ|�����D;��N,���ݩ�]�B��
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
        while($row = mysql_fetch_assoc($returnData)){//�⭫�|�ɬq���H�ƥ[�`,���w�����u���v�̰�
            $usingcount+=$row["list_using_number"];
        }  
        //---------------------------------------------------------------------------
        
        $usecount=($usingcount>=$equpeople)?"nouse":(string)$equpeople-$usingcount;
        
        /*if($usingcount>=$equpeople){

          $usecount="nouse"; //����ŭ�;�_�h�L�k���(���n)
        }
        else{
          $usecount=$equpeople-$usingcount;
        }*/
        
    }else{
        $usecount=(string)$equpeople;
    }
}

function CheckOtherEqu($returnData,$equipment_endtimemin,$list_startmin,$list_endmin,&$ordered,&$usecount){
          
          $usecount="N"; //����ŭ�;�_�h�L�k���(���n)
          if(mysql_num_rows($returnData)>0)  //�p�G��Ƶ��ƥX�L0�A�N�����
          {
              //XML���ܼƤ��n������r �B�ܼƤ��n�ťէ��r�N��N�q
              //$ordered="Someone ordered";
              //$i=0;
              //�w���`����:�ߤ@
              //3.���ɶ�����
              
              while($row = mysql_fetch_assoc($returnData))//��1.�ƧǹL�ɶ�;�ҥH�i�H��2.�G��k 3.�۵��N��L�϶�
              {
                  //�g���@��FUNCTION
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
//ADD 20121120
function ListEndtimeCheck()
{
//listendtime equipment end time


}

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
		if(mysql_num_rows($returnData)>0)  //�p�G��Ƶ��ƥX�L0�A�N�����
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
	
	
		$returnData = mysql_query($sql);  //return True Or False
	
	 // $data = mysql_fetch_assoc($returnData);	//return Arrary;index with string not int
    
    //20121120 ADD CHECK 
    //���W�[�w�������ɶ�,���L����
		//���� �]��������������|�Ϯɬq����  13:30:00~16:30:00(����)  16:30~18:00:00(�ҥH�q16:30 �n���18:00~19:30
        
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
