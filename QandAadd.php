<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
if (!function_exists("GetSQLValueString")) {
  include('includes/common.php');
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO qa_qa2 (qa_id, qa_yesno, qa_name) VALUES (%s, %s, %s)",
  GetSQLValueString($_POST['qa_id'], "int"),
  GetSQLValueString($_POST['qa_yesno'], "text"),
  GetSQLValueString($_POST['qa_name'], "text"));

  mysql_select_db($database_connSQL, $connSQL);
  $Result1 = mysql_query($insertSQL, $connSQL) or die(mysql_error());

  $insertGoTo = "QandA.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    //$insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  exit();
}

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);
$totalRows_RecUser = mysql_num_rows($RecUser);

$colname_RecQA = "-1";
if (isset($_GET['qa_id'])) {
  $colname_RecQA = $_GET['qa_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecQA = sprintf("SELECT * FROM qa WHERE qa_id = %s", GetSQLValueString($colname_RecQA, "int"));
$RecQA = mysql_query($query_RecQA, $connSQL) or die(mysql_error());
$row_RecQA = mysql_fetch_assoc($RecQA);
$totalRows_RecQA = mysql_num_rows($RecQA);

$colname_RecQA_QA = "-1";
if (isset($_GET['qa_id'])) {
  $colname_RecQA_QA = $_GET['qa_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecQA_QA = sprintf("SELECT * FROM qa_qa2 WHERE qa_id = %s ORDER BY qa_date DESC", GetSQLValueString($colname_RecQA_QA, "int"));
$RecQA_QA = mysql_query($query_RecQA_QA, $connSQL) or die(mysql_error());
$row_RecQA_QA = mysql_fetch_assoc($RecQA_QA);
$totalRows_RecQA_QA = mysql_num_rows($RecQA_QA);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>問卷調查</title>
<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
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
   visibility: hidden;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/rule_dn.gif','img/third/choose_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
   <?php include('layout/template.html'); ?>
   
</body>
</html>
