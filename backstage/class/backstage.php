<?php
header('Content-type:text/html; charset=utf-8');

/*
---相容舊模式的改版--
目前還有很多是 DreamWave 的 Function
如果改了會很麻煩 
所以會有很多是 $_POST[] 來寫
有朝一日會全改成比較正規的物件寫法
*/
class backstage{
var $div3 = '';
private $hostname_connSQL;
private $database_connSQL;
private $username_connSQL;
private $password_connSQL;
private $connSQL;
  
  function connectSQL($hostname,$database,$username,$password){
    $this->hostname_connSQL = $hostname;
    $this->database_connSQL = $database;
    $this->username_connSQL = $username;
    $this->password_connSQL = $password;
    $this->connSQL = mysql_pconnect($hostname, $username, $password) or die("Can't connect!");
  }

  function head(){
    include 'head.php';
  }
  
  function foot(){
    include 'foot.php';
  }
  
  function div3($getpage,$step){
    if($getpage == "bulletin"){
      switch($step) {
        case 1:
          include 'class/function/bulletin_step1.php';
          break;
        case 2:
          include 'function/bulletin_step2.php';
          break;
        case 3:
          include 'function/bulletin_step3.php';
          break;
      }
      //$new->div($step);
    }
    elseif($getpage == "opinion"){
      include "function/opinion.php";
      
    }
    elseif($getpage == "equipment"){
      include "function/equipment.php";
      
    }
    elseif($getpage == "share"){
      include "function/share.php";
      
    }
    elseif($getpage == "photo"){
      include "function/photo.php";
      
    }
    elseif($getpage == "money"){
      include "function/money.php";
      
    }
    elseif($getpage == "fix"){
      include "function/fix.php";
      
    }
    elseif($getpage == "list"){
      include "function/list.php";
      
    }
    elseif($getpage == "info"){
      include "function/info.php";
      
    }
    elseif($getpage == "rule"){
      include "function/rule.php";
      
    }
    else{
      include "function/bulletin_step1.php";
    }
  }

      /*
      if (isset($POST)){
        foreach ($POST as $k => $v){
          echo '$POST['.$k.']='.$v."<br>\n";
        }
      }

      if (isset($GET)){
        foreach ($GET as $k => $v){
          echo '$GET['.$k.']='.$v."<br>\n";
          die();
        }
      }
      */
  
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function select_albumdb($tblname,$pageNum_RecNews = null,$totalRows_RecNews = null){
    $name = $this->get_dbname($tblname);
    $maxRows_RecNews = 10;
    if ($pageNum_RecNews == null){
      $pageNum_RecNews = 0;
    }
    $startRow_RecNews = $pageNum_RecNews * $maxRows_RecNews;
    mysql_select_db($this->database_connSQL, $this->connSQL);
    $query_RecNews = "SELECT * FROM $tblname WHERE `disable`='0' ORDER BY ".$name."_date DESC";
    $query_limit_RecNews = sprintf("%s LIMIT %d, %d", $query_RecNews, $startRow_RecNews, $maxRows_RecNews);
    $RecNews = mysql_query($query_limit_RecNews, $this->connSQL) or die(mysql_error());
    //$row_RecNews = mysql_fetch_assoc($RecNews);

    if (!isset($totalRows_RecNews)) {
      $all_RecNews = mysql_query($query_RecNews);
      $totalRows_RecNews = mysql_num_rows($all_RecNews);
    }
    $totalPages_RecNews = ceil($totalRows_RecNews/$maxRows_RecNews)-1;
    if($tblname=='news_album'){
      include('function/bulletin_step1.php');
    }
    elseif($tblname=='opinion'){
      include('function/opinion_step1.php');
      
    }
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function delete_albumdb($tblname,$album_id){
    $name = $this->get_dbname($tblname);
    if ((isset($album_id)) && ($album_id != "")) {
      $deleteSQL = sprintf("DELETE FROM $tblname WHERE ".$name."_id=%s", $this->GetSQLValueString($album_id, "int"));
      mysql_select_db($this->database_connSQL, $this->connSQL);
      $Result1 = mysql_query($deleteSQL, $this->connSQL) or die(mysql_error());
      $this->select_albumdb($tblname);
    }
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function insert_albumdb($tblname,$album_date,$album_location,$album_title,$album_desc){
    if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
      $insertSQL = sprintf("INSERT INTO $tblname (album_date, album_location, album_title, album_desc) VALUES (%s, %s, %s, %s)",
                           $this->GetSQLValueString($_POST['album_date'], "date"),
                           $this->GetSQLValueString($_POST['album_location'], "text"),
                           $this->GetSQLValueString($_POST['album_title'], "text"),
                           $this->GetSQLValueString($_POST['album_desc'], "text"));

      mysql_select_db($this->database_connSQL, $this->connSQL);
      $Result1 = mysql_query($insertSQL, $this->connSQL) or die(mysql_error());
      
      //取得最新的相簿編號
      $maxid = mysql_insert_id();
      $this->select_albumdb($tblname);
    }
    else{
      include('function/bulletin_step2.php');
    }
  }    
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function update_albumdb($tblname,$album_date,$album_location,$album_title,$album_desc,$album_id,$img_dir){

    $tblname2 = $this->get_photodb($tblname);
    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
      $img_dir = $img_dir.'/';
      for($x = 1 ;$x <= 5 ;$x++){
        //檢測檔案
        $filename = $_FILES["ap_picurl".$x]["name"];
        if(!empty($filename)){
          $img_name = explode(".",$filename);
          $num = count($img_name);
          $second_name = strtolower($img_name[$num-1]);
          $second_name = strtolower($second_name);
          if( $second_name!="jpg" and $second_name!="jpeg" and $second_name!="gif" )
          {
            alert("系統僅能接受JPG、GIF之圖形檔案！");
          }
        
           //指定新的檔案名稱
          $time=date("Ymdhis").$x;
          $new_filename  = $time.".".$second_name;
          $this->ImageCopyResizedTrue($_FILES["ap_picurl".$x]["tmp_name"],$img_dir.$new_filename,800,600);
          unlink($_FILES["ap_picurl".$x]["tmp_name"]);
          $insertSQL = "INSERT INTO $tblname2 SET 
            `album_id` 		= ".$this->GetSQLValueString($album_id, "int").", 
            `ap_picurl`	 	= ".$this->GetSQLValueString($new_filename, "text").",
            `ap_subject`	= ".$this->GetSQLValueString($_POST['ap_subject'.$x], "text")."";
           mysql_select_db($this->database_connSQL, $this->connSQL);
           $Result = mysql_query($insertSQL, $this->connSQL) or die(mysql_error());
        }
      }
      
      $updateSQL = sprintf("UPDATE $tblname SET album_date=%s, album_location=%s, album_title=%s, album_desc=%s WHERE album_id=%s",
                           $this->GetSQLValueString($album_date, "date"),
                           $this->GetSQLValueString($album_location, "text"),
                           $this->GetSQLValueString($album_title, "text"),
                           $this->GetSQLValueString($album_desc, "text"),
                           $this->GetSQLValueString($album_id, "int"));

      mysql_select_db($this->database_connSQL, $this->connSQL);
      $Result1 = mysql_query($updateSQL, $this->connSQL) or die(mysql_error());
    }
    
    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
      $updateSQL = sprintf("UPDATE $tblname2 SET ap_subject=%s WHERE ap_id=%s",
                           $this->GetSQLValueString($_POST['ap_subject'], "text"),
                           $this->GetSQLValueString($_POST['ap_id'], "int"));

      mysql_select_db($this->database_connSQL, $this->connSQL);
      $Result1 = mysql_query($updateSQL, $this->connSQL) or die(mysql_error());
    }
  ///////////
    $this->insert_view_albumdb($tblname,$album_id);
    
  }    
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function insert_view_albumdb($tblname,$album_id){
    $tblname2 = $this->get_photodb($tblname);
    $colname_RecAlbum = "-1";
    if (isset($album_id)) {
      $colname_RecAlbum = $album_id;
    }
    mysql_select_db($this->database_connSQL, $this->connSQL);
    $query_RecAlbum = sprintf("SELECT * FROM $tblname WHERE album_id = %s", $this->GetSQLValueString($colname_RecAlbum, "int"));
    
    $RecAlbum = mysql_query($query_RecAlbum, $this->connSQL) or die(mysql_error());
    $row_RecAlbum = mysql_fetch_assoc($RecAlbum);
    $totalRows_RecAlbum = mysql_num_rows($RecAlbum);

    $colname_RecPhoto = "-1";
    if (isset($album_id)) {
      $colname_RecPhoto = $album_id;
    }
    mysql_select_db($this->database_connSQL, $this->connSQL);
    $query_RecPhoto = sprintf("SELECT * FROM $tblname2 WHERE album_id = %s ", $this->GetSQLValueString($colname_RecPhoto, "int"));
    $RecPhoto = mysql_query($query_RecPhoto, $this->connSQL) or die(mysql_error());
    $row_RecPhoto = mysql_fetch_assoc($RecPhoto);
    $totalRows_RecPhoto = mysql_num_rows($RecPhoto);
    include('function/bulletin_step3.php');
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function delete_albumphoto($tblname,$album_id,$ap_id,$ap_picurl,$img_dir){
  echo '$img_dir='.$img_dir."<br>\n";
    $tblname2 = $this->get_photodb($tblname);
    if ((isset($ap_id)) && ($ap_id != "")) {
      $deleteSQL = sprintf("DELETE FROM $tblname2 WHERE ap_id=%s",
                           $this->GetSQLValueString($ap_id, "int"));
      mysql_select_db($this->database_connSQL, $this->connSQL);
      $Result1 = mysql_query($deleteSQL, $this->connSQL) or die(mysql_error());
      
      //刪除相關檔案
      @unlink($img_dir.'/'.$ap_picurl);
      
      /*
      $deleteGoTo = "backindexmoneyfix.php?album_id=".$album_id;
      header(sprintf("Location: %s", $deleteGoTo));
      */
    }
    $this->insert_view_albumdb($tblname,$album_id);
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function get_photodb($tblname){
    if($tblname=='cloth'){
      return 'cloth_photo2';
    }
    elseif($tblname=='food'){
      return 'food_photo2';
    }
    elseif($tblname=='happy'){
      return 'happy_photo2';
    }
    elseif($tblname=='living'){
      return 'living_photo2';
    }
    elseif($tblname=='money_album'){
      return 'money_photo';
    }
    elseif($tblname=='news_album'){
      return 'news_photo';
    }
    elseif($tblname=='share'){
      return 'share_photo';
    }
    elseif($tblname=='teach'){
      return 'teach_photo2';
    }
    elseif($tblname=='walk'){
      return 'walk_photo2';
    }
    else{
      die("unknow the tblname");
    }
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////
  function get_dbname($tblname){
    if($tblname=='money_album'){
      return 'album';
    }
    elseif($tblname=='news_album'){
      return 'album';
    }
    elseif(isset($tblname)){
      return $tblname;
    }
    else{
      die("unknow the name");
    }
  }
  
  function ImageCopyResizedTrue($src, $dest, $maxWidth, $maxHeight, $quality=100) {
    if (file_exists($src) && isset($dest)) {
      $destInfo = pathInfo($dest);
      $srcSize = getImageSize($src);
      $srcRatio = $srcSize[0] / $srcSize[1];
      $destRatio = $maxWidth / $maxHeight;
      if ($maxWidth > $srcSize[0] and $maxHeight > $srcSize[1]) {
        $destSize[0] = $srcSize[0];
        $destSize[1] = $srcSize[1];
      } elseif ($destRatio > $srcRatio) {
        $destSize[1] = $maxHeight;
        $destSize[0] = $maxHeight * $srcRatio;
      } else {
        $destSize[0] = $maxWidth;
        $destSize[1] = $maxWidth / $srcRatio;
      }
      //if ($destInfo['extension'] == "gif") $dest = substr_replace($dest, 'jpg', -3);
      $destImage = imageCreateTrueColor($destSize[0], $destSize[1]);
      switch ($srcSize[2]) {
        case 1: $srcImage = imageCreateFromGif($src);
          break;
        case 2: $srcImage = imageCreateFromJpeg($src);
          break;
        case 3: $srcImage = imageCreateFromPng($src);
          break;
        default: return false;
        
          break;
      }
      ImageCopyResampled($destImage, $srcImage, 0, 0, 0, 0, $destSize[0], $destSize[1], $srcSize[0], $srcSize[1]);
      switch ($srcSize[2]) {
        case 1: imageGif($destImage, $dest, $quality);
          break;
        case 2: imageJpeg($destImage, $dest, $quality);
          break;
        case 3: imagePng($destImage, $dest);
          break;
      }
      return true;
    } else {
      return false;
    }
  }

///Dreamwave Function
  function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = ""){
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
////
}



class backstage_class{
  var $sql;
  function __construct(){
  }
  
  function select_albumdb($dbname){
    $this->sql='select * from '.$dbname;
    $count_no = mysql_query($this->sql); 
    $i = 1;
    while($data = mysql_fetch_assoc($count_no)){
      foreach ($data as $key => $value){
        $all[$i][$key] = $value; 
      }
      $i++;
    }
    return $all;
  }
  
  
}






?>