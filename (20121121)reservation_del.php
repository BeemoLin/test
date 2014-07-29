<?php
/*
20121114:1.訂約記錄的表格使用UPDATE,不使用DEL
        2.當取消的時候要判別是在ALL或在PART





*/
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/PHPMailer/class.phpmailer.php');

if(isset($_POST)){
	foreach($_POST as $key => $value){
		$$key = $value;
		//echo '$'.$key.'='.$value."<br />\n";
	}
}

$action_mode = 'update_equipment_check';
$data_function = new data_function;

$data_function->setDb('`equipment_reservation_list` LEFT JOIN `equipment_reservation` ON `equipment_reservation_list`.`equipment_id`=`equipment_reservation`.`equipment_id`');
$select_expression = "`equipment_reservation_list`.*, `equipment_reservation`.`equipment_name`";
$where_expression = "AND `list_id` = '".$list_id."'";
$getdata = $data_function->select($where_expression,$select_expression);
foreach($getdata as $key1 => $value1){
  foreach($value1 as $key2 => $value2){
    echo '$getdata['.$key1.']['.$key2.']='.$value2."<br>\n";
  }
}

echo '$equipment_name:';
echo $equipment_name = $getdata[1]['equipment_name'];
echo "<br>\n";
echo '$list_date:';
echo $list_date = $getdata[1]['list_date'];
echo "<br>\n";
echo '$list_time:';
echo $list_time = $getdata[1]['list_time'];
echo "<br>\n";


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
		$message = str_replace('[name]', 		$equipment_name, $message);
		$message = str_replace('[date]', 		$list_date, $message);
		$message = str_replace('[time]', 		$list_time, $message);

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
