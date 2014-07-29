<?php
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
 $nowtime=date("Y-m-d H:i:s"); 					//設定代表目前時間的變數
 //if(!isset($_SESSION['Counter'])){ 				//檢查Session值是否存在
 mysql_select_db($database_connSQL, $connSQL);	//連結資料庫
 $userIP=$_SERVER['REMOTE_ADDR']; 			//收集瀏覽者的IP
 $insertCommand="INSERT INTO webcount (count_id, count_ip,count_time)
 VALUES (NULL, '$userIP', '$nowtime')"; 	//新增資料的SQL字串
 mysql_query($insertCommand,$connSQL); 	//執行webcount資料庫的新增
 $_SESSION['Counter'] = 1;  					//設定Session值
 //}
 */
require_once('includes/authorization.php');
$_SESSION['from_web'] = basename($_SERVER[SCRIPT_FILENAME]);

if (!function_exists("GetSQLValueString")) {
  require_once('includes/common.php');
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

$maxRows_RecNews = 2;
$pageNum_RecNews = 0;
if (isset($_GET['pageNum_RecNews'])) {
  $pageNum_RecNews = $_GET['pageNum_RecNews'];
}
$startRow_RecNews = $pageNum_RecNews * $maxRows_RecNews;

//新聞兩篇
mysql_select_db($database_connSQL, $connSQL);
$query_RecNews = "SELECT * FROM news_album ORDER BY album_date DESC";
$query_limit_RecNews = sprintf("%s LIMIT %d, %d", $query_RecNews, $startRow_RecNews, $maxRows_RecNews);
$RecNews = mysql_query($query_limit_RecNews, $connSQL) or die(mysql_error());
$row_RecNews = mysql_fetch_assoc($RecNews);

if (isset($_GET['totalRows_RecNews'])) {
  $totalRows_RecNews = $_GET['totalRows_RecNews'];
} else {
  $all_RecNews = mysql_query($query_RecNews);
  $totalRows_RecNews = mysql_num_rows($all_RecNews);
}
$totalPages_RecNews = ceil($totalRows_RecNews/$maxRows_RecNews)-1;

//食
mysql_select_db($database_connSQL, $connSQL);
$query_RecFood = "SELECT * FROM food ORDER BY food_date DESC";
$RecFood = mysql_query($query_RecFood, $connSQL) or die(mysql_error());
$row_RecFood = mysql_fetch_assoc($RecFood);
$totalRows_RecFood = mysql_num_rows($RecFood);
//衣
mysql_select_db($database_connSQL, $connSQL);
$query_RecColth = "SELECT * FROM cloth ORDER BY cloth_date DESC";
$RecColth = mysql_query($query_RecColth, $connSQL) or die(mysql_error());
$row_RecColth = mysql_fetch_assoc($RecColth);
$totalRows_RecColth = mysql_num_rows($RecColth);
//住
mysql_select_db($database_connSQL, $connSQL);
$query_RecLive = "SELECT * FROM living ORDER BY living_date DESC";
$RecLive = mysql_query($query_RecLive, $connSQL) or die(mysql_error());
$row_RecLive = mysql_fetch_assoc($RecLive);
$totalRows_RecLive = mysql_num_rows($RecLive);
//行
mysql_select_db($database_connSQL, $connSQL);
$query_RecWalk = "SELECT * FROM walk ORDER BY walk_date DESC";
$RecWalk = mysql_query($query_RecWalk, $connSQL) or die(mysql_error());
$row_RecWalk = mysql_fetch_assoc($RecWalk);
$totalRows_RecWalk = mysql_num_rows($RecWalk);
//育
mysql_select_db($database_connSQL, $connSQL);
$query_RecTeach = "SELECT * FROM teach ORDER BY teach_date DESC";
$RecTeach = mysql_query($query_RecTeach, $connSQL) or die(mysql_error());
$row_RecTeach = mysql_fetch_assoc($RecTeach);
$totalRows_RecTeach = mysql_num_rows($RecTeach);
//樂
mysql_select_db($database_connSQL, $connSQL);
$query_RecHappy = "SELECT * FROM happy ORDER BY happy_date DESC";
$RecHappy = mysql_query($query_RecHappy, $connSQL) or die(mysql_error());
$row_RecHappy = mysql_fetch_assoc($RecHappy);
$totalRows_RecHappy = mysql_num_rows($RecHappy);

/*  目前看不懂這是什麼，很有可能是空運算 如果到11月底程式是沒有問題的就刪了
 $cToday_RecTody = date("Y-m-d");
 mysql_select_db($database_connSQL, $connSQL);
 $query_RecTody = sprintf("SELECT * FROM webcount WHERE count_time LIKE %s", GetSQLValueString($cToday_RecTody . "%", "text"));
 $RecTody = mysql_query($query_RecTody, $connSQL) or die(mysql_error());
 $row_RecTody = mysql_fetch_assoc($RecTody);
 $totalRows_RecTody = mysql_num_rows($RecTody);

 $cThisMonth_RecThisMonth = date("Y-m");
 mysql_select_db($database_connSQL, $connSQL);
 $query_RecThisMonth = sprintf("SELECT * FROM webcount WHERE count_time LIKE %s", GetSQLValueString($cThisMonth_RecThisMonth . "%", "text"));
 $RecThisMonth = mysql_query($query_RecThisMonth, $connSQL) or die(mysql_error());
 $row_RecThisMonth = mysql_fetch_assoc($RecThisMonth);
 $totalRows_RecThisMonth = mysql_num_rows($RecThisMonth);

 $cThisYear_RecThisYear = date("Y");
 mysql_select_db($database_connSQL, $connSQL);
 $query_RecThisYear = sprintf("SELECT * FROM webcount WHERE count_time LIKE %s", GetSQLValueString($cThisYear_RecThisYear . "%", "text"));
 $RecThisYear = mysql_query($query_RecThisYear, $connSQL) or die(mysql_error());
 $row_RecThisYear = mysql_fetch_assoc($RecThisYear);
 $totalRows_RecThisYear = mysql_num_rows($RecThisYear);
 */
mysql_select_db($database_connSQL, $connSQL);
$query_RecTotal = "SELECT * FROM webcount";
$RecTotal = mysql_query($query_RecTotal, $connSQL) or die(mysql_error());
$row_RecTotal = mysql_fetch_assoc($RecTotal);
$totalRows_RecTotal = mysql_num_rows($RecTotal);

$maxRows_RecAlbum = 2;
$pageNum_RecAlbum = 0;
if (isset($_GET['pageNum_RecAlbum'])) {
  $pageNum_RecAlbum = $_GET['pageNum_RecAlbum'];
}
$startRow_RecAlbum = $pageNum_RecAlbum * $maxRows_RecAlbum;

mysql_select_db($database_connSQL, $connSQL);
$query_RecAlbum = "SELECT album.album_id, album.album_date, album.album_location, album.album_title, album.album_desc, (albumphoto.ap_picurl) AS album_photo, COUNT(albumphoto.ap_id) AS album_total FROM album INNER JOIN albumphoto ON album.album_id = albumphoto.album_id GROUP BY album.album_id, album.album_date, album.album_location, album.album_title, album.album_desc ORDER BY album.album_date DESC";
$query_limit_RecAlbum = sprintf("%s LIMIT %d, %d", $query_RecAlbum, $startRow_RecAlbum, $maxRows_RecAlbum);
$RecAlbum = mysql_query($query_limit_RecAlbum, $connSQL) or die(mysql_error());
$row_RecAlbum = mysql_fetch_assoc($RecAlbum);

if (isset($_GET['totalRows_RecAlbum'])) {
  $totalRows_RecAlbum = $_GET['totalRows_RecAlbum'];
} else {
  $all_RecAlbum = mysql_query($query_RecAlbum);
  $totalRows_RecAlbum = mysql_num_rows($all_RecAlbum);
}
$totalPages_RecAlbum = ceil($totalRows_RecAlbum/$maxRows_RecAlbum)-1;

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
<style type="text/css">
<!--
.backstageone {
   background-image: url(img/img/2.jpg);
   background-repeat: no-repeat;
   background-position: left;
}

#pic3_left {
   background-image: url(img/img/2.jpg);
}


#qqqwsde {
   background-image: url(img/img/2.jpg);
   background-repeat: no-repeat;
   background-position: right;
}



-->
</style>
</head>
<body onload="MM_preloadImages('img/third/btn_ bulletin_dn.gif','img/third/btn_opinion_dn.gif','img/third/btn_equipment_dn.gif','img/third/btn_share_dn.gif','img/third/btn_food_dn.gif','img/third/btn_photo_dn.gif','img/third/btn_mony_dn.gif','img/third/btn_fix_dn.gif','img/third/rule_dn.gif','img/third/choose_dn.gif','img/third/arrow_up(3).gif','img/third/btn_list_dn.gif','img/third/btn_rule_dn.gif','img/third/btn_info_dn.gif')">
  <!--<table border="0" align="center" cellpadding="0" cellspacing="0" id="allpic">-->
    <?php //include('pic1_template.php'); ?>
    <?php //include('pic2_template.php'); ?>
    <?php include('layout/template.html'); ?>
</body>
</html>
