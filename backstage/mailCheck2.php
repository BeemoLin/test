<?php 
session_start();
header("Content-type: text/xml"); 
header(" Cache-Control: no-cache"); 
$xml = true;
require_once('../define.php');
echo '<?xml version="1.0" encoding="UTF-8"?>'; 
echo "<response>"; 

$message="你看不到我，妳看不到我"; 
if(!empty($_POST["letters_number"])) {
  $letters_number=$_POST["letters_number"];
  $id=$_POST["id"];
  $count = "SELECT count(1) FROM `mail_management` WHERE `letters_number` = '$letters_number' AND `id` != '$id'";
  $count_no = mysql_query($count);
  $data1 = mysql_fetch_row($count_no);
  $total =(int)$data1[0];
  if ($total >= 1){
    $message="函件編號已被使用，請重新確認！";
    $lettercheck="0";
  }
  else{
    $message="函件編號可被使用。";
    $lettercheck="1";
  } 
}
else { 
    $message="空值，不合法函件編號。"; 
    $lettercheck="0";
} 
echo '<message>'.$message.'</message>'; 
echo '<lettercheck>'.$lettercheck.'</lettercheck>'; 
echo "</response>"; 
	  
?>