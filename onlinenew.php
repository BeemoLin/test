<?php
session_start();
header('Content-type:text/html; charset=utf-8');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
/* debug專用
foreach($_POST as $key => $value){
  echo '$_POST['.$key.']='.$value."<br/>\n";
}
echo "-------------------<br/>\n";
foreach($_SESSION as $key => $value){
  echo '$_SESSION['.$key.']='.$value."<br/>\n";
}
echo "-------------------<br/>\n";
*/
//echo '0. '.$_POST['check_key']." ?= ".$_SESSION['S_check_key']."<br>";
$temp_key = mt_rand(0,1000000);
//echo 'mt_rand()='.$temp_key."<br/>\n";

if(empty($_SESSION['S_check_key'])){
  $_SESSION['S_check_key'] = $temp_key;
}
$check_key = $_SESSION['S_check_key'];

//echo "1.&nbsp;&nbsp;".$check_key."<br>";
//echo "2.&nbsp;&nbsp;".$_SESSION['S_check_key']."<br>";

require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
require_once('includes/authorization.php');

if (!function_exists("GetSQLValueString")) {
  require_once('includes/common.php');
}

		//$_SESSION['Scheck_key'] = null;
		//unset($_SESSION['Scheck_key']);

mysql_select_db($database_connSQL, $connSQL);
$query_re_fix1 = "SELECT * FROM fix1 ORDER BY cID ASC";
$re_fix1 = mysql_query($query_re_fix1, $connSQL) or die(mysql_error());
$row_re_fix1 = mysql_fetch_assoc($re_fix1);

/*$colname_re_fix2 = "-1";
if (isset($_POST['county'])) {
  $colname_re_fix2 = $_POST['county'];
}*/
$colname_re_fix2=(isset($_POST['county']))?$_POST['county']:"-1";

mysql_select_db($database_connSQL, $connSQL);
$query_re_fix2 = sprintf("SELECT * FROM fix2 WHERE tCounty = %s", GetSQLValueString($colname_re_fix2, "text"));
$re_fix2 = mysql_query($query_re_fix2, $connSQL) or die(mysql_error());
$row_re_fix2 = mysql_fetch_assoc($re_fix2);

/*$colname_re_fix3 = "-1";
if (isset($_POST['town'])) {
  $colname_re_fix3 = $_POST['town'];
}*/

$colname_re_fix3=(isset($_POST['town']))?$_POST['town']:"-1";

mysql_select_db($database_connSQL, $connSQL);
$query_re_fix3 = sprintf("SELECT * FROM fix3 WHERE zTown = %s", GetSQLValueString($colname_re_fix3, "text"));
$re_fix3 = mysql_query($query_re_fix3, $connSQL) or die(mysql_error());
$row_re_fix3 = mysql_fetch_assoc($re_fix3);

mysql_select_db($database_connSQL, $connSQL);
$query_Recordset1 = "SELECT * FROM adminuser WHERE id = 1";
$Recordset1 = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

// 取得戶號列表


//20140625 by akai
$colname_member_phone=(isset($_POST['exl_name']))?$_POST['exl_name']:$_SESSION['MM_Username'];
//先撈登入的帳號密碼
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username, m_phone,m_cellphone FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_member_phone, "text"));  //$_SESSION['MM_Username']
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);

//撈所有成員資料
mysql_select_db($database_connSQL, $connSQL);
$sql = "SELECT m_username FROM memberdata";
$rec_names = mysql_query($sql, $connSQL) or die(mysql_error());


//$row_names = mysql_fetch_assoc($rec_names);
//$total_names = mysql_num_rows($rec_names);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>線上報修</title>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function flevSubmitForm(){//v2.0
// Copyright 2002-2004, FlevOOware (www.flevooware.nl/dreamweaver/)
var v1=arguments,v2=MM_findObj(v1[0]),v3=(v1.length>1)?v1[1]:"",v4=(v1.length>2)?v1[2]:"";
//arguments 參數
//alert(v1[0]);form1
//alert(v1[1]);onlinenew.php
//alert(v1[2]);""
if (v2){if (v3!=""){v2.action=v3;}if (v4!=""){v2.target=v4;}v2.submit();document.MM_returnValue=false;//form.action submit
}

}

function check_all(){
  var county=document.getElementById('county');
  var town=document.getElementById('town');
  var zip=document.getElementById('zip');
  if(county.value=='0' || county.value=='' || county.value=='請選擇'){
    alert("請選擇報修位置");
  }
  else if(town.value=='0' || town.value=='' || town.value=='請選擇'){
    alert("請選擇報修類別");
  }
  else if(zip.value=='0' || zip.value=='' || zip.value=='請選擇'){
    alert("請選擇報修細類");
  }
  else{
    document.form1.submit();
  }
}
//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv3 {
   position: absolute;
   width: 200px;
   height: 115px;
   z-index: 2;
   left: 337px;
   top: 340px;
   visibility: hidden;
}

.org {
   font-size: 18px;
   color: #F60;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/third/arrow_up(3).gif','img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif')">
  
  <?php include('layout/template.html'); ?>
  <script language="JavaScript">
// KW DROPDOWN INSTALL CONTROL LINE START - DO NOT REMOVE


var a_items = new Array();

 a_items[0]='漏電|a';
 a_items[1]='潮濕|b';


var b_items = new Array();


// KW DROPDOWN INSTALL CONTROL LINE END - DO NOT REMOVE


</script>
</body>
</html>

