<?php 
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
?>
<?php
if (!isset($_SESSION)) {
  session_start();
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

$colname_RecAlbum = "-1";
if (isset($_GET['album_id'])) {
  $colname_RecAlbum = $_GET['album_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecAlbum = sprintf("SELECT * FROM album WHERE album_id = %s", GetSQLValueString($colname_RecAlbum, "int"));
$RecAlbum = mysql_query($query_RecAlbum, $connSQL) or die(mysql_error());
$row_RecAlbum = mysql_fetch_assoc($RecAlbum);
$totalRows_RecAlbum = mysql_num_rows($RecAlbum);

$colname_RecPhoto = "-1";
if (isset($_GET['ap_id'])) {
  $colname_RecPhoto = $_GET['ap_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecPhoto = sprintf("SELECT * FROM albumphoto WHERE ap_id = %s", GetSQLValueString($colname_RecPhoto, "int"));
$RecPhoto = mysql_query($query_RecPhoto, $connSQL) or die(mysql_error());
$row_RecPhoto = mysql_fetch_assoc($RecPhoto);
$totalRows_RecPhoto = mysql_num_rows($RecPhoto);

$colname_Recordset1 = "-1";
if (isset($_GET['rulepic_id'])) {
  $colname_Recordset1 = $_GET['rulepic_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_Recordset1 = sprintf("SELECT * FROM order_rulepic WHERE rulepic_id = %s", GetSQLValueString($colname_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
$today = date('d');
$m = date('m');
$y = date('Y');
$id = $_GET['rulepic_id'];
$name = $_GET['name'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>視聽室</title>
<style type="text/css">
<!--
body {
	background-image: url();
	background-repeat: no-repeat;
	margin-left: 0px;
	margin-top: 0px;
	background-color: #000;
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
<script type="text/javascript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:relative;
	width:32px;
	height:73px;
	z-index:1;
	left: 0px;
	top: 0px;
}
#apDiv2 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	left: -258px;
	top: 115px;
	visibility: hidden;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/arrow_up(3).gif')">
<table width="770" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <th scope="row"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <th height="571" align="center" scope="row"><div>
          <div>
            <div>
              <img src="backstage/upfildes/<?php echo $row_Recordset1['pic']; ?>" width="800" height="600" border="0" />
              <table width="33%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="51%"><div>
                    <div class="actionDiv"><a href="order.php">回設備清單</a></div>
                    </div></td>
                  <td width="49%" align="right"><a href="test_addorder.php?year=<?php echo $y ;?>&amp;month=<?php echo $m ;?>&amp;day=<?php echo $today ;?>&amp;rulepic_id=<?php echo $id ;?>&amp;name=<?php echo $name ?>">同意</a></td>
                  </tr>
              </table>
            </div>
          </div>
        </div></th>
        </tr>
    </table></th>
  </tr>
  <tr>
    <th height="29" style="background-position: center; background-image: url(img/third/dn_bar.gif);" scope="row">&nbsp;</th>
  </tr>
</table>

</body>
</html>
