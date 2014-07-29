<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
$logoutAction = 'logout.php';

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);

  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}

$MM_authorizedUsers = "admin,member";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) {
  // For security, start by assuming the visitor is NOT authorized.
  $isValid = False;

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username.
  // Therefore, we know that a user is NOT logged in if that Session variable is blank.
  if (!empty($UserName)) {
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login.
    // Parse the strings into arrays.
    $arrUsers = Explode(",", $strUsers);
    $arrGroups = Explode(",", $strGroups);
    if (in_array($UserName, $arrUsers)) {
      $isValid = true;
    }
    // Or, you may restrict access to only certain users based on their username.
    if (in_array($UserGroup, $arrGroups)) {
      $isValid = true;
    }
    if (($strUsers == "") && true) {
      $isValid = true;
    }
  }
  return $isValid;
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0)
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo);
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
  {
    if (PHP_VERSION < 6) {
      $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
    }

    $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

    switch ($theType) {
      case "text":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "long":
      case "int":
        $theValue = ($theValue != "") ? intval($theValue) : "NULL";
        break;
      case "double":
        $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
        break;
      case "date":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $passwd= $_POST['m_passwd'];
  if($_POST["new_passwd"]!=""){
    $passwd= $_POST['new_passwd'];
  }
  $updateSQL = sprintf("UPDATE memberdata SET m_name=%s, m_nick=%s, m_passwd=%s, m_email=%s, m_phone=%s, m_cellphone=%s, m_address=%s WHERE m_id=%s",
  GetSQLValueString($_POST['m_name'], "text"),
  GetSQLValueString($_POST['m_nick'], "text"),
  GetSQLValueString($passwd, "text"),
  GetSQLValueString($_POST['m_email'], "text"),
  GetSQLValueString($_POST['m_phone'], "text"),
  GetSQLValueString($_POST['m_cellphone'], "text"),
  GetSQLValueString($_POST['m_address'], "text"),
  GetSQLValueString($_POST['m_id'], "int"));

  mysql_select_db($database_connSQL, $connSQL);
  $Result1 = mysql_query($updateSQL, $connSQL) or die(mysql_error());

  $updateGoTo = "index2.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$colname_Recmember = "-1";
if (isset($_GET['m_username'])) {
  $colname_Recmember = $_GET['m_username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_Recmember = sprintf("SELECT * FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_Recmember, "text"));
$Recmember = mysql_query($query_Recmember, $connSQL) or die(mysql_error());
$row_Recmember = mysql_fetch_assoc($Recmember);
$totalRows_Recmember = mysql_num_rows($Recmember);

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>修改資料</title>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript">
</script>
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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/rule_dn.gif','img/third/choose_dn.gif','img/third/arrow_up(3).gif')">
 <?php include('layout/template.html'); ?>
</body>
</html>

