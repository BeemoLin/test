<?php 
session_start();
header("Content-type: text/xml"); 
header(" Cache-Control: no-cache"); 
$xml = true;
require_once(CONNSQL);
require_once(PAGECLASS);
echo '<?xml version="1.0" encoding="UTF-8"?>'; 
echo "<response>"; 

$message="123"; 
if(!empty($_POST["myId"])) {
  $myId=$_POST["myId"];
  $count = "SELECT count(1) FROM memberdata WHERE m_username = '$myId' ";
  $count_no = mysql_query($count);
  $data1 = mysql_fetch_row($count_no);
  $total =(int)$data1[0];
  if ($total >= 1){
    $message="帳號已被使用";
  }
  else{
    $message="帳號可被使用";
  } 
}
else { 
    $message="空值，不合法帳號"; 
} 
echo '<message>'.$message.'</message>'; 
echo '<message>abcd</message>'; 
echo "</response>"; 
	  
?>