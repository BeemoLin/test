<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);

$logoutAction = 'logout.php';

if (!function_exists("GetSQLValueString")) {
  include('includes/common.php');
}

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
mysql_select_db($database_connSQL, $connSQL);
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);


mysql_select_db($database_connSQL, $connSQL);
$query_Recordset1 = "SELECT * FROM adminuser";
$Recordset1 = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);

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
function tfm_makeAllLinksConfirmable(classname, exceptionclass, message) {
	if(message == "") message = "Ok to continue?";
	for(var i=0; i < document.links.length; i++) {
		if(classname == "" || document.links[i].className == classname)
			if(exceptionclass == "" || document.links[i].className != exceptionclass)
				document.links[i].onclick = function() {
					return (confirm(message));
				}
	}
}
function check_all(){
n1 = document.form1.opinion_type.value.length;
n2 = document.form1.opinion_content.value.length;
    if( n1 <= 2 ){
      alert('標題最少三個字');
    }
    else if ( n2 <= 2 ){
      alert('內容最少三個字');
    }
    else{
      document.form1.submit();
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
                  <td valign="top">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                      <tr valign="top">
                        <td width="702" align="left" valign="top" style="background: url(images/newsback.png); background-position: bottom right; background-repeat: no-repeat; color: #FFF;">
                          <form action="opinion/sendmail.php" method="post" name="form1" id="form1">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td height="35" colspan="2"><span class="org"> <img src="img/img/q_BTN.png"  align="absmiddle" />新增意見反應</span>
                                </td>
                              </tr>
                              <tr>
                                <td width="50%" height="30" align="right"><span class="s"> <input name="opinion_name" type="hidden" id="opinion_name" value="<?php echo $row_RecUser['m_username']; ?>" size="15" readonly="readonly" /> 住戶名稱：<?php echo $row_RecUser['m_username']; ?> </span>
                                </td>
                                <td width="50%" align="center"><span class="s"> <input name="opinion_date" type="hidden" id="opinion_date" value="<?php echo date("Y-m-d H:i:s");?>" readonly="readonly" /> 日期：<?php echo date("Y-m-d H:i:s");?> </span>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2">
                                  <hr />
                                </td>
                              </tr>
                              <tr>
                                <td height="204" colspan="2" align="center" valign="top">
                                  <table width="500" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td class="s">&nbsp;</td>
                                      <td class="s">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="center" class="s">標題：</td>
                                      <td align="left" class="s">
                                        <p>
                                          <input name="opinion_type" type="text" id="opinion_type" size="40" />
                                        </p>
                                      </td>
                                    </tr>
                                    <tr>
                                      <td width="117" align="center" valign="top" class="s">
                                        <p>內容：</p>
                                        <p>&nbsp;</p>
                                      </td>
                                      <td width="383" align="left" class="s"><textarea name="opinion_content" cols="45" rows="10" id="opinion_content">
</textarea>
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                            <p>
                              <span class="s"> <input name="button" type="button" id="button" onclick="check_all()" value="送出資料" /> <input type="button" name="button2" id="button2" onclick="window.history.back()" value="回上一頁" /> </span>
                            </p>
                          </form>
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

