<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNECTIONS.'/connSQL.php');
require_once(BCLASS.'/backstage.php');

//
$logoutAction = 'logout.php';
$logoutGoTo = 'index.php';
//

$backstage = new backstage();
$backstage->connectSQL($hostname_connSQL,$database_connSQL,$username_connSQL,$password_connSQL);
$backstage->head();
/*
 if (isset($_POST)){
 $getpage = $_POST['getpage']; //內容型態
 $step = $_POST['step'];       //內容頁面
 if($getpage == 'bulletin'){
 $tblname = 'news_album';    //標題資料表名
 $tblname2 = 'news_photo';   //相簿資料表名

 }
 if(isset($_POST['tblname'])){
 $tblname = $_POST['tblname'];
 }

 $acttype = $_POST['acttype']; //動作樣式
 $pageNum_RecNews = $_POST['pageNum_RecNews'];
 $totalRows_RecNews = $_POST['totalRows_RecNews'];
 $album_id=$_POST['album_id'];
 $album_date = $_POST['album_date'];
 $album_location = $_POST['album_location'];
 $album_title = $_POST['album_title'];
 $album_desc = $_POST['album_desc'];
 $ap_id = $_POST['ap_id'];
 $ap_picurl = $_POST['ap_picurl'];
 $img_dir = $_POST['img_dir'];
 ///////////////////////////////////



 $album_insert = $_POST['album_insert'];
 }
 */
include(VIEW.'/backindex_view.php');
$backstage->foot();
?>