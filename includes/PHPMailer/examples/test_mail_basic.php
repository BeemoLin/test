<html>
<head>
<title>PHPMailer - Mail() basic test</title>
</head>
<body>

<?php

require_once('../class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->AddReplyTo("1@yourdomain.com","First Last");//回覆至

$mail->SetFrom('2@yourdomain.com', 'First Last');//寄件人

$mail->AddReplyTo("3@yourdomain.com","First Last");//回覆至

$address = "sam1031@gmail.com";
$mail->AddAddress($address, "SamYao");//收件人

$mail->Subject    = "PHPMailer Test Subject via mail(), basic"; // title

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$mail->AddAttachment("images/phpmailer.gif");      // attachment
$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>
