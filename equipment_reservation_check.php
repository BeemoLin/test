<?php
/*
20121117 資料表增加攔位:`list_endtime` = '".$list_endtime."', 
*/
require_once('define.php'); 
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/PHPMailer/class.phpmailer.php');


define("PartyRoom","1003");
define("HearCenter","1002");

//require('system/PHPMailer_v5.1/class.phpmailer.php');

//201407 by akai 增加更新人數
function UpdateEquipmentCount($people,$connSQL){
$id=1;
$query = "
UPDATE
	`equipment_reservation`
SET 
	`equipment_count` = `equipment_count`+".$people." 
	 WHERE `equipment_reservation`.`equipment_id` =".$id;
	 mysql_query($query, $connSQL) or die(mysql_error());
}

$logoutAction = 'logout.php';

//取HTML物件值 $_GET 或 $_POST 因為add_reservation method=get GET也可以取物件的內容值 不過有大小限制
if(isset($_GET)){
	foreach($_GET as $key => $value){
		$$key = $value;
		echo '$'.$key.'='.$value."<br />\n";
	}
}
//取HTML物件值
$m_id = $_SESSION['MM_UserID'];
$m_user = $_SESSION['MM_Username'];


if (empty($equipment_id) || empty($set_list_date) || empty($set_list_time)){
	header('Location:reservation.php');
	exit();
}
$equipment_query = "
SELECT * 
FROM `equipment_reservation`
WHERE `equipment_id` = ".$equipment_id."
";
$get_equipment_name_data = mysql_fetch_assoc(mysql_query($equipment_query, $connSQL)) or die(mysql_error());
$equipment_name = $get_equipment_name_data['equipment_name'];
$max_people = $get_equipment_name_data['equipment_max_people'];



if($equipment_exclusive == "1"){
/*
$query = "
INSERT INTO 
	`equipment_reservation_list`
SET 
	`equipment_id` = ".$equipment_id.", 
	`list_date` = '".$set_list_date."', 
	`list_time` = '".$set_list_time."', 
	`list_datetime` = '".$set_list_date." ".$set_list_time."', 
	`save_datetime` = NOW(), 
	`m_id` = ".$m_id.", 
	`list_using_number` = ".$max_people."
";
*/
//20121117
$query = "
INSERT INTO 
	`equipment_reservation_list`
SET 
	`equipment_id` = ".$equipment_id.", 
	`list_date` = '".$set_list_date."', 
	`list_time` = '".$set_list_time."', 
	`list_endtime` = '".$list_endtime."', 
	`list_datetime` = '".$set_list_date." ".$set_list_time."', 
	`save_datetime` = NOW(), 
	`m_id` = ".$m_id.", 
	`list_using_number` = '1'
";
}
elseif($equipment_exclusive == "0")
{
//$equipment_max_people="1";
//UpdateEquipmentCount($equipment_max_people,$connSQL);
$query = "
INSERT INTO 
	`equipment_reservation_list`
SET 
	`equipment_id` = ".$equipment_id.", 
	`list_date` = '".$set_list_date."', 
	`list_time` = '".$set_list_time."', 
	`list_endtime` = '".$list_endtime."', 
	`list_datetime` = '".$set_list_date." ".$set_list_time."', 
	`save_datetime` = NOW(), 
	`m_id` = ".$m_id.", 
	`list_using_number` = ".$equipment_max_people."
";
}
$Recordset = mysql_query($query, $connSQL) or die(mysql_error());

//同時預約兩個設備

if($equipment_id==HearCenter || $equipment_id==PartyRoom)
{
  $eq_id=($equipment_id==HearCenter)?PartyRoom:HearCenter;
  
  $query = "
    INSERT INTO 
      `equipment_reservation_list`
    SET 
      `equipment_id` = ".$eq_id.", 
      `list_date` = '".$set_list_date."', 
      `list_time` = '".$set_list_time."', 
      `list_endtime` = '".$list_endtime."', 
      `list_datetime` = '".$set_list_date." ".$set_list_time."', 
      `save_datetime` = NOW(), 
      `m_id` = ".$m_id.", 
      `list_using_number` = ".$equipment_max_people."
  ";

$Recordset = mysql_query($query, $connSQL) or die(mysql_error());
}
    
    //-----信件發送
    $query = "SELECT * FROM adminuser WHERE `allname`='公設預約通知名單'";
    $result = mysql_query($query, $connSQL) or die(mysql_error());
    $list = mysql_fetch_array($result);
		//$message = file_get_contents(EMAIL_TEMPLATES.'/order_notice.html');  //舊資料的位置
		$message = file_get_contents(INCLUDES.'/Email_templates/reservation.html');
/*信件格式使用取代字串
[c_subject]「公設預約通知」 
住戶代號： [username] 
預約設備： [name] 
預約日期： [date] 
預約時段： [time] 
*/
  /*
  例子 1
echo str_replace("world","John","Hello world!");
(1.find,2.replace,3.str)
Hello John!
  */
		$message = str_replace('[c_subject]', 	C_SUBJECT, $message);//填入表格中
		$message = str_replace('[username]',	$m_user, $message);
		$message = str_replace('[name]', 		$equipment_name, $message);
		$message = str_replace('[date]', 		$set_list_date, $message);
		$message = str_replace('[time]', 		$list_time_format, $message);//$set_list_time
    
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
		$mail->Subject = C_SUBJECT."".$m_user.' 公設預約通知';
		$mail->MsgHTML($message);
		//$mail->AltBody(strip_tags($message));
		if(!$mail->Send()) 
    {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
    //信件發送
    header("Location: reservation.php");
    exit();

?>


