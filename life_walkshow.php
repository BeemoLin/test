<?php
//css 完全獨立
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
mysql_select_db($database_connSQL, $connSQL);
$query_Update = "UPDATE walk SET walk_hits=walk_hits+1 WHERE walk_id = ".$_GET["walk_id"];
$Result = mysql_query($query_Update, $connSQL) or die(mysql_error());

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

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);
$totalRows_RecUser = mysql_num_rows($RecUser);

$colname_RecWalk = "-1";
if (isset($_GET['walk_id'])) {
  $colname_RecWalk = $_GET['walk_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecWalk = sprintf("SELECT * FROM walk WHERE walk_id = %s", GetSQLValueString($colname_RecWalk, "int"));
$RecWalk = mysql_query($query_RecWalk, $connSQL) or die(mysql_error());
$row_RecWalk = mysql_fetch_assoc($RecWalk);
$totalRows_RecWalk = mysql_num_rows($RecWalk);

$colname_RecPhoto2 = "-1";
if (isset($_GET['walk_id'])) {
  $colname_RecPhoto2 = $_GET['walk_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecPhoto2 = sprintf("SELECT * FROM walk_photo2 WHERE walk_id = %s ORDER BY app_date ASC", GetSQLValueString($colname_RecPhoto2, "int"));
$RecPhoto2 = mysql_query($query_RecPhoto2, $connSQL) or die(mysql_error());
$row_RecPhoto2 = mysql_fetch_assoc($RecPhoto2);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>行</title>
<style type="text/css">
<!--
body {
   background-image: url();
   background-repeat: no-repeat;
   margin-left: 0px;
   margin-top: 0px;
   background-color: #000;
   font-family: "微軟正黑體";
   color: #FFF;
}

.all {
   background-image: url(img/third/backgrondreal.jpg);
}

.white {
   color: #FFF;
   font-family: "微軟正黑體";
}
-->
</style>
<script type="text/javascript" src="js/jquery-1.2.1.pack.js"></script>
<script type="text/javascript" src="js/pro.js"></script>
<link href="CSS/allclass.css" rel="stylesheet" type="text/css" />
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
<style type="text/css">
<!--
.i {
   color: #FF0;
   font-family: "微軟正黑體";
}

.p {
   color: #F00;
}

.a {
   color: #FFF;
   font-family: "微軟正黑體";
}

.white1 {
   color: #FFF;
   font-family: "微軟正黑體";
}

#a1 {
   height: 95px;
   width: 10px;
   float: left;
}

#a10 {
   height: 95px;
   width: 40px;
   float: right;
}

#a2 {
   height: 95px;
   width: 90px;
   float: left;
}

#a3 {
   height: 95px;
   width: 90px;
   float: left;
}

#a4 {
   height: 95px;
   width: 90px;
   float: left;
}

#a5 {
   height: 95px;
   width: 90px;
   float: left;
}

#a6 {
   height: 95px;
   width: 90px;
   float: left;
}

#a7 {
   height: 95px;
   width: 90px;
   float: left;
}

#a8 {
   height: 95px;
   width: 90px;
   float: left;
}

#a9 {
   height: 95px;
   width: 90px;
   float: left;
}

#allpic {
   background-image: url(img/beforepic/backgrondreal.jpg);
   height: 580px;
   width: 770px;
   background-repeat: no-repeat;
}

#apDiv1 {
   position: relative;
   width: 32px;
   height: 73px;
   z-index: 1;
   left: 0px;
   top: 10px;
}

#apDiv2 {
   position: absolute;
   width: 200px;
   height: 115px;
   z-index: 1;
   left: -250px;
   top: 77px;
   visibility: hidden;
}

#pic1 {
   height: 75px;
   width: 770px;
}

#pic2 {
   height: 100px;
   width: 770px;
}

#pic3 {
   height: 390px;
   width: 770px;
   background-repeat: no-repeat;
   background-position: left;
}

#pic3_left {
   float: left;
   height: 390px;
   width: 10px;
}

#pic3_right {
   float: left;
   height: 390px;
   width: 750px;
   background-image: url(img/img/gray_BG.jpg);
}

.i {
   color: #FF0;
   font-family: "微軟正黑體";
}

.p {
   color: #F00;
}

.a {
   color: #FFF;
   font-family: "微軟正黑體";
}

#pic4 {
   background-image: url(img/beforepic/dn_bar.gif);
   height: 20px;
   width: 770px;
}

#title {
   float: left;
   height: 65px;
   width: 175px;
   background-image: url(img/third/LOGO.gif);
   background-repeat: no-repeat;
   background-position: right center;
}

#title2 {
   float: left;
   height: 65px;
   width: 180px;
   background-image: url(img/third/cc77.gif);
   background-repeat: no-repeat;
   background-position: right center;
}

#title3 {
   float: right;
   height: 75px;
   width: 300px;
}

#title3_left {
   float: left;
   height: 75px;
   width: 190px;
}

#title3_left_down {
   height: 37px;
   width: 190px;
}

#title3_left_up {
   height: 37px;
   width: 190px;
}

#title3_right {
   float: right;
   height: 75px;
   width: 110px;
}

#title3_right_down {
   height: 37px;
   width: 110px;
}

#title3_right_up {
   height: 37px;
   width: 110px;
}


.a1 {
   color: #FFF;
   font-family: "微軟正黑體";
}

.org {
   color: #F60;
   font-size: 18px;
   font-family: "微軟正黑體";
}


.q {
   height: 100px;
   width: 80px;
   //font-size: 12px;
   float: left;
}

.yel {
   color: #FC3;
}

#back {
   background-image: url(img/img/q_BG.jpg);
   height: 240px;
   width: 100%;
}

img.pop {
   position: absolute;
   border: 10px solid #214263;
   z-index: 1;
}

.more {
   background: #214263;
   color: white;
   position: absolute;
   border: 10px solid #214263;
   z-index: 2;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
  <?php include('layout/template.html'); ?>
   
</body>
</html>
