<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/ccq1/Connections/connSQL.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/ccq1/define.php');
$opinion_name=$_POST["opinion_name"];
$opinion_type=$_POST["opinion_type"];
$opinion_date=$_POST["opinion_date"];
$opinion_content=$_POST["opinion_content"];
$sql = "INSERT INTO opinion (opinion_name, opinion_type, opinion_date, opinion_content)VALUES('$opinion_name','$opinion_type','$opinion_date','$opinion_content')";
$res = mysql_query($sql)or die(mysql_error());


include("class.phpmailer.php"); //匯入PHPMailer類別
$user=$_POST["opinion_name"];
$subject=$_POST["opinion_type"];
$meg=$_POST["opinion_content"];
//$email=$_POST["email"];
$mailto=$_POST["mailto"];

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
$mail->FromName = "$user"; //設定寄件者姓名
//$mail->Subject = "親家Q ONE 住戶意見反應"; //設定郵件標題
$mail->Subject = C_SUBJECT ." 住戶意見反應"; //設定郵件標題
$mail->Body = $message; //設定郵件內容
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




<?php    header('Location: ../opinion.php');    exit;?>