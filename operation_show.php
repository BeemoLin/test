<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
mysql_select_db($database_connSQL, $connSQL);
$query_Update = "UPDATE operation SET album_hits=album_hits+1 WHERE album_id = ".$_GET["album_id"];
$Result = mysql_query($query_Update, $connSQL) or die(mysql_error());

$logoutAction = 'logout.php';

$MM_authorizedUsers = "admin,member";
$MM_donotCheckaccess = "true";


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

$currentPage = $_SERVER["PHP_SELF"];

$colname_RecAlbum = "-1";
if (isset($_GET['album_id'])) {
  $colname_RecAlbum = $_GET['album_id'];
}
mysql_select_db($database_connSQL, $connSQL);
//$query_RecAlbum = sprintf("SELECT * FROM operation WHERE album_id = %s", GetSQLValueString($colname_RecAlbum, "int"));
$query_RecAlbum = sprintf("SELECT * FROM operation WHERE album_id = $colname_RecAlbum");
$RecAlbum = mysql_query($query_RecAlbum, $connSQL) or die(mysql_error());
$row_RecAlbum = mysql_fetch_assoc($RecAlbum);
$totalRows_RecAlbum = mysql_num_rows($RecAlbum);

$maxRows_RecPhoto = 6;
$pageNum_RecPhoto = 0;
if (isset($_GET['pageNum_RecPhoto'])) {
  $pageNum_RecPhoto = $_GET['pageNum_RecPhoto'];
}
$startRow_RecPhoto = $pageNum_RecPhoto * $maxRows_RecPhoto;

$colname_RecPhoto = "-1";
if (isset($_GET['album_id'])) {
  $colname_RecPhoto = $_GET['album_id'];
}
mysql_select_db($database_connSQL, $connSQL);
//$query_RecPhoto = sprintf("SELECT * FROM operation_photo WHERE album_id = %s ORDER BY ap_date DESC", GetSQLValueString($colname_RecPhoto, "int"));
$query_RecPhoto = sprintf("SELECT * FROM operation_photo WHERE album_id = $colname_RecPhoto ORDER BY ap_date DESC");
$query_limit_RecPhoto = sprintf("%s LIMIT %d, %d", $query_RecPhoto, $startRow_RecPhoto, $maxRows_RecPhoto);
//die($query_limit_RecPhoto);
$RecPhoto = mysql_query($query_limit_RecPhoto, $connSQL) or die(mysql_error());

if (isset($_GET['totalRows_RecPhoto'])) {
  $totalRows_RecPhoto = $_GET['totalRows_RecPhoto'];
} else {
  $all_RecPhoto = mysql_query($query_RecPhoto);
  $totalRows_RecPhoto = mysql_num_rows($all_RecPhoto);
}
$totalPages_RecPhoto = ceil($totalRows_RecPhoto/$maxRows_RecPhoto)-1;

$queryString_RecPhoto = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecPhoto") == false &&
    stristr($param, "totalRows_RecPhoto") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecPhoto = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecPhoto = sprintf("&totalRows_RecPhoto=%d%s", $totalRows_RecPhoto, $queryString_RecPhoto);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>社區公告</title>

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
<script type="text/javascript" src="js/jquery-1.2.1.pack.js">
</script>
<script type="text/javascript" src="js/pro.js">
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.blue {
   color: #09C;
}

.q {
   height: 130px;
   width: 110px;
   font-size: 12px;
   float: left;
   text-align: center;
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

.popshow {
   width: 560px;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
 <?php include('layout/template.html'); ?>
   
</body>
</html>
