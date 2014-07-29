<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
#	BuildNav for Dreamweaver MX v0.2
#              10-02-2002
#	Alessandro Crugnola [TMM]
#	sephiroth: alessandro@sephiroth.it
#	http://www.sephiroth.it
#
#	Function for navigation build ::
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true)
{
  GLOBAL $maxRows_RecLiving,$totalRows_RecLiving;
  $pagesArray = ""; $firstArray = ""; $lastArray = "";
  if($max_links<2)$max_links=2;
  if($pageNum_Recordset1<=$totalPages_Recordset1 && $pageNum_Recordset1>=0)
  {
    if ($pageNum_Recordset1 > ceil($max_links/2))
    {
      $fgp = $pageNum_Recordset1 - ceil($max_links/2) > 0 ? $pageNum_Recordset1 - ceil($max_links/2) : 1;
      $egp = $pageNum_Recordset1 + ceil($max_links/2);
      if ($egp >= $totalPages_Recordset1)
      {
        $egp = $totalPages_Recordset1+1;
        $fgp = $totalPages_Recordset1 - ($max_links-1) > 0 ? $totalPages_Recordset1  - ($max_links-1) : 1;
      }
    }
    else {
      $fgp = 0;
      $egp = $totalPages_Recordset1 >= $max_links ? $max_links : $totalPages_Recordset1+1;
    }
    if($totalPages_Recordset1 >= 1) {
      #	------------------------
      #	Searching for $_GET vars
      #	------------------------
      $_get_vars = '';
      if(!empty($_GET) || !empty($HTTP_GET_VARS)){
        $_GET = empty($_GET) ? $HTTP_GET_VARS : $_GET;
        foreach ($_GET as $_get_name => $_get_value) {
          if ($_get_name != "pageNum_RecLiving") {
            $_get_vars .= "&$_get_name=$_get_value";
          }
        }
      }
      $successivo = $pageNum_Recordset1+1;
      $precedente = $pageNum_Recordset1-1;
      $firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecLiving=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
      # ----------------------
      # page numbers
      # ----------------------
      for($a = $fgp+1; $a <= $egp; $a++){
        $theNext = $a-1;
        if($show_page)
        {
          $textLink = $a;
        } else {
          $min_l = (($a-1)*$maxRows_RecLiving) + 1;
          $max_l = ($a*$maxRows_RecLiving >= $totalRows_RecLiving) ? $totalRows_RecLiving : ($a*$maxRows_RecLiving);
          $textLink = "$min_l - $max_l";
        }
        $_ss_k = floor($theNext/26);
        if ($theNext != $pageNum_Recordset1)
        {
          $pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecLiving=$theNext$_get_vars\">";
          $pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
        } else {
          $pagesArray .= " <font color=red> $textLink </font> "  . ($theNext < $egp-1 ? $separator : "");
        }
      }
      $theNext = $pageNum_Recordset1+1;
      $offset_end = $totalPages_Recordset1;
      $lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecLiving=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
    }
  }
  return array($firstArray,$pagesArray,$lastArray);
}

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

$currentPage = $_SERVER["PHP_SELF"];

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);
$totalRows_RecUser = mysql_num_rows($RecUser);

$maxRows_RecLiving = 6;
$pageNum_RecLiving = 0;
if (isset($_GET['pageNum_RecLiving'])) {
  $pageNum_RecLiving = $_GET['pageNum_RecLiving'];
}
$startRow_RecLiving = $pageNum_RecLiving * $maxRows_RecLiving;

mysql_select_db($database_connSQL, $connSQL);
$query_RecLiving = "SELECT * FROM living ORDER BY living_date DESC";
$query_limit_RecLiving = sprintf("%s LIMIT %d, %d", $query_RecLiving, $startRow_RecLiving, $maxRows_RecLiving);
$RecLiving = mysql_query($query_limit_RecLiving, $connSQL) or die(mysql_error());
$row_RecLiving = mysql_fetch_assoc($RecLiving);

if (isset($_GET['totalRows_RecLiving'])) {
  $totalRows_RecLiving = $_GET['totalRows_RecLiving'];
} else {
  $all_RecLiving = mysql_query($query_RecLiving);
  $totalRows_RecLiving = mysql_num_rows($all_RecLiving);
}
$totalPages_RecLiving = ceil($totalRows_RecLiving/$maxRows_RecLiving)-1;

$queryString_RecLiving = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecLiving") == false &&
    stristr($param, "totalRows_RecLiving") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecLiving = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecLiving = sprintf("&totalRows_RecLiving=%d%s", $totalRows_RecLiving, $queryString_RecLiving);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>住</title>
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
function mark(face,field_color,text_color){
if (document.documentElement){//if browser is IE5+ or NS6+
face.style.backgroundColor=field_color;
face.style.color=text_color;
}
}
//-->
</script>
<link href="CSS/link.css" rel="stylesheet" type="text/css" />
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
<?php include('layout/template.html'); ?>            
</body>
</html>
