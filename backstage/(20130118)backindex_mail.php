<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindex_mail_view.php
  backindex_maillhead_view.php
  backindex_mail_select_view.php
  backindex_mail_selected_list_view.php
  backindex_mail_add_view.php
  backindex_mail_give_list.php
  backindex_mail_give_list2.php
  backindex_mail_give_data.php

controller:
  contorlCOM.php    新增信件
  controlCOM2.php   信件發放
  controlCOM3.php   查詢發放信件
  backindex_mail_undisable_list.php

mode_page:
  page_class.php
*/
$main_name = '信件管理系統首頁';
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$now_time = date("Y-m-d H:i:s");


$action_mode=(isset($_POST['action_mode']))?$_POST['action_mode']:null;
$page=(isset($_POST['page']))?$_POST['page']:1;
$files=(isset($_FILES))?$_FILES:null;
/*
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
if (isset($_FILES)){
  $files=$_FILES;
}
*/
//$action_mode
include(BCLASS.'/head.php');//左側表頭

if(INPUT_DEBUG_MODE){
  include(BCLASS.'/debug.php');
}


$arr_j = array(
  "A" => "1" ,
  "B" => "2" ,
  "C" => "3" ,
  "D" => "4" ,
  "E" => "5" ,
  "F" => "6" ,
  "G" => "7" ,
  "H" => "8" ,
  "I" => "9" ,
  "J" => "10" ,
  "K" => "11" ,
  "L" => "12" ,
  "M" => "13" ,
  "N" => "14" ,
  "O" => "15" ,
  "P" => "16" ,
  "Q" => "17" ,
  "R" => "18" ,
  "S" => "19" ,
  "T" => "20" ,
  "U" => "21" ,
  "V" => "22" ,
  "W" => "23" ,
  "X" => "24" ,
  "Y" => "26" ,
  "Z" => "26"
);

function is_time($time){
    $pattern = '/[\d]{4}-[\d]{1,2}-[\d]{1,2}/';
    return preg_match($pattern, $time);
}
//work
include(VIEW.'/backindex_maillhead_view.php');//上面表頭

echo "<br />\n";

if($action_mode=='view_all_data')
{
  view_data($page);
}
elseif($action_mode=='select')
{
  $_SESSION['search_sql']='';
  $main_name = '搜尋資料';
  $pages = new sam_pages_class;
  $pages->action_mode('select');
  $pages->setDb('mailtype',"","type");
  $data = $pages->getData();
  include(VIEW.'/backindex_mail_select_view.php');
}
elseif($action_mode=='select_list')//搜尋資料
{
  $main_name = '搜尋資料';
  $txt_sql=null;
  if (!empty($_POST['keyword'])){
      $keyword=$_POST['keyword'];
      $txt_sql="
      AND (`receives_time` LIKE '%".$keyword."%' 
      or `takes_time` LIKE '%".$keyword."%' 
      or `id` LIKE '%".$keyword."%' 
      or `sends_name` LIKE '%".$keyword."%' 
      or `sends_add` LIKE '%".$keyword."%' 
      or `m_address` LIKE '%".$keyword."%' 
      or `mail_management`.`m_username` LIKE '%".$keyword."%' 
      or `letter_category` LIKE '%".$keyword."%' 
      or `letter_alt` LIKE '%".$keyword."%' 
      or `letters_number` LIKE '%".$keyword."%' 
      or `receives_name` LIKE '%".$keyword."%' 
      or `manager_signature` LIKE '%".$keyword."%' 
      or `bar_code` LIKE '%".$keyword."%')
      ";
  }
  
  if (!empty($_POST['receives_time_start']) || !empty($_POST['receives_time_end'])){
      $receives_time_start=$_POST['receives_time_start'];
      $receives_time_end=$_POST['receives_time_end'];
      if (is_time($receives_time_start) && is_time($receives_time_end)){
        $txt_sql.="AND `receives_time` BETWEEN '".$receives_time_start."' AND '".$receives_time_end."' ";                    
      }
      elseif(is_time($receives_time_start)){
        $txt_sql.="AND `receives_time` > '".$receives_time_start."' "; 
      }
      elseif(is_time($receives_time_end)){
        $txt_sql.="AND `receives_time` < '".$receives_time_end."' ";  
      }
      else{
        die("輸入時間格式錯誤！");
      }
  }
  
  if (!empty($_POST['takes_time_start']) || !empty($_POST['takes_time_end'])){
      $takes_time_start=$_POST['takes_time_start'];
      $takes_time_end=$_POST['takes_time_end'];
      if (is_time($takes_time_start) && is_time($takes_time_end)){
        $txt_sql.="AND `takes_time` BETWEEN '".$takes_time_start."' AND '".$takes_time_end."' ";                     
      }
      elseif(is_time($takes_time_start)){
        $txt_sql.="AND `takes_time` > '".$takes_time_start."' ";  
      }
      elseif(is_time($takes_time_end)){
        $txt_sql.="AND `takes_time` < '".$takes_time_end."' ";
      }
      else{
        die("輸入時間格式錯誤！");
      }
  }
  
  if (!empty($_POST['sends_name'])){
      $sends_name=$_POST['sends_name'];
      $txt_sql.="AND `sends_name` LIKE '%".$sends_name."%' ";
  }
  
  if (!empty($_POST['sends_add'])){
      $sends_add=$_POST['sends_add'];
      $txt_sql.="AND `sends_add` LIKE '%".$sends_add."%' ";
  }
  
  if (!empty($_POST['householder_no'])){
      $householder_no=$_POST['householder_no'];
      $txt_sql.="AND `m_address` LIKE '%".$householder_no."%' ";        
      // ↑↑↑↑ 舊有的資料庫格式，目前可以相容，以後不要用了，如果住址改了會找不到人。
      $txt_sql.="OR `memberdata`.`m_address` LIKE '%".$householder_no."%' ";
  }

  if (!empty($_POST['m_username'])){
      $m_username=$_POST['m_username'];
      $txt_sql.="AND `mail_management`.`m_username` LIKE '%".$m_username."%' ";
  }
  
  if (!empty($_POST['letter_category'])){
      $letter_category=$_POST['letter_category'];
      $txt_sql.="AND `letter_category` LIKE '%".$letter_category."%' ";
  }
  
  if (!empty($_POST['letters_number'])){
      $letters_number=$_POST['letters_number'];
      $txt_sql.="AND `letters_number` LIKE '%".$letters_number."%' ";
  }
  
  if (!empty($_POST['receives_name'])){
      $receives_name=$_POST['receives_name'];
      $txt_sql.="AND `receives_name` LIKE '%".$receives_name."%' ";
  }
  
  if (isset($_POST['disable'])){
      $disable=$_POST['disable'];
      $txt_sql.="AND `disable` LIKE '%".$disable."%' ";
  }
  $txt_sql.=" ORDER BY `receives_time` DESC";
  
  if(!empty($_SESSION['search_sql'])){
    $txt_sql = $_SESSION['search_sql'];
  }
  else{
    $_SESSION['search_sql'] = $txt_sql;
  }      
  
  $pages = new sam_pages_class;
  $pages->action_mode('select_list');
  $pages->setDb('`mail_management` LEFT JOIN `memberdata` ON `mail_management`.`m_username` = `memberdata`.`m_username`',$txt_sql,'*');
  //die($pages->sql);
  //echo($pages->sql);
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  $disable="0";//系統更改，功能暫時只用一個
  include(VIEW.'/backindex_mail_selected_list_view.php');
}
elseif($action_mode=='add_data')//新增信件
{
  $pages = new sam_pages_class;
  $pages->setDb('mailtype'," ORDER BY `id` ASC ",'type');
  $data1 = $pages->getData();
  $pages->setDb('memberdata'," AND `m_level` = 'member' ORDER BY `m_username` ASC ",' m_username, m_address ');
  $data2 = $pages->getData();
  $pages->setDb('logistics_company'," ORDER BY `No` ASC ",' * ');
  $data3 = $pages->getData();

  include(VIEW.'/backindex_mail_add_view.php');
}
elseif($action_mode=='add')
{
  if(isset($_POST)){
    foreach($_POST as $k => $v){
      ${$k}=$v;
      //echo "$k:$v <br>";
    }
  }
  
  if(isset($add_mode)){
    if($add_mode == '住戶代轉'){
      if(empty($receives_name) || empty($sends_name)){
        header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
        echo '<script>alert("資料填寫未完成，按下確定，3秒後回上一頁");</script>';
        exit();
      }
    }
    elseif($add_mode == '一般類別'){
      if(empty($letter_alt) || empty($receives_name) || empty($m_username) || empty($letters_number) || empty($lettercheck) ){
        header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
        echo '<script>alert("資料填寫未完成，按下確定，3秒後回上一頁");</script>';
        exit();
      }
    }
    else{
      header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
      echo '<script>alert("資料填寫未完成，按下確定，3秒後回上一頁");</script>';
      exit();
    }
  }
  
  if($letters_number=='NOW( )'){
    $letters_number = $now_time;
  }
  
  if(empty($receives_time)){
    $receives_time = $now_time;
    //$receives_time='`receives_time` = NOW( )';
  }
  //else{
    //receives_time = $receives_time;
    //$receives_time="`receives_time` = '".$receives_time."'";
  //}
  
  if(!isset($show)){
    $show=='1';
  }
  
  if(isset($addCname)){
    $addCname = trim($addCname);
    if(empty($addCname)){
      header("refresh:3;url=".$_SERVER['HTTP_REFERER']);
      echo '<script>alert("資料填寫未完成，按下確定，3秒後回上一頁");</script>';
      exit();
    }
    $pages = new sam_pages_class;
    $pages->setDb('logistics_company'," AND `Logistics_Company_Name` = '$addCname' ","type");
   // echo $pages->count."<br>";
    $total = $pages->total();
    if($total==0){
      $pages = new data_function;
      $pages->setDb('logistics_company');
      $expression=" `Logistics_Company_Name` = '$addCname' ";
      $pages->insert($expression);
    }
    $letter_alt = $addCname;
  }
  $pages = new data_function;
  $insert_expression = "
    `receives_time` = '".$receives_time."',
    `sends_name` = '".$sends_name."',
    `sends_add` ='".$sends_add."',
    `m_username` ='".$m_username."',
    `letter_category` ='".$letter_category."',
    `letter_alt` ='".$letter_alt."',
    `letters_number` ='".$letters_number."',
    `show` ='".$show."',
    `receives_name` ='".$receives_name."'";
  $pages->setDb('mail_management');
  $insert_id = $pages->insert($insert_expression);
  /* $m_username 為住戶編號，住戶編號一般為數字開頭為編號的號碼(如2A、11B)，
  ** 也有英文開頭的號碼(如S1、T2)。邏輯方法為抓取第一位是否為英文'S'或是'T'，
  ** 以及第二位是否為數字。如果為是就為{方式一}，如果為否就為{方式二}。
  ** 
  ** {方式一}:
  ** 抓取第一個數值強制改為大寫，並且文字轉代碼(帶入 $arr_j[$i_uper] 可得代碼)
  ** 第一個數值為$i，第二個數值為$j
  ** 
  ** {方式二}:
  ** 強制設定數值為三個數值，不為三個數值強置在最左邊加一個'0'
  ** 第一個及第二個數值為$i，第三個數值為$j
  **
  */
      $check_type1 = mb_substr($m_username,0,1);
      $check_type2 = (int) mb_substr($m_username,1,1);
      if(($check_type1 == 'S' || $check_type1 == 'T') && is_numeric($check_type2))
      {
      //mb_substr從INDEX=0抓取一個字元
        $i_uper = strtoupper(mb_substr($m_username,0,1));
        $j = mb_substr($m_username,1,1);
        $i = $arr_j[$i_uper];
      }
      else{
        $new_username = str_pad($m_username,3,"0",STR_PAD_LEFT);
        $i = mb_substr($new_username,0,2);
        $j_uper = strtoupper(mb_substr($new_username,2,1));
        $j = $arr_j[$j_uper];
      }
      
  /* 由上面方式可得 $i 以及 $j，
  ** $k = 1 ，為信件模組。
  ** $l = 3 ，為信件在櫃台(mail on)；
  ** $l = 4 ，為沒有信件(mail off)。
  ** 
  ** $key1 為 $i;
  ** $key2 為 (int)((string)$j.(string)$k.(string)$l);
  ** 
  ** 新的 $key1 為 轉換大小寫(數值轉16進位($key1));
  ** 新的 $key1 為 $key1 取兩個值，如果為單一個值，最左邊補0。
  ** 新的 $key2 為 轉換大小寫(數值轉16進位($key2));
  ** 新的 $key2 為 $key1 取四個值，如果有數值為數量不夠，最左邊補0。 
  ** 
  ** 傳輸給網頁 contorlCOM.php (即controlCOM.js)。
  */
            
      $k = 1;
      $l = 3;
      $key1 = $i;
      $key2 = (int)((string)$j.(string)$k.(string)$l);
      $key1 = strtoupper(dechex($key1));//轉換大小寫(數值轉16進位($key1))
      $key1 = str_pad($key1,2,"0",STR_PAD_LEFT);
      $key2 = strtoupper(dechex($key2));//轉換大小寫(數值轉16進位($key2))
      $key2 = str_pad($key2,4,"0",STR_PAD_LEFT);
      
      //$echoData = chr(2).$key1.$key2.chr(13).chr(10).chr(3);            

	  //echo $echoData."<br>\n";
	  include(VIEW.'/contorlCOM.php');  //中央監控
}
elseif($action_mode=='add2')
{
  $pages = new sam_pages_class;
  $pages->action_mode('view_all_data');
  $pages->count = "
  SELECT count(1) 
  FROM `mail_management` 
  WHERE `disable` = '0' 
  ";
  $pages->sql="
  SELECT 
    `a`.`receives_time`, 
    `b`.`m_address`, 
    `b`.`m_username`, 
    `a`.`receives_name`, 
    `a`.`letter_category`, 
    `a`.`letter_alt`, 
    `a`.`letters_number`, 
    `a`.`sends_name` 
  FROM `mail_management` AS `a`
    LEFT JOIN `memberdata` AS `b` 
      ON `a`.`m_username` = `b`.`m_username`
  WHERE `disable` = '0'
  ORDER BY `receives_time` DESC
  ";
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  //die($pages->sql);
  $data = $pages->getData();
  include(VIEW.'/backindex_mail_view.php');
  
}
elseif($action_mode=='fix')//信件發放:按鈕-->確定送出
{
//-----------------------------------信件發放:單筆 與 多筆 (所以要跑迴圈把簽名塞到每一列記錄中)-------------------------------------------
  $post=$_POST['arr'];//arr:二維陣列 被選取發放信件的列
 // var_dump($post);
  @$chkbox=$_POST['chkbox'];//null;
  //var_dump($chkbox);
  $sign_code=$_POST['sign_code'];//住戶簽名
// var_dump($sign_code);
  $admin_sign_code=$_POST['admin_sign_code'];//管理員簽名
// var_dump($admin_sign_code);
  
  @$space1_code=$_POST['space1_code'];//@代表出錯不顯示錯誤訊息
  @$space2_code=$_POST['space2_code'];
  
 //  var_dump($space1_code);
 //  var_dump($space2_code);
  
  $count_post=count($post);//被選取的信件筆數
  $ccount_post=count($post[$count_post-1]);//每一筆信件的攔位數量

// var_dump($count_post);
// var_dump($ccount_post);


  $pages = new data_function;
  $pages->setDb('mail_management');
  
  for($x=0;$x<=($count_post-1);$x++)//要更新到資料庫;跑筆數
  {
    $disable="0";//因為下面兩個理由所以要區分是哪個模式
    //信件發放區當住戶與管理員簽名按確定送出會滾到發放查詢區
    //郵件管理:當發放查詢按確定取消會滾到信件發放區

    //if(empty($_POST['space1_code']) || empty($_POST['space2_code']) || $space1_code==$sign_code || $space2_code==$admin_sign_code || $post[$x]['m_username']=="" || $post[$x]['letter_category']=="" || $post[$x]['receives_name']=="" || $post[$x]['letter_alt']=="" || $post[$x]['letters_number']=="")
    if($post[$x]['m_username']=="" || $post[$x]['letter_category']=="" || $post[$x]['receives_name']=="" || $post[$x]['letter_alt']=="" || $post[$x]['letters_number']=="")
    {
      $disable="0";//模式0可能是單純對資料更改(資料有空白);與中央監控無關
    }
    else
    {
      $disable="1";//資料齊全;使用中央監控
    }
    //資料只要不齊全;信件的發送時間就要設成NULL,資料齊全;信件的發送時間就要設成現在時間
    if(empty($post[$x]['takes_time']))
    {
      $q2=($disable=="0")?"`takes_time` = NULL":'`takes_time` = NOW( )';
      
      /*if($disable=="0") 
      {
        $q2="`takes_time` = NULL";
      }
      else
      {
        $q2='`takes_time` = NOW( )';
      }*/
    }
    else
    {
      $q2="`takes_time` = '".$post[$x]['takes_time']."'";
    }
    
    if($post[$x]['letters_number']=='NOW( )')
    {
      $post[$x]['letters_number'] = $now_time;
    }
    $main_name = '信件發放';
    //---------------------------------------------------使用Update方式-----------------------------------------------
    if($disable=="0")
    {
    //!isset($_POST['space1_code']) || !isset($_POST['space2_code']) || $space1_code==$sign_code || $space2_code==$admin_sign_code
      $update_expression = "".
        $q2.",
        `receives_time` = '".$post[$x]['receives_time']."',
        `sends_name` = '".$post[$x]['sends_name']."',
        `sends_add` = '".$post[$x]['sends_add']."',
        `m_username` = '".$post[$x]['m_username']."',
        `letter_category` = '".$post[$x]['letter_category']."',
        `letter_alt` = '".$post[$x]['letter_alt']."',
        `letters_number` = '".$post[$x]['letters_number']."',
        `receives_name` = '".$post[$x]['receives_name']."',
        `manager_signature` = '".@$post[$x]['manager_signature']."',
        `bar_code` = '".@$post[$x]['bar_code']."',
        `show` = '".@$post[$x]['show']."'";
      $where_expression = "AND `id` ='".$post[$x]['id']."'";
     // die($update_expression."-----".$where_expression);
      $pages->update($where_expression,$update_expression);
    }
    else
    {
      $update_expression = "".
        $q2.",
        `receives_time` = '".$post[$x]['receives_time']."',
        `sends_name` = '".$post[$x]['sends_name']."',
        `sends_add` = '".$post[$x]['sends_add']."',
        `m_username` = '".$post[$x]['m_username']."',
        `letter_category` = '".$post[$x]['letter_category']."',
        `letter_alt` = '".$post[$x]['letter_alt']."',
        `letters_number` = '".$post[$x]['letters_number']."',
        `receives_name` = '".$post[$x]['receives_name']."',
        `manager_signature` = '".@$post[$x]['manager_signature']."',
        `sign_code` = '".$sign_code."',
        `admin_sign_code` = '".$admin_sign_code."',
        `show` = '".@$post[$x]['show']."',
        `disable` = '".$disable."'";
      $where_expression = "AND `id` ='".$post[$x]['id']."'";
     // die($update_expression."-----".$where_expression);
      $pages->update($where_expression,$update_expression);
      $where = "AND `m_username` = '".$post[$x]['m_username']."' AND `show` = '1' and `disable` = '0'";
      $set_mail = $pages->total($where);
      //die($disable);
      //--------------------------------此段要研究;是否與中央監控有關------------------------------------------------
      if($set_mail==0)//因為已經UPDATE 所以SELECT count( 1 )FROM mail_management WHERE 1 =1 AND `m_username` = '10A' AND `show` = '1' AND `disable` = '0' 會是0 disable此時變成1要滾到發放查詢
      {
        /////////////////////////此住戶的信件已全部發放
        $check_type1 = mb_substr($post[$x]['m_username'],0,1);
        $check_type2 = (int) mb_substr($post[$x]['m_username'],1,1);
        if(($check_type1 == 'S' || $check_type1 == 'T') && is_numeric($check_type2))
        {
          $i_uper = strtoupper(mb_substr($post[$x]['m_username'],0,1));
          $j = mb_substr($post[$x]['m_username'],1,1);
          $i = $arr_j[$i_uper];
          //die('2');
        }
        else
        {
          $new_username = str_pad($post[$x]['m_username'],3,"0",STR_PAD_LEFT);
          $i = mb_substr($new_username,0,2);
          $j_uper = strtoupper(mb_substr($new_username,2,1));
          $j = $arr_j[$j_uper];
          //die('3');
        }
        $k = 1;
        $l = 4;
        $key1 = $i;
        $key2 = (int)((string)$j.(string)$k.(string)$l);
        //var_dump($key1);
       // var_dump($key2);
        $key1 = strtoupper(dechex($key1));//轉換大小寫(數值轉16進位($key1))
       // var_dump($key1);
        $key1 = str_pad($key1,2,"0",STR_PAD_LEFT);
       // var_dump($key1);
        $key2 = strtoupper(dechex($key2));//轉換大小寫(數值轉16進位($key2))
       // var_dump($key2);
        $key2 = str_pad($key2,4,"0",STR_PAD_LEFT);
      //  var_dump($key2);
        //丟給controlCOM2.php在使用AJAX執行與中央監控的通訊
        //使用陣列:因為可能很多住戶
        $mail[] = array(
          "key1" => "$key1",
          "key2" => "$key2"
        );
        //var_dump($mail);
      }
      else
      {
        //----代表還有信件未發放
        $disable=="0";//語法有問題
      }
    }
  }
  //die("TEST");
   //--------------------------------此段要研究;是否與中央監控有關------------------------------------------------
  //------------------------------------------把資料撈出來,放入VIEW中---------------------------------------------------
  if($disable=="0")
  {
    $pages = new sam_pages_class;
    $pages->action_mode('give_list');
    $pages->count = "
    SELECT count(1) 
    FROM `mail_management` 
    WHERE `disable` = '0' 
    ";
    $pages->sql="
    SELECT 
      `a`.*, 
      `b`.`m_address` 
    FROM `mail_management` AS `a`
      LEFT JOIN `memberdata` AS `b` 
        ON `a`.`m_username` = `b`.`m_username`
    WHERE `disable` = '0'
    ORDER BY `a`.`receives_time` DESC
    ";
    
    $pages->setPerpage(10,$page);
    $pages->set_base_page('backindex_mail.php');
    $Firstpage = $pages->getFirstpage2();
    $Listpage = $pages->getListpage2(2);
    $Endpage = $pages->getEndpage2();
    $data = $pages->getData();
    include(VIEW.'/backindex_mail_give_list.php');
  }
  else
  {
    include_once(VIEW.'/controlCOM2.php');//控制中央監控後台與中央監控透過AJAX(執行緒)通訊;檔案放在C:\TCWA目錄下名稱為control2.php
  }
   //------------------------------------------把資料撈出來,放入VIEW中---------------------------------------------------
}
elseif($action_mode=='fix2')
{
  $pages = new sam_pages_class;
  //$pages->action_mode('fix_list');
  $pages->action_mode('give_list');
  //$pages->setDb('mail_management',"AND `disable` = '0' ORDER BY `receives_time` DESC",'*');
  $pages->count = "
  SELECT count(1) 
  FROM `mail_management` 
  WHERE `disable` = '0' 
  ";
  $pages->sql="
  SELECT 
    `a`.*, 
    `b`.`m_address` 
  FROM `mail_management` AS `a`
    LEFT JOIN `memberdata` AS `b` 
      ON `a`.`m_username` = `b`.`m_username`
  WHERE `disable` = '0'
  ORDER BY `a`.`receives_time` DESC
  ";
  
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_mail_give_list.php');
}
elseif($action_mode=='key_selected')//信件發放
{
  $main_name = '信件發放';
  $pages = new sam_pages_class;
  $keyword='';
  if(isset($_POST['wkoa'])){
    $what_kind_of_action = $_POST['wkoa'];
    if($what_kind_of_action=='keyin'){
      if(isset($_POST['key'])){
        $_SESSION['SQL']=$_POST['key'];
        $keyword=$_POST['key'];
      }
    }
    elseif($what_kind_of_action=='turn'){
      if(isset($_SESSION['SQL'])){
        $keyword=$_SESSION['SQL'];
      }
    }
  }
  else{
    //
  }

  if (!empty($keyword)){
      $txt_sql="
      AND `disable` = '0' 
      AND (`receives_time` LIKE '%".$keyword."%' 
      OR `takes_time` LIKE '%".$keyword."%' 
      OR `id` LIKE '%".$keyword."%' 
      OR `sends_name` LIKE '%".$keyword."%' 
      OR `sends_add` LIKE '%".$keyword."%' 
      OR `m_address` LIKE '%".$keyword."%' 
      OR `a`.`m_username` LIKE '%".$keyword."%' 
      OR `letter_category` LIKE '%".$keyword."%' 
      OR `letter_alt` LIKE '%".$keyword."%' 
      OR `letters_number` LIKE '%".$keyword."%' 
      OR `receives_name` LIKE '%".$keyword."%' 
      OR `manager_signature` LIKE '%".$keyword."%') 
      ORDER BY `a`.`m_username`, `a`.`receives_time` DESC
      ";
  }
  else{
      $txt_sql="
      AND `disable` = '0' 
      ORDER BY `a`.`receives_time` DESC
	  ";
  }


  
  //$pages->setDb('mail_management',"AND `disable` = '0' ORDER BY `receives_time` DESC",'*');
  
  $pages->action_mode('key_selected');
  $pages->setDb('`mail_management` AS `a` LEFT JOIN `memberdata` AS `b` ON `a`.`m_username` = `b`.`m_username`',$txt_sql,' `a`.*, `b`.`m_address` ');
  //die($pages->count);
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  
  include(VIEW.'/backindex_mail_give_list2.php');
  //die();
}
elseif($action_mode=='give_list')
{
 // die();
  $main_name = '信件發放';
  $pages = new sam_pages_class;
  $pages->action_mode('give_list');
  //$pages->setDb('mail_management',"AND `disable` = '0' ORDER BY `receives_time` DESC",'*');
  $_SESSION['SQL']='';
  $pages->count = "
  SELECT count(1) 
  FROM `mail_management` 
  WHERE `disable` = '0' 
  ";
  $pages->sql="
  SELECT 
    `a`.*, 
    `b`.`m_address` 
  FROM `mail_management` AS `a`
    LEFT JOIN `memberdata` AS `b` 
      ON `a`.`m_username` = `b`.`m_username`
  WHERE `disable` = '0'
  ORDER BY `a`.`receives_time` DESC
  ";
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_mail_give_list.php');
}
elseif($action_mode=='give_data')
{
//die();
  $main_name = '信件發放';
  $pages = new sam_pages_class;
  $pages->setDb('mailtype',"ORDER BY `id` ASC",'type');
  $data1 = $pages->getData();
  $pages->setDb('memberdata'," AND `m_level` = 'member' ORDER BY `m_username` ASC ",' m_username, m_address ');
  $data2 = $pages->getData();
  
  $chkbox=$_POST['chkbox'];
  $count_chkbox=count($chkbox)-1;
  //echo count($chkbox);
  $all_no='';

  for($x=0;$x<=$count_chkbox;$x++){
    if ($x!=$count_chkbox){
      $all_no = $all_no."'$chkbox[$x]',";
    }
    else{
      $all_no = $all_no."'$chkbox[$x]'";
    }
  }
  $no=0;
  
  $pages->setDb('mail_management',"AND `id` IN ($all_no) ORDER BY `receives_time` DESC ", "*");
  $data3 = $pages->getData();
  
  $pages->setDb('logistics_company'," ORDER BY `No` ASC ",' * ');
  $data4 = $pages->getData();
  
  include(VIEW.'/backindex_mail_give_data.php');

}
elseif($action_mode=='give')
{
//原本的 $action_mode=='give' 改指向 $action_mode=='fix'
//如果以後程序不一樣相差很多時，可以指回來重寫
}
elseif($action_mode=='undisable_list')
{
 // die();
  $main_name = '查詢發放信件';
  $pages = new sam_pages_class;
  $keyword='';
  if(isset($_POST['wkoa'])){
    $what_kind_of_action = $_POST['wkoa'];
    if($what_kind_of_action=='keyin'){
      if(isset($_POST['keyword'])){
        $_SESSION['SQL']=$_POST['keyword'];
        $keyword=$_POST['keyword'];
      }
    }
    elseif($what_kind_of_action=='turn'){
      if(isset($_SESSION['SQL'])){
        $keyword=$_SESSION['SQL'];
      }
    }
  }
  else{
    if(isset($_POST['keyword'])){
      $_SESSION['SQL']=$_POST['keyword'];
      $keyword=$_POST['keyword'];
    }
  }
  
  if (!empty($keyword)){
      $txt_sql="
      AND `disable` = '1' 
      AND (`receives_time` LIKE '%".$keyword."%' 
      OR `takes_time` LIKE '%".$keyword."%' 
      OR `id` LIKE '%".$keyword."%' 
      OR `sends_name` LIKE '%".$keyword."%' 
      OR `sends_add` LIKE '%".$keyword."%' 
      OR `m_address` LIKE '%".$keyword."%' 
      OR `a`.`m_username` LIKE '%".$keyword."%' 
      OR `letter_category` LIKE '%".$keyword."%' 
      OR `letter_alt` LIKE '%".$keyword."%' 
      OR `letters_number` LIKE '%".$keyword."%' 
      OR `receives_name` LIKE '%".$keyword."%' 
      OR `manager_signature` LIKE '%".$keyword."%') 
      ORDER BY `a`.`m_username`, `a`.`takes_time` DESC
      ";
  }
  else{
      $txt_sql="
      AND `disable` = '1' 
      ORDER BY `a`.`takes_time` DESC
	  ";
  }
  
  $pages->action_mode('undisable_list');
  //$pages->setDb('mail_management',"AND `disable` = '1' ORDER BY `receives_time` DESC",'*');
  $pages->setDb('`mail_management` AS `a` LEFT JOIN `memberdata` AS `b` ON `a`.`m_username` = `b`.`m_username`',$txt_sql,' `a`.*, `b`.`m_address` ');
  //die($pages->count);
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage4($keyword);
  $Listpage = $pages->getListpage4($keyword,5);
  $Endpage = $pages->getEndpage4($keyword);
  $data = $pages->getData();
  include(VIEW.'/backindex_mail_undisable_list.php');
}
elseif($action_mode=='undisable')
{
  $main_name = '查詢發放信件';
  @$chkbox=$_POST['chkbox'];
  $count_chkbox=count($chkbox)-1;

  $all_no='';

  for($x=0;$x<=$count_chkbox;$x++)
  {
    if ($x!=$count_chkbox){
      $all_no = $all_no."$chkbox[$x],";
    }
    else{
      $all_no = $all_no."$chkbox[$x]";
    }
  }
  $no=0;
  
  if($count_chkbox>=0)
  {
    $pages = new data_function;
    ////////////////////////////////
    $pages->setDb('mail_management');
    $data = $pages->select('AND `id` IN ('.$all_no.') GROUP BY `m_username`','`m_username`');
    //die($pages->sql);
    foreach($data as $value)
    {
      $where = "AND `m_username` = '".$value['m_username']."' AND `show` = '1' and `disable` = '0'";
      $set_mail = $pages->total($where);
      if($set_mail==0)
      {
        /////////////////////////
        $check_type1 = mb_substr($value['m_username'],0,1);
        $check_type2 = (int) mb_substr($value['m_username'],1,1);
        if(($check_type1 == 'S' || $check_type1 == 'T') && is_numeric($check_type2)){
          $i_uper = strtoupper(mb_substr($value['m_username'],0,1));
          $j = mb_substr($value['m_username'],1,1);
          $i = $arr_j[$i_uper];
        }
        else{
          $new_username = str_pad($value['m_username'],3,"0",STR_PAD_LEFT);
          $i = mb_substr($new_username,0,2);
          $j_uper = strtoupper(mb_substr($new_username,2,1));
          $j = $arr_j[$j_uper];
        }
        $k = 1;
        $l = 3;
        $key1 = $i;
        $key2 = (int)((string)$j.(string)$k.(string)$l);
        $key1 = strtoupper(dechex($key1));//轉換大小寫(數值轉16進位($key1))
        $key1 = str_pad($key1,2,"0",STR_PAD_LEFT);
        $key2 = strtoupper(dechex($key2));//轉換大小寫(數值轉16進位($key2))
        $key2 = str_pad($key2,4,"0",STR_PAD_LEFT);
        $mail[] = array(
          "key1" => "$key1",
          "key2" => "$key2"
        );
      }
    }
    
    ////////////////////////////////
    $pages->setDb('mail_log');
    $pages->sql='INSERT INTO mail_log
                 SELECT * FROM mail_management
                 WHERE `id` IN ('.$all_no.')';
    $pages->query();
    $pages->setDb('mail_management');
    //---------------------------------------------當按取消此攔位全清空(狀態的改變)-------------------------------------------
    $update_expression = " `disable` = '0', `sign_code` = NULL, `admin_sign_code` = NULL, `takes_time` = NULL ";
    $where_expression = " AND `id` IN ($all_no) ";
    $pages->update($where_expression,$update_expression);
  }
  
  include(VIEW.'/controlCOM3.php');
}
else
{
  view_data($page);
}
include(BCLASS.'/foot.php');
//////////////////////////////////////////////////////////////////////////
function view_data($page)
{
  $pages = new sam_pages_class;
	$expression="
		`a`.`receives_time`, 
    `b`.`m_address`, 
    `b`.`m_username`, 
    `a`.`receives_name`, 
    `a`.`letter_category`, 
    `a`.`letter_alt`, 
    `a`.`letters_number`, 
    `a`.`sends_name` 
	";
	
	$dbname="
		`mail_management` AS `a` LEFT JOIN `memberdata` AS `b` 
		ON `a`.`m_username` = `b`.`m_username`
	";
	
	$where="
		AND `disable` = '0'
		ORDER BY `a`.`receives_time` DESC
	";
  $pages->setDb($dbname,$where,$expression);
  $pages->action_mode('view_all_data');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindex_mail.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindex_mail_view.php');
}
//////////////////////////////////////////////////////////////////////////
?>
