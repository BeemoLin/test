<?php
/*
20121114:1.訂約記錄的表格使用UPDATE,不使用DEL
        2.當取消的時候要判別是在ALL或在PART



20121116:增加取消的時候 信件預約時段內容修改程 幾點~幾點

*/
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/PHPMailer/class.phpmailer.php');


define("PartyRoom","1003");
define("HearCenter","1002");

//PartyRoom,HearCenter 連動取消機制
function UpdatePartyRoomOrHearCenter($data_function,$equipment_id,$list_datetime){
   switch($equipment_id){
    
     
      case PartyRoom:
      case HearCenter:
        $seekequid=($equipment_id==PartyRoom)?HearCenter:PartyRoom;

        $data_function->setDb('`equipment_reservation_list`');
        $select_expression = "`equipment_reservation_list`.*";
        $where_expression = "AND `equipment_id` = '".$seekequid."' AND `list_datetime`='".$list_datetime."' AND	`list_disable`='0'";
        $data = $data_function->select($where_expression,$select_expression);
        
        $list_id=$data[1]['list_id'];
        
        $data_function->setDb('`equipment_reservation_list`');
        $update_expression="`list_disable` = '1'";
        $where_expression = "AND `list_id` = '".$list_id."'";
        $data_function->update($where_expression,$update_expression);
        
        
        
        break;
    
      default:              
       
    } 
}
//GET中文名稱
function GetPartyRoomOrHearCenterName($data_function,$equipment_id){
   switch($equipment_id){
    
     
      case PartyRoom:
      case HearCenter:
        $seekequid=($equipment_id==PartyRoom)?HearCenter:PartyRoom;

        $data_function->setDb('`equipment_reservation`');
        $select_expression = "`equipment_reservation`.*";
        $where_expression = "AND `equipment_id` = '".$seekequid."'";
        $data = $data_function->select($where_expression,$select_expression); 
        $equname="/".$data[1]['equipment_name'];
        break;
    
      default:              
        $equname="";
    } 
    return $equname;
}




//----使用POST submit方式
if(isset($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}

$action_mode = 'update_equipment_check';


$data_function = new data_function;
//20121116:增加撈出設備的結束時間
$data_function->setDb('`equipment_reservation_list` LEFT JOIN `equipment_reservation` ON `equipment_reservation_list`.`equipment_id`=`equipment_reservation`.`equipment_id`');
$select_expression = "`equipment_reservation_list`.*,`equipment_reservation`.`equipment_name`,`equipment_reservation`.`advance_end`";
$where_expression = "AND `list_id` = '".$list_id."'";
$getdata = $data_function->select($where_expression,$select_expression);


//-------------------資料集為二為陣列-只會有一筆訂約記錄------------------------
foreach($getdata as $key1 => $value1)
{
  foreach($value1 as $key2 => $value2)
  {
    echo '$getdata['.$key1.']['.$key2.']='.$value2."<br>\n";
  }
}
//-------------------資料集為二為陣列-只會有一筆記錄------------------------

//-------------------輸出各項資訊-----------------------
echo '$equipment_name:';
echo $equipment_name = $getdata[1]['equipment_name'];
echo "<br>\n";
echo '$list_date:';
echo $list_date = $getdata[1]['list_date'];
echo "<br>\n";
echo '$list_time:';
echo $list_time = $getdata[1]['list_time'];
echo "<br>\n";
//20121120增加預約結束時間
echo '$list_endtime:';
echo $list_endtime = $getdata[1]['list_endtime'];
echo "<br>\n";

//20121116:增加區間時間 包成一個FUNCTION
echo '$equipment_num:';
echo $equipment_num = $getdata[1]['equipment_id'];
echo "<br>\n";
echo '設備結束時間:';
echo $equipment_endtime = $getdata[1]['advance_end'];
echo "<br>\n";
//-------------------輸出各項資訊-----------------------






list($listhour, $listmin, $listsec) = split(':', $list_time); //好用的技巧

if($list_endtime=="00:00:00")//攔位新增
{
  list($endhour, $endmin, $endsec) = split(':', $equipment_endtime);
   
  if($equipment_num=="10")//奧斯卡視聽室
  {
    $showhour=((int)$listhour+3>=(int)$endhour)?(int)$endhour:(int)$listhour+3;
    $showhour=((int)$showhour<10)?"0".(string)$showhour:(string)$showhour;
    $showmin=((int)$listhour+3>=(int)$endhour)?"00":$listmin;
  }
  else
  {
    $showhour=((int)$listhour+2>=(int)$endhour)?(int)$endhour:(int)$listhour+2;
    $showhour=((int)$showhour<10)?"0".(string)$showhour:(string)$showhour;
    $showmin=((int)$listhour+2>=(int)$endhour)?"00":$listmin;
  }
  $showsec="00";
  $timeformat=$list_time."~".$showhour.":".$showmin.":".$showsec;
}
else
{

 $timeformat=$list_time."~".$list_endtime;


}
//20121116:增加區間時間



//-------------------輸出各項資訊-----------------------

//-------------寄信用---------------
    $m_id = $_SESSION['MM_UserID'];
    $m_user = $_SESSION['MM_Username'];
    $query = "SELECT * FROM adminuser WHERE `allname`='公設預約通知名單'";

    $result = mysql_query($query, $connSQL) or die(mysql_error());
    $list = mysql_fetch_array($result);
		//$message = file_get_contents(EMAIL_TEMPLATES.'/order_notice.html');  //舊資料的位置
		$message = file_get_contents(INCLUDES.'/Email_templates/reservation_cancel.html');

		$message = str_replace('[c_subject]', 	C_SUBJECT, $message);
		$message = str_replace('[username]',	$m_user, $message);
		
		
		 
		$message = str_replace('[name]', 		$equipment_name.GetPartyRoomOrHearCenterName($data_function,$equipment_id), $message);
		$message = str_replace('[date]', 		$list_date, $message);
		$message = str_replace('[time]', 		$timeformat, $message);//$list_time
    //die($message);

  
		// Setup PHPMailer
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = 'msa.hinet.net';
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64"; // is this necessary?
		$mail->SetFrom('service.tcwa@hinet.net', C_SUBJECT);

		$mailto= explode(',', $list['mail']);
		foreach ($mailto as $mrs){
			$mail->AddAddress($mrs);
		}
		$mail->Subject = C_SUBJECT."".$m_user.' 取消公設預約通知';
		$mail->MsgHTML($message);
		//$mail->AltBody(strip_tags($message));
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
		

//-------------寄信用---------------
//20121114 改成更新



$data_function->setDb('`equipment_reservation_list`');
//$data_function->delete($where_expression); //---------------前台有刪除資料-------------------考慮是否要用update的方式
//20121114 改成更新
$update_expression="`list_disable` = '1'";
$data_function->update($where_expression,$update_expression);


UpdatePartyRoomOrHearCenter($data_function,$equipment_id,$list_date." ".$list_time);


//20121114
if($type=="PART")
{
  //die("PART");
  header("location: reservation_list.php?equipment_id=".$equipment_id);//轉址
}
else
{
  //die("ALL");
  header("location: reservation_list.php");//轉址
}
?>
