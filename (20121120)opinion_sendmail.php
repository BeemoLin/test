<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once(INCLUDES.'/PHPMailer/class.phpmailer.php');
if($_POST['check_key'] == $_SESSION['S_check_key']){
  $_SESSION['S_check_key'] = null;
  unset($_SESSION['S_check_key']);

  $opinion_title=$_POST["opinion_title"];
  $opinion_content=$_POST["opinion_content"];

  $now = date('Y-m-d H:i:s', time());
  $UID = $_SESSION['MM_UserID'];
  $sql = "
  INSERT INTO 
    `opinion_tab1`
  SET 
    ot1_uid = '".$UID."', 
    ot1_title = '".$opinion_title."', 
    ot1_datetime = '".$now."'
  ";

  $res = mysql_query($sql)or die(mysql_error());
  $ot1_id = mysql_insert_id();

  $sql = "
  INSERT INTO 
    `opinion_tab2`
  SET 
    ot1_id = '".$ot1_id."', 
    ot2_uid = '".$UID."', 
    ot2_content = '".$opinion_content."', 
    ot2_datetime = '".$now."'
  ";
  $res = mysql_query($sql)or die(mysql_error());

  $user=$_SESSION['MM_Username'];
  $subject=$opinion_title;
  $meg=$opinion_content;

  $query_mail = "SELECT * FROM adminuser";
  $Recordset = mysql_query($query_mail, $connSQL) or die(mysql_error());
  $send_mail = mysql_fetch_assoc($Recordset);

  $message='<table width="500" border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="98">意見標題：</td>
      <td width="402">'.$subject.'</td>
    </tr>
    <tr>
      <td>意見內容：</td>
      <td>'.$meg.'</td>
    </tr>
  </table>';

  $mail= new PHPMailer(); //建立新物件
  $mail->IsSMTP(); //設定使用SMTP方式寄信
  // $mail->SMTPAuth = false; //設定SMTP需要驗證
  $mail->Host = "msa.hinet.net"; //SMTP主機位置
  $mail->Port = 25; //設定SMTP埠位，預設為25埠。
  $mail->CharSet = "utf8"; //設定郵件編碼
  $mail->From = "service.tcwa@hinet.net"; //設定寄件者信箱
  $mail->FromName = C_SUBJECT ; //設定寄件者姓名
  //$mail->Subject = "親家Q ONE 住戶意見反應"; //設定郵件標題
  $mail->Subject = C_SUBJECT ."：".$user." 住戶意見反應"; //設定郵件標題
  $mail->Body = $message; //設定郵件內容
  $mail->IsHTML(true); //設定郵件內容為HTML
  $mailto= explode(',', $send_mail['mail']);   
  foreach ($mailto as $mrs){   
  $mail->AddAddress($mrs); 
  }

  //$mail->AddAddress("$mailto", "aaa"); //設定收件者郵件及名稱
  if(!$mail->Send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    exit();
  } 
}
else{
  $_SESSION['S_check_key'] = null;
  unset($_SESSION['S_check_key']);
	echo "<script>alert('請不要刷新本頁面或重複提交表單！');</script>";  
}
header('Location: opinion2.php');
exit();
?>