<?php
require_once('define.php');
$_SESSION['from_web'] = 'index.php';
require_once(CONNSQL);
require_once(PAGECLASS);

if (!function_exists("GetSQLValueString")) {
  require_once('includes/common.php');
}

if (isset($_GET['p_ip'])) {
  $qaz = trim($_GET['p_ip']);
  $sql = "SELECT m_username, m_passwd, m_level, m_id, count(*) as inname  FROM memberdata WHERE p_ip='$qaz' GROUP BY p_ip";
  mysql_select_db($database_connSQL, $connSQL);
  $result = mysql_query($sql,$connSQL) or die(mysql_error());
  $row = mysql_fetch_array($result);
  $loginFoundUser = mysql_num_rows($result);
  if ($row["inname"] != 1){
    header("Location: index.php");
    exit;
  }
  else{
    if ($loginFoundUser) {
      $_SESSION['MM_Username'] = trim($row["m_username"]);
      $_SESSION['MM_UserGroup'] = trim($row["m_level"]);
      $_SESSION['MM_UserID'] = trim($row["m_id"]);
      $_SESSION['enter_web'] = CONSTRUCTION_CASE;
      $_SESSION['from_web'] = "";
      $loginStrGroup = trim($row["m_level"]);
    // 計數器+1
    $now = date('Y-m-d H:i:s');
    $webcont__query ='
    INSERT INTO 
      `webcount` 
    SET
      `count_ip` = \''.$ip.'\', 
      `count_time` = \''.$now.'\'
    ';
    //die($webcont__query);
    $CountRS = mysql_query($webcont__query, $connSQL) or die(mysql_error());   
      header("Location: index2.php");
      exit;
    }
    else {
      $_SESSION['enter_web'] = "";
      $_SESSION['from_web'] = "";
      header("Location: index.php");
      exit;
    }
  }
}

$logoutAction = "logout.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>首頁</title>

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
</head>

<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
  <!--<table border="0" align="center" cellpadding="0" cellspacing="0" id="allpic">-->
    <?php //include('pic1_template.php'); ?>
    <?php //include('pic2_template.php'); ?>
    <?php include('layout/template.html'); ?>
    <!--<tr>
      <td height="390">
        <table border="0" cellpadding="0" cellspacing="0" id="pic3">
          <tr>
            <td>
              <table border="0" cellpadding="0" cellspacing="0" id="pic3_right">
                <tr>
                  <td align="left" valign="top"><br />
                    <table width="350" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <th align="center" width="350" height="300" style="background-repeat: no-repeat; background-image: url(img/btn2/login_bg4.gif);" scope="row">
                          <form action="login.php" id="form1" name="form1" method="post">
                            <div style="width: 350px; border: 0px; padding-top: 10px; border-collpase: collpase;">
                              <div style="margin-right: auto; margin-left: auto; width: 100%;">
                                <img src="img/life2/account.gif" width="50" height="30" style="vertical-align: middle;" /> <input name="username" type="text" class="logintext" id="username" />
                              </div>
                              <div>
                                <img src="img/life2/code.gif" width="50" height="30" style="vertical-align: middle;" /> <input name="password" type="password" class="logintext" id="password" />
                              </div>
                              <div>
                                <input name="button" type="submit" id="button" value="登入" />
                              </div>
                              <div>
                                <span class="white"> <span style="color: red;">※</span> <span>忘記密碼請洽櫃檯<?php //echo @$rename;?> </span> </span>
                              </div>
                            </div>
                          </form>
                        </th>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              <table border="0" cellpadding="0" cellspacing="0" id="pic3_left">
                <tr>
                  <td>&nbsp;</td>
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
  <table width="350" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <th scope="row"></th>
    </tr>
  </table>-->
</body>
</html>
