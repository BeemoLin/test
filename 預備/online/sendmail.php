<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/ccq1/Connections/connSQL.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/ccq1/define.php');
$exl_exl=$_POST["zip"];
$exl_phone=$_POST["exl_phone"];
$exl_adj=$_POST["exl_adj"];
$exl_name=$_POST["exl_name"];
$exl_date=$_POST["exl_date"];
$sql = "INSERT INTO exl (exl_exl, exl_phone, exl_adj, exl_name, exl_date)VALUES('$exl_exl','$exl_phone','$exl_adj','$exl_name','$exl_date')";
$res = mysql_query($sql)or die(mysql_error());


include("class.phpmailer.php"); //匯入PHPMailer類別
$user=$_POST["exl_name"];
$subject=$_POST["zip"];
$message=$_POST["exl_adj"];
$phone=$_POST["exl_phone"];
$mailto=$_POST["mailto"];
$pphone=$_POST["pphone"];
$aadj=$_POST["aadj"];
$allname=$_POST["allname"];
$adj = $_POST["pphone"].$_POST["exl_phone"].$_POST["aadj"].$_POST["exl_adj"];
$messages='<table width="500" border="1" cellspacing="1" cellpadding="0"><tr><th colspan="2" scope="row">親家建設線上報修單</th></tr><tr><th width="100" align="left" scope="row">報修位置：</th><td width="391">'.$subject.'</td></tr><tr><th align="left" scope="row">聯絡電話：</th><td>'.$phone.'</td></tr>
  <tr>
    <th align="left" scope="row">說明：</th>
    <td>'.$message.'</td>
  </tr>
<tr>
  <th align="left" scope="row">住戶：</th><td>'.$user.'</td></tr></table>';

$mail= new PHPMailer(); //建立新物件
$mail->IsSMTP(); //設定使用SMTP方式寄信
// $mail->SMTPAuth = false; //設定SMTP需要驗證
$mail->Host = "msa.hinet.net"; //SMTP主機位置
$mail->Port = 25; //設定SMTP埠位，預設為25埠。
$mail->CharSet = "utf8"; //設定郵件編碼
// $mail->Username = "service.tcwa@hinet.net"; //設定驗證帳號
// $mail->Password = "da909088"; //設定驗證密碼
$mail->From = "service.tcwa@hinet.net"; //設定寄件者信箱
$mail->FromName = "$user"; //設定寄件者姓名
$mail->Subject = C_SUBJECT."：".$user." 線上報修通知"; //設定郵件標題
$mail->Body = $messages; //設定郵件內容
$mail->IsHTML(true); //設定郵件內容為HTML
$mailto= explode(',', $_POST["mailto"]);   
foreach ($mailto as $mrs){   
$mail->AddAddress($mrs); 
}

//$mail->AddAddress("$mailto", "aaa"); //設定收件者郵件及名稱
if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
  exit;
} 
?>




<?php    header('Location: ../online.php');    exit;?>