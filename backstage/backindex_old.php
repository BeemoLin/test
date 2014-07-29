<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once(CONNSQL);
require_once(PAGECLASS);
include 'class/backstage.php';

//
$logoutAction = 'logout.php';
$logoutGoTo = 'index.php';
//


$backstage = new backstage();
$backstage->connectSQL($hostname_connSQL,$database_connSQL,$username_connSQL,$password_connSQL);
$backstage->head();

if (isset($_POST)){
/* 先暫時不用，最後完工時在開
  foreach ($_POST as $k => $v){
    ${$k}=$v;
  }
*/
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

/*
一個資料表就一個 $xxx_id ，但全都是相同架構的格式
這下可要用文字分析加上分割才好處理

或是全部的 $xxx_id 指向一個 $tblname_id 
*/
  
  $album_insert = $_POST['album_insert'];
}


if (isset($_POST)){
  foreach ($_POST as $k => $v){
    echo '1: $_POST['.$k.']='.$v."<br>\n";
  }
}/*
if (isset($_GET)){
  foreach ($_GET as $k => $v){
    echo '1: $_GET['.$k.']='.$v."<br>\n";
  }
}
if (isset($_FILES)){
  foreach ($_FILES as $k1 => $v1){
    foreach ($v1 as $k2 => $v2){
      echo '1: $_FILES['.$k1.']['.$k2.']='.$v2."<br>\n";      
    }
  }
}
*/

if (isset($delalbum) && isset($album_id)){
  die($tblname);
  $backstage->delalbum($tblname,$delalbum,$album_id);
  $backstage->div3($getpage,$step);  
}
else{
  if (!isset($getpage) || !isset($step)){
  die("1");
    $backstage->div3();
  }
  elseif($acttype=='select'){
    $backstage->select_albumdb($tblname,$pageNum_RecNews,$totalRows_RecNews);
  }
  elseif($acttype=='delete'){
    $backstage->delete_albumdb($tblname,$album_id,$pageNum_RecNews,$totalRows_RecNews,$getpage,$step);
  }
  elseif($acttype=='delete_photo'){
    $backstage->delete_albumphoto($tblname,$album_id,$ap_id,$ap_picurl,$img_dir);
  }
  elseif($acttype=='insert'){
    $backstage->insert_albumdb($tblname,$album_date,$album_location,$album_title,$album_desc);
  }
  elseif($acttype=='update'){
    $backstage->update_albumdb($tblname,$album_date,$album_location,$album_title,$album_desc,$album_id,$img_dir);
  }
  else{
  die("3");
    //$backstage->albumdb($acttype,$album_name);
    $backstage->div3($getpage,$step);
  }
}
$backstage->foot();
?>