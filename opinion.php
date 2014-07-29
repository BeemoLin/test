<?php
require_once('define.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);
require_once(CONNSQL);
require_once(PAGECLASS);

$logoutAction = 'logout.php';


if (!function_exists("GetSQLValueString")) {
  include('includes/common.php');
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

$maxRows_RecOpinion = 10;
$pageNum_RecOpinion = 0;
if (isset($_GET['pageNum_RecOpinion'])) {
  $pageNum_RecOpinion = $_GET['pageNum_RecOpinion'];
}
$startRow_RecOpinion = $pageNum_RecOpinion * $maxRows_RecOpinion;

$colname_RecOpinion = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecOpinion = $_SESSION['MM_Username'];
}

$query_RecOpinion = sprintf("SELECT * FROM opinion WHERE opinion_name = %s ORDER BY opinion_date DESC", GetSQLValueString($colname_RecOpinion, "text"));
$query_limit_RecOpinion = sprintf("%s LIMIT %d, %d", $query_RecOpinion, $startRow_RecOpinion, $maxRows_RecOpinion);
$RecOpinion = mysql_query($query_limit_RecOpinion, $connSQL) or die(mysql_error());
$row_RecOpinion = mysql_fetch_assoc($RecOpinion);

if (isset($_GET['totalRows_RecOpinion'])) {
  $totalRows_RecOpinion = $_GET['totalRows_RecOpinion'];
} else {
  $all_RecOpinion = mysql_query($query_RecOpinion);
  $totalRows_RecOpinion = mysql_num_rows($all_RecOpinion);
}
$totalPages_RecOpinion = ceil($totalRows_RecOpinion/$maxRows_RecOpinion)-1;




function buildNavigation($pageNum_Recordset1,$totalPages_Recordset1,$prev_Recordset1,$next_Recordset1,$separator=" | ",$max_links=10, $show_page=true){
  GLOBAL $maxRows_RecOpinion,$totalRows_RecOpinion;
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
          if ($_get_name != "pageNum_RecOpinion") {
            $_get_vars .= "&$_get_name=$_get_value";
          }
        }
      }
      $successivo = $pageNum_Recordset1+1;
      $precedente = $pageNum_Recordset1-1;
      $firstArray = ($pageNum_Recordset1 > 0) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecOpinion=$precedente$_get_vars\">$prev_Recordset1</a>" :  "$prev_Recordset1";
      # ----------------------
      # page numbers
      # ----------------------
      for($a = $fgp+1; $a <= $egp; $a++){
        $theNext = $a-1;
        if($show_page)
        {
          $textLink = $a;
        } else {
          $min_l = (($a-1)*$maxRows_RecOpinion) + 1;
          $max_l = ($a*$maxRows_RecOpinion >= $totalRows_RecOpinion) ? $totalRows_RecOpinion : ($a*$maxRows_RecOpinion);
          $textLink = "$min_l - $max_l";
        }
        $_ss_k = floor($theNext/26);
        if ($theNext != $pageNum_Recordset1)
        {
          $pagesArray .= "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecOpinion=$theNext$_get_vars\">";
          $pagesArray .= "$textLink</a>" . ($theNext < $egp-1 ? $separator : "");
        } else {
          $pagesArray .= "$textLink"  . ($theNext < $egp-1 ? $separator : "");
        }
      }
      $theNext = $pageNum_Recordset1+1;
      $offset_end = $totalPages_Recordset1;
      $lastArray = ($pageNum_Recordset1 < $totalPages_Recordset1) ? "<a href=\"$_SERVER[PHP_SELF]?pageNum_RecOpinion=$successivo$_get_vars\">$next_Recordset1</a>" : "$next_Recordset1";
    }
  }
  return array($firstArray,$pagesArray,$lastArray);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>意見分享</title>
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
.qqq {
   text-align: center;
}

.s {
   color: #FFF;
   font-family: "微軟正黑體";
}

-->
</style>
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif','img/BTN/add_dn.png')">
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
                                    <td align="left"><a href="opinionadd.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image26','','img/BTN/add_dn.png',1)"> <img src="img/BTN/add_up.png"  name="Image26" width="130" height="30" border="0" id="Image26" /> </a>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td>
                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                          <td width="19">&nbsp;</td>
                                          <td width="400" valign="middle">標題</td>
                                          <td width="90" align="center" valign="middle">處理狀態</td>
                                          <td width="238" align="center" valign="middle">日期</td>
                                        </tr>
                                        <tr>
                                          <td colspan="4" align="center" valign="middle" style="border: 0px solid white; border-top-width: 2px; border-bottom-width: 2px;"></td>
                                        </tr>
                                      </table>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td><?php if ($totalRows_RecOpinion > 0) { // Show if recordset not empty ?>
                                      <table width="747" border="0" cellspacing="0" cellpadding="0">
                                        <?php do { ?>
                                        <tr onMouseOver="mark(this,'#000000','#FFFFFF')" onMouseOut="mark(this,'','#FFFFFF')">
                                          <td width="19" height="30">&nbsp;</td>
                                          <td width="400"><a href="opinionsee.php?opinion_id=<?php echo $row_RecOpinion['opinion_id']; ?>"> <?php echo $row_RecOpinion['opinion_type']; ?> </a>
                                          </td>
                                          <td width="90" align="left"><?php /*start db_input script*/ if ($row_RecOpinion['opinion_response'] != ""){ ?> <img src="img/img/ans.png"  width="50" height="25" border="0" /> <?php } /*end db_input script*/ else {?> <img src="img/img/no_ans.png"  width="50" height="25" border="0" /> <?php } ?>
                                          </td>
                                          <td width="238" align="center"><?php echo $row_RecOpinion['opinion_date']; ?>
                                          </td>
                                        </tr>
                                        <td height="1" colspan="4" style="border: 0px solid white; border-bottom-width: 1px;"></td>
                                        <?php } while ($row_RecOpinion = mysql_fetch_assoc($RecOpinion)); ?>
                                      </table> <?php } // Show if recordset not empty ?>
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
$prev_RecOpinion = "« 上一頁";
$next_RecOpinion = "下一頁 »";
$separator = " ";
$max_links = 10;
$pages_navigation_RecOpinion = buildNavigation($pageNum_RecOpinion,$totalPages_RecOpinion,$prev_RecOpinion,$next_RecOpinion,$separator,$max_links,true); 

print $pages_navigation_RecOpinion[0]; 
?> <?php print $pages_navigation_RecOpinion[1]; ?> <?php print $pages_navigation_RecOpinion[2]; ?>
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
