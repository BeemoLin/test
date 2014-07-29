<?php
require_once('define.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
require_once(CONNSQL);
require_once(PAGECLASS);

$logoutAction = 'logout.php';
$currentPage = $_SERVER["PHP_SELF"];

$maxRows_RecUer = 5;
$pageNum_RecUer = 0;
if (isset($_GET['pageNum_RecUer'])) {
  $pageNum_RecUer = $_GET['pageNum_RecUer'];
}
$startRow_RecUer = $pageNum_RecUer * $maxRows_RecUer;

$colname_RecUer = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUer = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUer = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUer, "text"));
$query_limit_RecUer = sprintf("%s LIMIT %d, %d", $query_RecUer, $startRow_RecUer, $maxRows_RecUer);
$RecUer = mysql_query($query_limit_RecUer, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUer);

if (isset($_GET['totalRows_RecUer'])) {
  $totalRows_RecUer = $_GET['totalRows_RecUer'];
} else {
  $all_RecUer = mysql_query($query_RecUer);
  $totalRows_RecUer = mysql_num_rows($all_RecUer);
}
$totalPages_RecUer = ceil($totalRows_RecUer/$maxRows_RecUer)-1;

$maxRows_RecInfo = 10;
$pageNum_RecInfo = 0;
if (isset($_GET['pageNum_RecInfo'])) {
  $pageNum_RecInfo = $_GET['pageNum_RecInfo'];
}
$startRow_RecInfo = $pageNum_RecInfo * $maxRows_RecInfo;

mysql_select_db($database_connSQL, $connSQL);
$query_RecInfo = "SELECT * FROM info ORDER BY info_id ASC";
$query_limit_RecInfo = sprintf("%s LIMIT %d, %d", $query_RecInfo, $startRow_RecInfo, $maxRows_RecInfo);
$RecInfo = mysql_query($query_limit_RecInfo, $connSQL) or die(mysql_error());

if (isset($_GET['totalRows_RecInfo'])) {
  $totalRows_RecInfo = $_GET['totalRows_RecInfo'];
}
else {
  $all_RecInfo = mysql_query($query_RecInfo);
  $totalRows_RecInfo = mysql_num_rows($all_RecInfo);
}
$totalPages_RecInfo = ceil($totalRows_RecInfo/$maxRows_RecInfo)-1;

$queryString_RecInfo = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecInfo") == false && stristr($param, "totalRows_RecInfo") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecInfo = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecInfo = sprintf("&totalRows_RecInfo=%d%s", $totalRows_RecInfo, $queryString_RecInfo);

$queryString_RecUer = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_RecUer") == false &&
    stristr($param, "totalRows_RecUer") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_RecUer = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_RecUer = sprintf("&totalRows_RecUer=%d%s", $totalRows_RecUer, $queryString_RecUer);
?>
<?php
function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true){
  GLOBAL $maxRows_RecInfo,$totalRows_RecInfo;
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
          if ($_get_name != "pageNum_RecInfo") {
            $_get_vars .= "&$_get_name=$_get_value";
          }
        }
      }
      $successivo = $pageNum_Recordset1+1;
      $precedente = $pageNum_Recordset1-1;
      $firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecInfo=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
      # ----------------------
      # page numbers
      # ----------------------
      for($a = $fgp+1; $a <= $egp; $a++){
        $theNext = $a-1;
        if($show_page)
        {
          $textLink = $a;
        } else {
          $min_l = (($a-1)*$maxRows_RecInfo) + 1;
          $max_l = ($a*$maxRows_RecInfo >= $totalRows_RecInfo) ? $totalRows_RecInfo : ($a*$maxRows_RecInfo);
          $textLink = "$min_l - $max_l";
        }
        $_ss_k = floor($theNext/26);
        if ($theNext != $pageNum_Recordset1)
        {
          $pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecInfo=$theNext$_get_vars\">";
          $pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
        } else {
          $pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
        }
      }
      $theNext = $pageNum_Recordset1+1;
      $offset_end = $totalPages_Recordset1;
      $lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecInfo=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
    }
  }
  return array($firstArray,$pagesArray,$lastArray);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>資訊連結</title>
<link href="CSS/define.css" rel="stylesheet" type="text/css" />
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
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/rule_dn.gif','img/third/choose_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
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
                        <td>
                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td height="360" valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="21" height="30">&nbsp;</td>
                                          <!-- <td align="center" valign="middle">網站名稱</td> -->
                                          <td valign="middle">網站名稱</td>
                                        </tr>
                                        <tr>
                                          <td colspan="2" align="center" valign="middle" style="border: 0px solid white; border-top-width: 2px; border-bottom-width: 2px;"></td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <table width="747" border="0" cellspacing="0" cellpadding="0">
                                        <?php
                                      if (isset($RecInfo)){
                                        while ($row_RecInfo = mysql_fetch_assoc($RecInfo)) {
                                          ?>
                                        <tr onMouseOver="mark(this,'#000000','#FFFFFF')" onMouseOut="mark(this,'','#FFFFFF')">
                                          <!-- <td width="154" height="30">&nbsp;</td> -->
                                          <td width="21" height="30">&nbsp;</td>
                                          <td width="593"><a href="<?php echo $row_RecInfo['info_url']; ?>"> <?php echo $row_RecInfo['info_name']; ?> </a>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td height="1" colspan="4" style="border: 0px solid white; border-bottom-width: 1px;"></td>
                                        </tr>
                                        <?php 
                              }
                            }
                            ?>
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
                        <td height="30" align="right"><?php 
# variable declaration
$prev_RecInfo = "? 下一頁";
$next_RecInfo = "上一頁 ?";
$separator = " ";
$max_links = 10;
$pages_navigation_RecInfo = buildNavigation($pageNum_RecInfo,$totalPages_RecInfo,$prev_RecInfo,$next_RecInfo,$separator,$max_links,true); 

print $pages_navigation_RecInfo[0]; 
?> <?php print $pages_navigation_RecInfo[1]; ?> <?php print $pages_navigation_RecInfo[2]; ?>
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
