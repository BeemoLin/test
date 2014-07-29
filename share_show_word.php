<?php
/*
**分享園地
**已經未使用
*/
die('分享園地');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
mysql_select_db($database_connSQL, $connSQL);
$query_Update = "UPDATE share SET share_hits=share_hits+1 WHERE share_id = ".$_GET["share_id"];
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

$colname_RecShare = "-1";
if (isset($_GET['share_id'])) {
  $colname_RecShare = $_GET['share_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecShare = sprintf("SELECT * FROM share WHERE share_id = %s", GetSQLValueString($colname_RecShare, "int"));
$RecShare = mysql_query($query_RecShare, $connSQL) or die(mysql_error());
$row_RecShare = mysql_fetch_assoc($RecShare);
$totalRows_RecShare = mysql_num_rows($RecShare);

$colname_RecPhoto = "-1";
if (isset($_GET['share_id'])) {
  $colname_RecPhoto = $_GET['share_id'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecPhoto = sprintf("SELECT * FROM share_photo WHERE share_id = %s ORDER BY ap_date DESC", GetSQLValueString($colname_RecPhoto, "int"));
$RecPhoto = mysql_query($query_RecPhoto, $connSQL) or die(mysql_error());
$row_RecPhoto = mysql_fetch_assoc($RecPhoto);
$totalRows_RecPhoto = mysql_num_rows($RecPhoto);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>分享園地</title>
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

.blue {
   color: #09C;
}

.a1 {
   color: #FFF;
   font-family: "微軟正黑體";
}

.q {
   height: 100px;
   width: 100px;
   font-size: 12px;
   float: left;
   text-align: center;
}

.org {
   font-size: 18px;
   color: #F60;
}

.q1 {
   height: 130px;
   width: 110px;
   font-size: 12px;
   float: left;
   text-align: center;
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
                  <td>&nbsp;</td>
                </tr>
              </table>
              <table border="0" cellpadding="0" cellspacing="0" id="pic3_right">
                <tr>
                  <td>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="40"><img src="img/img/q_BTN.png"  align="absmiddle" /> <span class="org"> <?php echo $row_RecShare['share_title']; ?> </span>
                        </td>
                      </tr>
                      <tr>
                        <td height="30">
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td width="51%" height="30" align="left">發布者：<?php echo $row_RecShare['share_sharename']; ?>
                              </td>
                              <td width="49%">發布時間：<?php echo $row_RecShare['share_date']; ?>
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
                      <tr>
                        <td height="300" align="center" valign="top">
                          <table width="749" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                              <td width="99" height="300" align="right" valign="top">內容：</td>
                              <td width="430" align="left" valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="270" align="left" valign="top"><?php echo nl2br(htmlspecialchars($row_RecShare['share_desc'])); ?>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td height="30" align="center"><a href="share.php"> <img src="img/BTN/back.png"  width="110" height="30" border="0" /> </a>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                              <td width="220" align="left" valign="top"><?php if ($totalRows_RecPhoto > 0) { // Show if recordset not empty ?>
                                <table width="219" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td height="30" valign="top">圖片：</td>
                                  </tr>
                                  <tr>
                                    <td height="270" align="left" valign="top"><?php do { ?>
                                      <table border="0" cellpadding="0" cellspacing="0" class="q">
                                        <tr>
                                          <td><a href="shareshowlage.php?<?php echo $MM_keepURL.(($MM_keepURL!="")?"&":"")."ap_id=".urlencode($row_RecPhoto['ap_id']) ?>"> <img src="backstage/share/<?php echo $row_RecPhoto['ap_picurl']; ?>"  width="80" height="80" border="0" /> <br /> <?php echo $row_RecPhoto['ap_subject']; ?> </a>
                                          </td>
                                        </tr>
                                      </table> <?php } while ($row_RecPhoto = mysql_fetch_assoc($RecPhoto)); ?>
                                    </td>
                                  </tr>
                                </table> <?php } // Show if recordset not empty ?>
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
            <td align="center"><span style="background-position: center; background-image: url(img/third/dn_bar.gif); font-size: 12px; color: #FFF; font-family: '微軟正黑體';">版權所有◎2010 超媒體管家企業有限公司</span>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
