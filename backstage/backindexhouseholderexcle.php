<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindexhouseholderexcle_view.php
mode_page:
  page_class.php
*/
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$img_dir = 'rule';
if(isset($_POST['action_mode'])){
  $action_mode = $_POST['action_mode'];
}else{
  $action_mode = null;
}
if(isset($_POST['page'])){
  $page = $_POST['page'];
}else{
  $page = 1;
}

include(BCLASS.'/head.php');
if(INPUT_DEBUG_MODE){
  include(BCLASS.'/debug.php');
}

if (isset($_FILES)){
  $files=$_FILES;
}


if($action_mode=='view_all_data'){ //
  include(VIEW.'/backindexhouseholderexcle_view.php');
}
elseif($action_mode=='up'){ //
  if(is_uploaded_file($_FILES['upbtn']['tmp_name'])){
    $lname = $_FILES['upbtn']['name'];
    $exten = strtolower(strrchr($lname, ".")) ;
    if ($exten == '.xls'){
      move_uploaded_file($_FILES['upbtn']['tmp_name'], 'up/Book1.xls');
      
       
      
      require_once('Excel/reader.php'); 
       
       
       
       /*很多人都知道 php.ini 中預設的最長執行時間是 30 秒，這是由 php.ini 中的 max_execution_time 變量指定，倘若你有一個需要頗多時間才能完成的工作，例如要發送很多電子郵件給大量收件者，或者要進行繁重的數據分析工作，伺服器會在 30 秒後強行中止正在執行的程式，這個問題其實有解決辦法的。

最簡單當然是修改 php.ini 中 max_execution_time 的數值，不過不是所有人都有權修改 php.ini，例如使用網頁寄存的開發人員，伺服器上的 php.ini 由很多網站共同使用，所以不能隨意修改。

另一個辦法是在 PHP 程式中加入 ini_set(‘max_execution_time’, ’0′)，數值 0 表示沒有執行時間的限制，你的程式需要跑多久便跑多久。若果你的程式仍在測試階段，建議你把時限設定一個實數，以免程式的錯誤把伺服器當掉。
*/ 
       
       
      ini_set(‘max_execution_time’, ’0′);//數值 0 表示沒有執行時間的限制，你的程式需要跑多久便跑多久。
      ini_set("memory_limit","1024M"); //最大1G
      
      $data = new Spreadsheet_Excel_Reader();
      $data->setOutputEncoding('UTF-8');
      $data->read('up/Book1.xls');
      error_reporting(E_ALL ^ E_NOTICE);
      //echo "列:".$data->sheets[0]['numRows'];
      //echo "攔:".$data->sheets[0]['numCols'];
      
      for ($i = 3; $i <= $data->sheets[0]['numRows']; $i++) {
        //echo "$i<br>\n";
        for ($j = 3; $j <= $data->sheets[0]['numCols']; $j++) {
          //echo "$j<br>\n";
          echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
        }
        //die($i.':'.$j);
        echo "\n";
        $sql = "INSERT INTO memberdata (m_name, m_nick, m_username, m_passwd, m_level, m_email, m_phone, m_cellphone, m_address, m_joinDate, m_car1, m_car2, m_car3, m_car4, m_car5, m_moto1, m_moto2, m_moto3, m_moto4, m_moto5, m_carmum1, m_carmum2, m_carmum3, m_carmum4, m_carmum5, m_motomum1, m_motomum2, m_motomum3, m_motomum4, m_motomum5, p_ip)VALUES('".
           //  $data->sheets[0]['cells'][$i][1]."')";
            // $data->sheets[0]['cells'][$i][1]."','".
               $data->sheets[0]['cells'][$i][2]."','".
               $data->sheets[0]['cells'][$i][3]."','".
               $data->sheets[0]['cells'][$i][4]."','".
               $data->sheets[0]['cells'][$i][5]."','".
               $data->sheets[0]['cells'][$i][6]."','".
               $data->sheets[0]['cells'][$i][7]."','".
               $data->sheets[0]['cells'][$i][8]."','".
               $data->sheets[0]['cells'][$i][9]."','".
               $data->sheets[0]['cells'][$i][10]."','".
               $data->sheets[0]['cells'][$i][11]."','".
               $data->sheets[0]['cells'][$i][12]."','".
               $data->sheets[0]['cells'][$i][13]."','".
               $data->sheets[0]['cells'][$i][14]."','".
               $data->sheets[0]['cells'][$i][15]."','".
               $data->sheets[0]['cells'][$i][16]."','".
               $data->sheets[0]['cells'][$i][17]."','".
               $data->sheets[0]['cells'][$i][18]."','".
               $data->sheets[0]['cells'][$i][19]."','".
               $data->sheets[0]['cells'][$i][20]."','".
               $data->sheets[0]['cells'][$i][21]."','".
               $data->sheets[0]['cells'][$i][22]."','".
               $data->sheets[0]['cells'][$i][23]."','".
               $data->sheets[0]['cells'][$i][24]."','".
               $data->sheets[0]['cells'][$i][25]."','".
               $data->sheets[0]['cells'][$i][26]."','".
               $data->sheets[0]['cells'][$i][27]."','".
               $data->sheets[0]['cells'][$i][28]."','".
               $data->sheets[0]['cells'][$i][29]."','".
               $data->sheets[0]['cells'][$i][30]."','".
               $data->sheets[0]['cells'][$i][31]."','".
               $data->sheets[0]['cells'][$i][32]."')
             ";
      //     $data->sheets[0]['cells'][$i][3]."')";

        //die($sql);
        echo $sql.'<br />';
        mysql_query($sql)or die(mysql_error());
      }
    }
    //die();
    echo '
      <script language="javascript">
      <!--
           alert("儲存完畢");
            window.location.href = "backindexhouseholder.php";
      //-->
      </script>
    ';
  }
  else{
    echo '
      <script language="javascript">
      <!--
           alert("儲存失敗");
            window.location.href = "backindexhouseholder.php";
      //-->
      </script>
    ';    
  }
}
else{
  include(VIEW.'/backindexhouseholderexcle_view.php');
}

include(BCLASS.'/foot.php');
?>
