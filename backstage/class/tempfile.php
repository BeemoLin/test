<?php
    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form3")) {
      $updateSQL = sprintf("UPDATE money_photo SET ap_subject=%s WHERE ap_id=%s",
                           GetSQLValueString($_POST['ap_subject'], "text"),
                           GetSQLValueString($_POST['ap_id'], "int"));

      mysql_select_db($database_connSQL, $connSQL);
      $Result1 = mysql_query($updateSQL, $connSQL) or die(mysql_error());

      $updateGoTo = "backindexmoneyfix.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
      }
      header(sprintf("Location: %s", $updateGoTo));
    }

    if ((isset($_GET['ap_id'])) && ($_GET['ap_id'] != "") && (isset($_GET['delphoto']))) {
      $deleteSQL = sprintf("DELETE FROM money_photo WHERE ap_id=%s",
                           GetSQLValueString($_GET['ap_id'], "int"));

      mysql_select_db($database_connSQL, $connSQL);
      $Result1 = mysql_query($deleteSQL, $connSQL) or die(mysql_error());
      
      //刪除相關檔案
      @unlink('money/'.$_GET['ap_picurl']);
      
      $deleteGoTo = "backindexmoneyfix.php?album_id=".$_GET["album_id"];
      header(sprintf("Location: %s", $deleteGoTo));
    }
    /**/


    if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
      $img_dir = 'money/';
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
          ImageCopyResizedTrue($_FILES["ap_picurl".$x]["tmp_name"],$img_dir.$new_filename,800,600);
          unlink($_FILES["ap_picurl".$x]["tmp_name"]);
          $insertSQL = "INSERT INTO money_photo SET 
            `album_id` 		= ".GetSQLValueString($album_id, "int").", 
            `ap_picurl`	 	= ".GetSQLValueString($new_filename, "text").",
            `ap_subject`	= ".GetSQLValueString($_POST['ap_subject'.$x], "text")."";
           mysql_select_db($this->database_connSQL, $this->connSQL);
           $Result = mysql_query($insertSQL, $connSQL) or die(mysql_error());
        }
      }
      
      $updateSQL = sprintf("UPDATE money_album SET album_date=%s, album_location=%s, album_title=%s, album_desc=%s WHERE album_id=%s",
                           GetSQLValueString($album_date, "date"),
                           GetSQLValueString($album_location, "text"),
                           GetSQLValueString($album_title, "text"),
                           GetSQLValueString($album_desc, "text"),
                           GetSQLValueString($album_id, "int"));

      mysql_select_db($this->database_connSQL, $this->connSQL);
      $Result1 = mysql_query($updateSQL, $this->connSQL) or die(mysql_error());

      //一次插入多筆記錄到資料庫

      $updateGoTo = "backindexmoneyfix.php";
      if (isset($_SERVER['QUERY_STRING'])) {
        $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
        $updateGoTo .= $_SERVER['QUERY_STRING'];
      }
      //header(sprintf("Location: %s", $updateGoTo));
    }

?>