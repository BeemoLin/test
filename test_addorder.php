<?php
require_once('define.php'); 
require_once(CONNSQL);
require_once(PAGECLASS);
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **

$logoutAction = 'logout.php';

$ra_name = $_GET['name'];
//$ra_name = urldecode($ra_name);
$ra_id = $_GET['rulepic_id'];
$nowday = date('d');
$mmm = date('m');
$yyy = date('Y');

if (!function_exists("GetSQLValueString")) {
  include('includes/common.php');
}

if ((isset($_GET['order_id'])) && ($_GET['order_id'] != "") && (isset($_GET['dele']))) {
  $deleteSQL = sprintf("DELETE FROM order_all WHERE order_id=%s", GetSQLValueString($_GET['order_id'], "int"));
  $Result1 = mysql_query($deleteSQL, $connSQL) or die(mysql_error());

  $deleteGoTo = "test_addorder.php?year=" . $yyy . "&month=" . $mmm . "&day=" . $nowday . "&rulepic_id=" . $ra_id . "&name=" . $ra_name;
  header(sprintf("Location: %s", $deleteGoTo));
  exit();
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . $_SERVER['QUERY_STRING'];
}

if ((isset($_GET["MM_insert"])) && ($_GET["MM_insert"] == "form1")) {
  if(isset($_GET['order_time'])){
    $insertSQL = sprintf("INSERT INTO order_all (`year`, `month`, `day`, name, rulepic_id, order_name, order_time, o_time) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)", GetSQLValueString($_GET['year'], "int"), GetSQLValueString($_GET['month'], "int"), GetSQLValueString($_GET['day'], "text"), GetSQLValueString($_GET['name'], "text"), GetSQLValueString($_GET['rulepic_id'], "text"), GetSQLValueString($_GET['order_name'], "text"), GetSQLValueString($_GET['order_time'], "text"), GetSQLValueString($_GET['o_time'], "int"));
    $Result1 = mysql_query($insertSQL, $connSQL) or die(mysql_error());
    
    
    
    $query = "SELECT * FROM adminuser WHERE `allname`='公設預約通知名單'";
    $result = mysql_query($query, $connSQL) or die(mysql_error());
    $list = mysql_fetch_array($result);
		include('system/PHPMailer_v5.1/class.phpmailer.php');
		$message = file_get_contents(EMAIL_TEMPLATES.'/order_notice.html');

		$message = str_replace('[c_subject]', 	C_SUBJECT, $message);
		$message = str_replace('[username]',	$_GET['order_name'], $message);
		$message = str_replace('[name]', 		$_GET['name'], $message);
		$message = str_replace('[date]', 		$_GET['o_time'], $message);
		$message = str_replace('[time]', 		$_GET['order_time'], $message);

		// Setup PHPMailer
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->Host = 'msa.hinet.net';
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64"; // is this necessary?
		//$mail->SMTPAuth = true;
		//$mail->Username = 'service.tcwa@hinet.net';
		//$mail->Password = 'da909088';
		$mail->SetFrom('service.tcwa@hinet.net', C_SUBJECT);

		$mailto= explode(',', $list['mail']);
		foreach ($mailto as $mrs){
			$mail->AddAddress($mrs);
		}
		$mail->Subject = C_SUBJECT."".$_GET['order_name'].' 公設預約通知';
		$mail->MsgHTML($message);
		//$mail->AltBody(strip_tags($message));
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		}
    
    $insertGoTo = "test_order_reday.php?rulepic_id=" . $ra_id . "&name=" . $_GET['name'];
    header(sprintf("Location: %s", $insertGoTo));
    exit();
  }
  else{
    $insertGoTo = "test_addorder.php?rulepic_id=" . $ra_id . "&name=" . $ra_name;
    header(sprintf("Location: %s", $insertGoTo));
    exit();
  }
}

$colname_RecUser = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_RecUser = $_SESSION['MM_Username'];
}
$query_RecUser = sprintf("SELECT m_id, m_name, m_nick, m_username FROM memberdata WHERE m_username = %s", GetSQLValueString($colname_RecUser, "text"));
$RecUser = mysql_query($query_RecUser, $connSQL) or die(mysql_error());
$row_RecUser = mysql_fetch_assoc($RecUser);

$query_Recordset1 = "SELECT * FROM adminuser WHERE `allname`='公設預約通知名單'";
$Recordset1 = mysql_query($query_Recordset1, $connSQL) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>公設預約</title>
    <style type="text/css">
      <!--
      body {
        background-image: url();
        background-repeat: no-repeat;
        margin-left: 0px;
        margin-top: 0px;
        background-color: #000;
      }
      .all {
        background-image: url(img/third/backgrondreal.jpg);
        font-family: "微軟正黑體";
      }
      .ggg {
        line-height: 20px;
      }
      .white {
        color: #FFF;
        font-family: "微軟正黑體";
      }
      .all tr th table tr th {
      }
      .red {
        color: #F00;
      }
      .green {
        color: #0F0;
      }
      -->
    </style>
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
        function goLink(){
          //href
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
        left: -246px;
        top: 88px;
        visibility: hidden;
      }
      #apDiv3 {
        position:absolute;
        width:200px;
        height:140px;
        z-index:2;
        left: 306px;
        top: 271px;
        visibility: hidden;
      }
      .qqq {
        font-family: "微軟正黑體";
        font-size: 20px;
      }
      #apDiv4 {
        position:absolute;
        width:250px;
        height:167px;
        z-index:2;
        left: 157px;
        top: 310px;
        visibility: hidden;
      }
      #apDiv5 {
        position:absolute;
        width:200px;
        height:115px;
        z-index:3;
        visibility: hidden;
      }
      form{
        margin:0px;
        padding:0px;
      }
      td{
        text-align:center;
      }
      -->
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  </head>

  <body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/rule_dn.gif','img/third/choose_dn.gif','img/third/arrow_up(3).gif')">
    <table width="770" border="0" align="center" cellpadding="0" cellspacing="0" class="all">
      <tr>
        <th height="77" scope="row">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="175px"><a href="http://www.chingjia.com" ><img border="0" src="img/third/LOGO.gif" /></a></th>
              <td width="180px"><img src="img/third/cc77.gif" /></td>
              <td>
                <table width="270" border="0" align="right" cellpadding="0" cellspacing="0">
                  <tr>
                    <th width="180" height="32" align="left" scope="row"><img src="img/third/green_yes.gif" width="30" height="30" align="absbottom" /><span class="white"><?php echo $row_RecUser['m_username']; ?><img src="img/life2/HI.gif" width="50" height="30" align="absbottom" /></span></th>
                    <td width="110"><a href="indexre.php?<?php echo "m_username=" . $row_RecUser['m_username'] ?>"><img src="img/BTN/re.gif" alt="" width="110" height="30" border="0" /></a></td>
                  </tr>
                  <tr>
                    <th width="180" height="34" align="left" scope="row"><img src="img/third/in.gif" width="30" height="30" align="absbottom" /><a href="<?php echo $logoutAction ?>"><img src="img/life2/guest_out.gif" width="80" height="30" border="0" align="absbottom" /></a></th>
                    <td width="110" align="right"><img src="img/third/home.gif" width="30" height="30" align="absbottom" /><a href="index2.php"><img src="img/life2/FP.gif" width="50" height="30" border="0" align="absbottom" /></a></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </th>
      </tr>
      <tr>
        <th height="103" scope="row">
          <table width="770" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <th width="10" height="91" scope="row">&nbsp;</th>
              <td width="95" align="center"><a href="announcement.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image2','','img/third/btn_ bulletin_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_ bulletin_up.gif" name="Image2" width="90" height="90" border="0" id="Image2" /></a></td>
              <td width="95" align="center" valign="middle"><a href="opinion.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image3','','img/third/btn_opinion_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_opinion_up.gif" name="Image3" width="90" height="90" border="0" id="Image3" /></a></td>
              <td width="95" align="center"><a href="order.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image4','','img/third/btn_equipment_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_equipment_dn.gif" name="Image4" width="90" height="90" border="0" id="Image4" /></a></td>
              <td width="95" align="center"><a href="mail.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image5','','img/third/btn_package_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_package_up.gif" name="Image5" width="90" height="90" border="0" id="Image5" /></a></td>
              <td width="95" align="center"><a href="life.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image6','','img/third/btn_food_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_food_up.gif" name="Image6" width="90" height="90" border="0" id="Image6" /></a></td>
              <td width="95" align="center"><a href="photos.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image7','','img/third/btn_photo_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_photo_up.gif" name="Image7" width="90" height="90" border="0" id="Image7" /></a></td>
              <td width="95" align="center"><a href="money.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image8','','img/third/btn_mony_dn.gif',1);MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/btn_mony_up.gif" name="Image8" width="90" height="90" border="0" id="Image8" /></a></td>
              <td width="95" align="center"><a href="online.php" onmouseover="MM_swapImage('Image9','','img/third/btn_fix_dn.gif',1)" onmouseout="MM_swapImgRestore()"><img src="img/third/btn_fix_up.gif" name="Image9" width="90" height="90" border="0" id="Image9" /></a></td>
              <td width="30">
                <div id="apDiv1">
                  <div id="apDiv2">
                    <table width="290" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th width="5" align="left" valign="top" bgcolor="#000000" scope="row"><a href="javascript:;" onmouseover="MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/side.gif" alt="a" width="3" height="95" vspace="0" border="0" align="left" /></a></th>
                        <td height="95" bgcolor="#000000"><a href="QandA.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image15','','img/third/btn_list_dn.gif',1)"><img src="img/third/btn_list_up.gif" alt="a" name="Image15" width="90" height="90" border="0" id="Image15" /></a></td>
                        <td width="5" bgcolor="#000000">&nbsp;</td>
                        <td bgcolor="#000000"><a href="rule.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image17','','img/third/btn_rule_dn.gif',1)"><img src="img/third/btn_rule_up.gif" alt="a" name="Image17" width="90" height="90" border="0" id="Image17" /></a></td>
                        <td width="5" bgcolor="#000000">&nbsp;</td>
                        <td bgcolor="#000000"><a href="info.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image16','','img/third/btn_info_dn.gif',1)"><img src="img/third/btn_info_up.gif" alt="a" name="Image16" width="90" height="90" border="0" id="Image16" /></a></td>
                        <td width="5" bgcolor="#000000"><a href="javascript:;" onmouseover="MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/side.gif" alt="a" width="3" height="95" vspace="0" border="0" align="right" /></a></td>
                      </tr>
                      <tr>
                        <th height="3" colspan="7" align="left" valign="top" scope="row"><a href="javascript:;" onmouseover="MM_showHideLayers('apDiv1','','show','apDiv2','','hide')"><img src="img/third/side2.gif" alt="a" width="290" height="3" border="0" /></a></th>
                      </tr>
                      <tr>
                        <th height="9" colspan="7" align="center" valign="top" scope="row">&nbsp;</th>
                      </tr>
                    </table>
                  </div>
                  <a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image23','','img/third/arrow_up(3).gif',1)">
                    <img src="img/third/arrow_dn(3).gif" name="Image23" width="30" height="70" border="0" id="Image23" onmousedown="MM_showHideLayers('apDiv2','','show')" />
                  </a>
                </div>
              </td>
            </tr>
          </table>
        </th>
      </tr>
      <tr>
        <th height="389" align="left" valign="top" style="height: 389px; color: #FFF;" scope="row">
          <table width="100%" height="368" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <th width="300" height="368" align="center" valign="top" style="" scope="row">&nbsp;　　　　　　
                <p class="qqq"><?php echo $_GET['name']; ?>。請選擇想預約的時間 </p>
                <table width="502" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <th scope="row"> 
                      <div align="center">
                        <?php
                        if (!empty($_GET['year'])) {
                          if (is_int((int) $_GET['year'])) {
                            $year = $_GET['year'];
                          }
                        } else {
                          $year = date("Y");
                        }

                        if (!empty($_GET['month'])) {
                          if (is_int((int) $_GET['month'])) {
                            $month = $_GET['month'];
                          }
                        } else {
                          $month = date("n");
                        }
                        if (!empty($_GET['day'])) {
                          if (is_int((int) $_GET['day'])) {
                            $day = $_GET['day'];
                          }
                        } else {
                          $day = date("j");
                        }
                        if ($year < 1971) {//年度最少到1971年，小於1971年，則需回到今年的日曆
                          echo "<p>已至尾端，請回原頁面</p>\n";
                          echo "<a href=$_SERVER[PHP_SELF]>回原頁面</a>\n"; //$_SERVER[PHP_SELF]為執行伺服器預定變數，當前正在執行腳本的文件名。
                          exit();
                        }
                        ?>
                        <table class="calendar_table1" border="1" cellpadding="0" cellspacing="0">
                          <tr align="center">
                            <td colspan="2">
                              <?php
//<---------上一年,下一年,上月,下月;開始--------->
                              echo "<a href=$_SERVER[PHP_SELF]?year=" . ($year - 1) . "&month=" . $month . "&rulepic_id=" . $ra_id . "&name=" . $_GET['name'] . "><font color=\"yellow\">&lt;&lt;</font></a>\n";
                              echo $year . "\n";
                              echo "<a href=$_SERVER[PHP_SELF]?year=" . ($year + 1) . "&month=" . $month . "&rulepic_id=" . $ra_id . "&name=" . $_GET['name'] . "><font color=\"yellow\">&gt;&gt;</font></a>\n"; //上下年
                              ?>
                            </td>
                            <td colspan="3">&nbsp;</td>
                            <td colspan="2">
                              <?php
                              if (($month - 1) < 1) {
                                $my_month = 12;
                                $my_year = $year - 1;
                              } else {
                                $my_month = $month - 1;
                                if($my_month<10){
                                  $my_month = '0'.$my_month;
                                }
                                $my_year = $year;
                              }
                              echo "<a href=$_SERVER[PHP_SELF]?month=" . $my_month . "&year=" . $my_year . "&rulepic_id=" . $ra_id . "&name=" . $_GET['name'] . "><font color=\"yellow\">&lt;&lt;</font></a>\n";

                              echo $month . "\n";

                              if (($month + 1) > 12) {
                                $my_month = '01';
                                $my_year = $year + 1;
                              } else {
                                $my_month = $month + 1;
                                if($my_month<10){
                                  $my_month = '0'.$my_month;
                                }
                                $my_year = $year;
                              }
                              echo "<a href=$_SERVER[PHP_SELF]?month=" . $my_month . "&year=" . $my_year . "&rulepic_id=" . $ra_id . "&name=" . $_GET['name'] . "><font color=\"yellow\">&gt;&gt;</font></a>\n"; //上下月
//<--------上一年,下一年,上月,下月;結束--------->
                              ?>
                            </td>
                          </tr>

                          <?php
                          echo '<tr align=center class="week_text">';
                          echo "<td class='red_text'>星期日</td><td>星期一</td><td>星期二</td><td>星期三</td><td>星期四</td><td>星期五</td><td>星期六</td>\n";
                          echo "</tr>\n";
//echo "<tr>";
                          $FirstDay = date("w", mktime(0, 0, 0, $month, 1, $year)); //取得任何一個月的一號是星期幾，來計自一號從第幾格開始。
                          $bgtoday = date("d");

                          function font_color($month, $today, $year) {//計算星期天的字體顏色。
                            $sunday = date("w", mktime(0, 0, 0, $month, $today, $year));
                            if ($sunday == "0") {
                              $FontColor = "red";
                            } else {
                              $FontColor = "while";
                            }
                            return $FontColor;
                          }

                          function bgcolor($month, $bgtoday, $today_i, $year) {//計算當日的背景顏色。
                            if (($bgtoday == $today_i) && ($month == date("n")) && ($year == date("Y"))) {
                              $bgcolor = "bgcolor=#6699FF";
                            } else {
                              $bgcolor = "";
                            }
                            return $bgcolor;
                          }

                          echo "<tr>\n";
                          $countMonth = date("t", mktime(0, 0, 0, $month, 1, $year)); //某月的總天數
                          for ($i = 0; $i < $FirstDay; $i++) {
                            echo "<td align=center>&nbsp;</td>\n"; //填滿空白
                          }
                          for ($i = 1; $i <= $countMonth; $i++) {//輸出由1號直至月尾的所有號數
                            if ($i != 1) {
                              if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 0) {//判斷該日是否星期日
                                echo "<tr>\n";
                              }
                            }
                            if($i<10){
                              $ii='0'.$i;
                            }
                            else{
                              $ii=$i;
                            }
                            echo "<td align=center " . bgcolor($month, $bgtoday, $i, $year) . "><a href=$_SERVER[PHP_SELF]?name=" . $_GET['name'] . "&rulepic_id=" . $_GET['rulepic_id'] . "&order_name=" . $_SESSION['MM_Username'] . "&month=" . $month . "&year=" . $year . "&day=" . $ii . "><font color=" . font_color($month, $ii, $year) . ">";
                            echo $ii;
                            echo "</font></a></td>\n";
                            if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 6) {//判斷該日是否星期六
                              echo "</tr>\n";
                            }
                          }
                          if (date("w", mktime(0, 0, 0, $month, $countMonth, $year)) != 6) {//判斷該日不是否星期六
                            for ($i = $countMonth + 1; $i < 42; $i++) {
                              echo "<td align=center>&nbsp;</td>\n"; //填滿空白
                              if (date("w", mktime(0, 0, 0, $month, $i, $year)) == 6) {//判斷該日是否星期六
                                echo "</tr>\n";
                                break;
                              }
                            }
                          }
                          ?>
                        </table>
                      </div>
                    </th>
                  </tr>
                </table>
              </th>
              <th width="35%" height="368" align="center" valign="top" style="" scope="row">
                <p>&nbsp;</p>
                <form action="<?php echo $editFormAction; ?>" id="form1" name="form1" method="get">
                  <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>" />
                  <input type="hidden" name="rulepic_id" value="<?php echo $_GET['rulepic_id']; ?>" />
                  <input type="hidden" name="order_name" value="<?php echo $_SESSION['MM_Username']; ?>" />
                  <input type="hidden" name="o_time" value="<?php echo $year . $month . $day; ?>" />
                  <input type="hidden" name="year" value="<?php echo $year; ?>" />
                  <input type="hidden" name="month" value="<?php echo $month; ?>" />
                  <input type="hidden" name="day" value="<?php echo $day; ?>" />
                  <table width="100%" border="0" align="left" cellspacing="0" cellpadding="0">
                    <tr>
                      <th align="center" scope="row">
                        <table width="265" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <th width="265">
                              <font><?php echo $year . "-" . $month . "-" . $day; ?></font><br />
                              <font>預約時段</font>
                            </th>
                          </tr>
                          <?php
//echo date("G:i:s");
                          $str = $year . "-" . $month . "-" . $day . " 23:59:59"; //<====這裡要用資料庫裡的日期取代
                          $that_time = strtotime($str);
                          $this_time = mktime();
                          $diff01 = ($that_time - $this_time);

                          if ($diff01 <= 0) {
                            echo "<script>alert('請選擇今天以後的時間');</script>";
                            echo '
                            <tr>
                              <th width="265">
                                <font color=green>請選擇今天以後的時間</font>
                              </th>
                            </tr>
                            ';
                          } else {
                            $sql = "
                            SELECT COUNT(1) as quantity
                            FROM `order_all`
                            WHERE 1
                            AND `year` = '$year'
                            AND `month` = '$month'
                            AND `day` = '$day'
                            AND `name` = '" . $_GET['name'] . "'
                            AND `order_name` = '" . $_SESSION['MM_Username'] . "'
                            ";
                            $Result02 = mysql_query($sql) or die(mysql_error());
                            $row = mysql_fetch_assoc($Result02);
                          
                            if($row['quantity']>0){
                              echo "<script>alert('你已經預約過了');</script>";
                              echo '
                              <tr>
                                <th width="265">
                                  <font color=green>如果要更改預約時段，<br />請先刪除預約資料</font>
                                </th>
                              </tr>
                              ';
                            ?>
                            <tr>
                              <td>
                                <input type="button" name="button" id="button" onclick="location.href='test_order_reday.php?rulepic_id=<?php echo $_GET['rulepic_id'];?>&name=<?php echo $_GET['name'];?>'" value="確定" />
                              </td>
                            </tr>
                            <?php  
                            }
                            else{
                              $set_time = array('08:00', '10:00', '12:00', '14:00', '16:00', '18:00', '20:00', '22:00');
                              $no=count($set_time)-2;
                              $i = 0;
                              foreach ($set_time as $value) {
                                $str = $year . "-" . $month . "-" . $day . " " . $set_time[$i]; //<====這裡要用資料庫裡的日期取代
                                $that_time = strtotime($str);
                                $this_time = mktime();
                                $diff02 = ($that_time - $this_time);
                                if ($diff02 < 0) {
                                  echo '
                                  <tr>
                                    <th width="265" align="left" scope="row">
                                      <input  name="order_time" type="radio" id="radio10" value="' . $set_time[$i] . '~' . $set_time[$i + 1] . '" disabled="disabled"/>
                                      ' . $set_time[$i] . '~' . $set_time[$i + 1] . '
                                      <font color=red>停止預約</font>
                                    </th>
                                  </tr>
                                ';
                                } else {
                                  $sql = "
                                  SELECT COUNT(1) as quantity
                                  FROM `order_all`
                                  WHERE 1
                                  AND `year` = '$year'
                                  AND `month` = '$month'
                                  AND `day` = '$day'
                                  AND `name` = '" . $_GET['name'] . "'
                                  AND `order_time` = '" . $set_time[$i] . "~" . $set_time[$i + 1] . "'
                                  ";
                                  //die($sql);
                                  $Result01 = mysql_query($sql) or die(mysql_error());
                                  $row = mysql_fetch_assoc($Result01);
                                  if ($row['quantity'] > 0) {
                                    $sql = "
                                    SELECT COUNT(1) as quantity
                                    FROM `order_all`
                                    WHERE 1
                                    AND `year` = '$year'
                                    AND `month` = '$month'
                                    AND `day` = '$day'
                                    AND `name` = '" . $_GET['name'] . "'
                                    AND `order_time` = '" . $set_time[$i] . "~" . $set_time[$i + 1] . "'
                                    AND `order_name` = '" . $_SESSION['MM_Username'] . "'
                                    ";
                                    $Result02 = mysql_query($sql) or die(mysql_error());
                                    $self = mysql_fetch_assoc($Result02);
                                    //die($self['quantity']);
                                    if ($self['quantity'] > 0) {
                                      $Reservation = '己預約';
                                      $disable = 'disabled="disabled"';
                                      $color = 'color=yellow';
                                    } else {
                                      $Reservation = '後補，可預約';
                                      $disable = '';
                                      $color = 'color=green';
                                    }
                                  } else {
                                    $Reservation = '可預約';
                                    $disable = '';
                                    $color = 'color=green';
                                  }
                                  echo '
                                  <tr>
                                    <th width="265" align="left" scope="row">
                                      <input name="order_time" type="radio" id="radio' . $i . '" value="' . $set_time[$i] . '~' . $set_time[$i + 1] . '" ' . $disable . ' />
                                      ' . $set_time[$i] . '~' . $set_time[$i + 1] . '
                                      <font ' . $color . '>' . $Reservation . '</font>
                                    </th>
                                  </tr>
                                ';
                                }
                                $i++;
                                if ($i > $no) {
                                  break;
                                }
                              }
                            ?>
                            <tr>
                              <td>
                                <input type="submit" name="button" id="button" value="確定" />
                              </td>
                            </tr>
                            <?php                              
                            }
                          }
                          ?>
                        </table>
                      </th>
                    </tr>
                  </table>
                  <input type="hidden" name="MM_insert" value="form1" />
                </form>
              </th>
            </tr>
          </table>
        </th>
      </tr>
      <tr>
        <th height="29" style="background-position: center; background-image: url(img/third/dn_bar.gif); font-size: 12px; color: #FFF; font-family: '微軟正黑體';" scope="row">&nbsp;</th>
      </tr>
    </table>
  </body>
</html>

