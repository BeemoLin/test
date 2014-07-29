<?php
require_once('define.php'); 
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/PHPMailer/class.phpmailer.php');
//require('system/PHPMailer_v5.1/class.phpmailer.php');
$logoutAction = 'logout.php';


if(isset($_GET)){
	foreach($_GET as $key => $value){
		$$key = $value;
		echo '$'.$key.'='.$value."<br />\n";
	}
}
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
	`list_using_number` = '1'
";
}
elseif(($equipment_exclusive == "0")){
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
	`list_using_number` = ".$equipment_max_people."
";
}

$Recordset = mysql_query($query, $connSQL) or die(mysql_error());

    $query = "SELECT * FROM adminuser WHERE `allname`='公設預約通知名單'";
    $result = mysql_query($query, $connSQL) or die(mysql_error());
    $list = mysql_fetch_array($result);
		//$message = file_get_contents(EMAIL_TEMPLATES.'/order_notice.html');  //舊資料的位置
		$message = file_get_contents(INCLUDES.'/Email_templates/reservation.html');

		$message = str_replace('[c_subject]', 	C_SUBJECT, $message);
		$message = str_replace('[username]',	$m_user, $message);
		$message = str_replace('[name]', 		$equipment_name, $message);
		$message = str_replace('[date]', 		$set_list_date, $message);
		$message = str_replace('[time]', 		$set_list_time, $message);

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
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}

    header("Location: reservation.php");
    exit();

?>


