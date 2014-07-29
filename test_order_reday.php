<?php

/*
**貌似就預約系統
**8/20 未使用即刪除
*/
die('預約系統');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

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
$ra_name = $_GET['name'];

$ra_id = $_GET['rulepic_id'];
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

if ((isset($_GET['order_id'])) && ($_GET['order_id'] != "") && (isset($_GET['dele']))) {
  $deleteSQL = sprintf("DELETE FROM order_all WHERE order_id=%s",
  GetSQLValueString($_GET['order_id'], "int"));

  mysql_select_db($database_connSQL, $connSQL);
  $Result1 = mysql_query($deleteSQL, $connSQL) or die(mysql_error());

  $deleteGoTo = "test_order_reday.php?rulepic_id=".$ra_id."&name=".$ra_name;
  header(sprintf("Location: %s", $deleteGoTo));
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

$maxRows_Recbody = 8;
$pageNum_Recbody = 0;
if (isset($_GET['pageNum_Recbody'])) {
  $pageNum_Recbody = $_GET['pageNum_Recbody'];
}
$startRow_Recbody = $pageNum_Recbody * $maxRows_Recbody;

$colname_Recbody = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recbody = $_SESSION['MM_Username'];
}
$colname2_Recbody = "1";
if (isset($_GET['rulepic_id'])) {
  $colname2_Recbody = $_GET['rulepic_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_Recbody = sprintf("SELECT * FROM order_all WHERE order_name = %s and rulepic_id = %s ORDER BY o_time DESC", GetSQLValueString($colname_Recbody, "text"),GetSQLValueString($colname2_Recbody, "text"));
$query_limit_Recbody = sprintf("%s LIMIT %d, %d", $query_Recbody, $startRow_Recbody, $maxRows_Recbody);
$Recbody = mysql_query($query_limit_Recbody, $connSQL) or die(mysql_error());
$row_Recbody = mysql_fetch_assoc($Recbody);

if (isset($_GET['totalRows_Recbody'])) {
  $totalRows_Recbody = $_GET['totalRows_Recbody'];
} else {
  $all_Recbody = mysql_query($query_Recbody);
  $totalRows_Recbody = mysql_num_rows($all_Recbody);
}
$totalPages_Recbody = ceil($totalRows_Recbody/$maxRows_Recbody)-1;

mysql_select_db($database_connSQL, $connSQL);
$query_Recordset1 = "SELECT * FROM order_rulepic";
$Recordset1 = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$queryString_Recbody = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_Recbody") == false &&
    stristr($param, "totalRows_Recbody") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_Recbody = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_Recbody = sprintf("&totalRows_Recbody=%d%s", $totalRows_Recbody, $queryString_Recbody);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>公設預約</title>
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
<style type="text/css">
<!--
.org {
   font-size: 18px;
   color: #F60;
}
-->
</style>
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
  <table border="0" align="center" cellpadding="0" cellspacing="0" id="allpic">
    <?php include('pic1_template.php'); ?>
    <?php include('pic2_template.php'); ?>
    <tr>
      <td height="390">
        <table border="0" cellpadding="0" cellspacing="0" id="pic3">
          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" id="pic3_left">
                <tr>
                  <td width="10">&nbsp;</td>
                </tr>
              </table>
              <table border="0" cellpadding="0" cellspacing="0" id="pic3_right">
                <tr>
                  <td>
                    <table width="750" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td height="60" valign="bottom">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="40">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="45%" valign="middle"><img src="img/img/q_BTN.png"  align="absmiddle" /> <span class="org">已預約設備清單</span>
                                    </td>
                                    <td width="55%">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td align="center"><a href="order.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image26','','img/BTN/OPEN_dn.png',1)"> <img src="img/BTN/OPEN_up.png"  name="Image26" width="130" height="30" border="0" id="Image26" /> </a>
                                          </td>
                                          <td align="center"><a href="test_orderready.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image28','','img/BTN/already_dn.png',1)"> <img src="img/BTN/already_dn.png"  name="Image24" width="130" height="30" border="0" id="Image2" /> </a>
                                          </td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                            <tr>
                              <td>
                                <hr />
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td height="330">
                          <table width="750" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="229" height="330" align="left" valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="300" align="left" valign="top"><?php do { ?>
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr onmouseover="mark(this,'#000000','#FFFFFF')" onmouseout="mark(this,'','#FFFFFF')">
                                          <td height="30" align="left"><span class="white"> <a href="test_order_reday.php?rulepic_id=<?php echo $row_Recordset1['rulepic_id']; ?>&amp;name=<?php echo $row_Recordset1['name']; ?>"> <?php echo $row_Recordset1['name']; ?> </a> </span>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td height="1" colspan="4" style="border: 0px solid white; border-bottom-width: 1px;"></td>
                                        </tr>
                                      </table> <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
                                    </td>
                                  </tr>
                                  <tr align="right">
                                    <td height="29" align="center">
                                      <table border="0" align="center">
                                        <tr>
                                          <td></td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td width="521" align="center" valign="top">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td height="330">
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="10">&nbsp;</td>
                                          <td height="290" style="background-image: url(img/img/q2_BG.jpg);">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                              <tr>
                                                <td width="10">&nbsp;</td>
                                                <td height="30" align="left" class="yellow"><?php echo $ra_name; ?>
                                                </td>
                                                <td width="10">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td width="10">&nbsp;</td>
                                                <td height="230" valign="top" style="background-image: url(img/img/IBIG.jpg);">
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr bgcolor="#000000">
                                                      <td width="4%">&nbsp;</td>
                                                      <td width="38%" align="center">日期</td>
                                                      <td width="33%" align="center">時間</td>
                                                      <td width="25%" align="center">刪除</td>
                                                    </tr>
                                                    <tr>
                                                      <td height="30" colspan="4"><?php do { ?>
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                            <td width="4%">&nbsp;</td>
                                                            <td width="38%" height="25" align="center"><?php echo $row_Recbody['o_time']; ?>
                                                            </td>
                                                            <td width="33%" align="center"><?php echo $row_Recbody['order_time']; ?>
                                                            </td>
                                                            <td width="25%" align="center"><span class="yellow"> <?php 
                                                            $today = date('d');
                                                            $m = date('m');
                                                            $y = date('Y');
                                                            $all = $y.$m.$today;
                                                            ?> <?php
                                                            if ($all > $row_Recbody['o_time'] OR $all == NULL){
                                                              echo("");
                                                            }
                                                            else {
                                                              if($row_Recbody['disable']==1){
                                                                ?> 已取消 <?php
                                                              }
                                                              else{
                                                                ?> <a href="test_order_reday.php?dele=true&order_id=<?php echo $row_Recbody['order_id']; ?>&rulepic_id=<?php echo $_GET['rulepic_id']; ?>&name=<?php echo $_GET['name']; ?>"> <img src="img/img/delete.png" width="25" height="25" border="0" align="absmiddle" /> </a> <?php
                                                              }
                                                            }
                                                            ?> </span>
                                                            </td>
                                                          </tr>
                                                          <tr>
                                                            <td height="1" colspan="4" style="border: 0px solid white; border-bottom-width: 1px;"></td>
                                                          </tr>
                                                        </table> <?php } while ($row_Recbody = mysql_fetch_assoc($Recbody)); ?>
                                                      </td>
                                                    </tr>
                                                  </table>
                                                </td>
                                                <td width="10">&nbsp;</td>
                                              </tr>
                                              <tr>
                                                <td width="10">&nbsp;</td>
                                                <td height="30" align="right">
                                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                      <td width="76%">
                                                        <table border="0" align="center">
                                                          <tr>
                                                            <td width="50"><?php if ($pageNum_Recbody > 0) { // Show if not first page ?> <a href="<?php printf("%s?pageNum_Recbody=%d%s", $currentPage, 0, $queryString_Recbody); ?>">第一頁</a> <?php } // Show if not first page ?>
                                                            </td>
                                                            <td width="50"><?php if ($pageNum_Recbody > 0) { // Show if not first page ?> <a href="<?php printf("%s?pageNum_Recbody=%d%s", $currentPage, max(0, $pageNum_Recbody - 1), $queryString_Recbody); ?>">上一頁</a> <?php } // Show if not first page ?>
                                                            </td>
                                                            <td width="50"><?php if ($pageNum_Recbody < $totalPages_Recbody) { // Show if not last page ?> <a href="<?php printf("%s?pageNum_Recbody=%d%s", $currentPage, min($totalPages_Recbody, $pageNum_Recbody + 1), $queryString_Recbody); ?>">下一頁</a> <?php } // Show if not last page ?>
                                                            </td>
                                                            <td width="88"><?php if ($pageNum_Recbody < $totalPages_Recbody) { // Show if not last page ?> <a href="<?php printf("%s?pageNum_Recbody=%d%s", $currentPage, $totalPages_Recbody, $queryString_Recbody); ?>">最後一頁</a> <?php } // Show if not last page ?>
                                                            </td>
                                                          </tr>
                                                        </table> <a href="order_reday.php"> </a>
                                                      </td>
                                                      <td width="24%"><a href="test_orderready.php"> <img src="img/BTN/back.png"  width="110" height="30" border="0" /> </a>
                                                      </td>
                                                    </tr>
                                                  </table>
                                                </td>
                                                <td width="10">&nbsp;</td>
                                              </tr>
                                            </table>
                                          </td>
                                          <td width="10">&nbsp;</td>
                                        </tr>
                                        <tr>
                                          <td width="10">&nbsp;</td>
                                          <td>&nbsp;</td>
                                          <td width="10">&nbsp;</td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <table border="0" cellpadding="0" cellspacing="0" id="pic4">
          <tr>
            <td align="center">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
