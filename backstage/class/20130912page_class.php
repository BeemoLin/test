﻿<?php
/*
20121112:修改getFirstpage3函數 改成post_to_url 參數life_name改成equipment_id





*/




class sam_pages_class{

  var $dbname;                // 資料庫名稱
  var $where;                 // 資料庫篩選條件
  var $expression;            // 資料庫篩選項目
  var $count;                 // 資料筆數搜尋語法
  var $sql;                   // 資料搜尋語法
  var $returnData;            // 該頁資料
  var $page_name;
  
  var $records_per_page;      // 每頁顯示筆數
  var $now_page;              // 目前所在頁數  
  var $total_records;         // 資料總數
  var $total_pages;           // 總分頁數
  var $view_page;             // 可顯示頁數
  var $action_mode;           // action_mode 型態
  var $link_type;             // 連接型態 (目前未使用)

  function setDb($dbname,$where,$expression = null){                           //設定資料庫及取得搜尋語法
    $this->dbname = $dbname;
    $this->where = $where;
    $this->expression = $expression;
    $this->count = "SELECT count(1) FROM ".$this->dbname." where 1 = 1 ".$this->where." ";
    if ($expression == null){
      $this->sql = "SELECT * FROM ".$this->dbname." where 1 = 1 ".$this->where." ";
    }else{
      $this->sql = "SELECT ".$this->expression." FROM ".$this->dbname." where 1 = 1 ".$this->where." ";
    }
  }

  function query(){
    mysql_query($this->sql); 
  }

  function total(){
    $count_no = mysql_query($this->count); 
    $data1 = mysql_fetch_row($count_no); 
    $this->total_records = $data1[0]; 
    return $this->total_records;
  }
  
  function setPerpage($records_per_page, $now_page = 1){     //設定每頁顯示筆數及取得資料數量、最大頁數
    $this->records_per_page = $records_per_page; //每頁顯示項目數量
    $count_no = mysql_query($this->count); 
    $data1 = mysql_fetch_row($count_no); 
    $this->total_records = $data1[0];            //資料總數
    $this->total_pages = ceil($this->total_records/$this->records_per_page); //總分頁數
    if (empty($now_page)){
      $this->now_page = 1;                  //目前頁數
    }
    else{
      $this->now_page = $now_page;                  //目前頁數
    }
    $start = ($this->now_page-1) * $this->records_per_page;
    $this->sql = $this->sql." LIMIT ".$start." , ".$this->records_per_page."";
  }

  function setActionmode($actionmode,$page){                             //設定連接型態(未使用)
    //$this->actionmode = $actionmode;
    //$this->tblname = $tblname;
  }

  function set_base_page($page_name){
    $this->page_name = $page_name;
  }
  
  function getFirstpage($page_name = null){                                  //取得第一頁
    $page="";
    //$page.='<a href="?page=1" >第一頁</a>' ;
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'tblname\':\'news_album\',\'action_mode\':\'view_all_data\',\'page\':\'1\'})">第一頁</a>'."&nbsp;" ;
    return $page;
  }
  
  function getEndpage($page_name = null){                                    //取得最終頁
    $page="";
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'tblname\':\'news_album\',\'action_mode\':\'view_all_data\',\'page\':\''.$this->total_pages.'\'})">第終頁</a>' ;
    return $page;
  }
  
  function getListpage($view_page, $page_name = null){               //取得頁數列表
    $page='';
    $this->view_page = $view_page;
    if($this->now_page-$this->view_page>1){
      $page.="...&nbsp;";
    }
    for($i=$this->now_page-$this->view_page;$i<$this->now_page;$i++){
      if($i>0){
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\'view_all_data\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
      }
    }
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\'view_all_data\',\'page\':\''.$this->now_page.'\'})" style="font-weight:bold;color:red;">'.$this->now_page.'</a>'."&nbsp;" ;
    for($i=$this->now_page+1;$i<=$this->now_page+$this->view_page;$i++){
      if($i<=$this->total_pages){
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\'view_all_data\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
      }
    }
    if($this->now_page+$this->view_page<$this->total_pages){
      $page.="...&nbsp;";
    }
    return $page;
  }
  
  function getData(){
    $this->returnData=null;
    $count_no = mysql_query($this->sql); 
    //echo $this->sql."<br>\n";
    $i=0;
    while($data = mysql_fetch_assoc($count_no)){
      $i++;
      foreach ($data as $key => $value){
        $returnData["$i"]["$key"] = $value;
      }
    }
    if (isset($returnData)){
      return $returnData;
    }
  }
  
  
  
  function action_mode($action_mode){
    $this->action_mode = $action_mode;
  }
  
  function getFirstpage2($page_name = null){                                  //取得第一頁
    $page="";
    //$page.='<a href="?page=1" >第一頁</a>' ;
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\'1\'})">第一頁</a>'."&nbsp;" ;
    return $page;
  }
  
  function getEndpage2($page_name = null){                                    //取得最終頁
    $page="";
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$this->total_pages.'\'})">第終頁</a>' ;
    return $page;
  }
  
  function getListpage2($view_page,$page_name = null){               					//取得頁數列表
    $page='';
    $this->view_page = $view_page;
    if($this->now_page-$this->view_page>1){
      $page.="...&nbsp;";
    }
    for($i=$this->now_page-$this->view_page;$i<$this->now_page;$i++){
      if($i>0){
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
      }
    }
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$this->now_page.'\'})" style="font-weight:bold;color:red;">'.$this->now_page.'</a>'."&nbsp;" ;
    for($i=$this->now_page+1;$i<=$this->now_page+$this->view_page;$i++){
      if($i<=$this->total_pages){
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
      }
    }
    if($this->now_page+$this->view_page<$this->total_pages){
      $page.="...&nbsp;";
    }
    return $page;
  }


//==================================================================食衣住行的分頁

    function getFirstpageForBackStage3($equipment_id, $page_name = null){                                  //取得第一頁 (生活資訊特製)
    $page="";
    //$page.='<a href="?page=1" >第一頁</a>' ;
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'life_name\':\''.$equipment_id.'\',\'page\':\'1\'})">第一頁</a>'."&nbsp;" ;
    //var_dump($page);
    return $page;
  }
  
  function getEndpageForBackStage3($equipment_id, $page_name = null){                                    //取得最終頁 (生活資訊特製)
    $page="";
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'life_name\':\''.$equipment_id.'\',\'page\':\''.$this->total_pages.'\'})">第終頁</a>' ;
     //var_dump($page);
    return $page;
  }
  //----頁數 呈現的方式修改 要研究看看  一個是現在停留(Prepage)的頁數與要選擇(Nowpage)的頁數切換 比對 要去絕對值 且要記錄
  function getListpageForBackStage3($equipment_id, $view_page,$page_name = null)
  {               					//取得頁數列表 (生活資訊特製)
    $page='';
    $this->view_page = $view_page; //點到的頁數
    
    // echo "什麼是NOW_PAGE:".$this->now_page;
    // echo "什麼是VIEW_PAGE:".$this->view_page;
    
    //1.假設頁面上為3頁;如果點第4頁代表要往後推頁數不SHOW第一頁只SHOW...234
    //應該是說當有10頁 點了第9頁 前面1234不顯示 只顯示5678910
    if($this->now_page-$this->view_page>1) //只有可能有頁數 但沒有數字的頁數 怪???????
    {
      $page.="...&nbsp;";
    }
    
     //$i從 假設點  view_page=5
    
    //2.顯示數字1.2.3.4......$i<$this->now_page 從0開始,到點的頁數;所以代表前面區塊的頁數;如點3 只跑 1 2
    for($i=$this->now_page-$this->view_page;$i<$this->now_page;$i++)
    {
      if($i>0)
      {
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'life_name\':\''.$equipment_id.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
       // echo "2.".$page."頁";
      }
    }
    //echo "2.".$page."頁";
    //3.頁上上呈現現在被點的頁數為紅色;目前的頁數;如點3 只跑3
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'life_name\':\''.$equipment_id.'\',\'page\':\''.$this->now_page.'\'})" style="font-weight:bold;color:red;">'.$this->now_page.'</a>'."&nbsp;" ;
    
    //如點3 從4開始 到total_pages
    for($i=$this->now_page+1;$i<=$this->now_page+$this->view_page;$i++)
    {
      if($i<=$this->total_pages)
      {
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'life_name\':\''.$equipment_id.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
        //echo "4.".$page."頁";
      }
    }
    //5.當$this->now_page+$this->view_page 小於總頁數 顯示時頁數後面加...
    if($this->now_page+$this->view_page<$this->total_pages)
    {
      $page.="...&nbsp;";
    }
     //var_dump($page);
    return $page;
  }

  //==========================================================================================================================











  //------------------------20121112-------------------------
  function getFirstpage3($equipment_id, $page_name = null){                                  //取得第一頁 (生活資訊特製)
    $page="";
    //$page.='<a href="?page=1" >第一頁</a>' ;
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'equipment_id\':\''.$equipment_id.'\',\'page\':\'1\'})">第一頁</a>'."&nbsp;" ;
    return $page;
  }
  
  function getEndpage3($equipment_id, $page_name = null){                                    //取得最終頁 (生活資訊特製)
    $page="";
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'equipment_id\':\''.$equipment_id.'\',\'page\':\''.$this->total_pages.'\'})">第終頁</a>' ;
    return $page;
  }
  //----頁數 呈現的方式修改 要研究看看  一個是現在停留(Prepage)的頁數與要選擇(Nowpage)的頁數切換 比對 要去絕對值 且要記錄
  function getListpage3($equipment_id, $view_page,$page_name = null)
  {               					//取得頁數列表 (生活資訊特製)
    $page='';
    $this->view_page = $view_page; //點到的頁數
    
    // echo "什麼是NOW_PAGE:".$this->now_page;
    // echo "什麼是VIEW_PAGE:".$this->view_page;
    
    //1.假設頁面上為3頁;如果點第4頁代表要往後推頁數不SHOW第一頁只SHOW...234
    //應該是說當有10頁 點了第9頁 前面1234不顯示 只顯示5678910
    if($this->now_page-$this->view_page>1) //只有可能有頁數 但沒有數字的頁數 怪???????
    {
      $page.="...&nbsp;";
    }
    
     //$i從 假設點  view_page=5
    
    //2.顯示數字1.2.3.4......$i<$this->now_page 從0開始,到點的頁數;所以代表前面區塊的頁數;如點3 只跑 1 2
    for($i=$this->now_page-$this->view_page;$i<$this->now_page;$i++)
    {
      if($i>0)
      {
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'equipment_id\':\''.$equipment_id.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
       // echo "2.".$page."頁";
      }
    }
    //echo "2.".$page."頁";
    //3.頁上上呈現現在被點的頁數為紅色;目前的頁數;如點3 只跑3
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'equipment_id\':\''.$equipment_id.'\',\'page\':\''.$this->now_page.'\'})" style="font-weight:bold;color:red;">'.$this->now_page.'</a>'."&nbsp;" ;
    
    //如點3 從4開始 到total_pages
    for($i=$this->now_page+1;$i<=$this->now_page+$this->view_page;$i++)
    {
      if($i<=$this->total_pages)
      {
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'equipment_id\':\''.$equipment_id.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
        //echo "4.".$page."頁";
      }
    }
    //5.當$this->now_page+$this->view_page 小於總頁數 顯示時頁數後面加...
    if($this->now_page+$this->view_page<$this->total_pages)
    {
      $page.="...&nbsp;";
    }
    
    return $page;
  }
  //------------------------20121112-------------------------
  function getFirstpage4($keyword, $page_name = null){                                  //取得第一頁 (查詢發放特製)
    $page="";
    //$page.='<a href="?page=1" >第一頁</a>' ;
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'keyword\':\''.$keyword.'\',\'page\':\'1\'})">第一頁</a>'."&nbsp;" ;
    return $page;
  }
  
  function getEndpage4($keyword, $page_name = null){                                    //取得最終頁 (查詢發放特製)
    $page="";
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'keyword\':\''.$keyword.'\',\'page\':\''.$this->total_pages.'\'})">第終頁</a>' ;
    return $page;
  }
  
  function getListpage4($keyword, $view_page,$page_name = null){               					//取得頁數列表 (查詢發放特製)
    $page='';
    $this->view_page = $view_page;
    if($this->now_page-$this->view_page>1){
      $page.="...&nbsp;";
    }
    for($i=$this->now_page-$this->view_page;$i<$this->now_page;$i++){
      if($i>0){
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'keyword\':\''.$keyword.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
      }
    }
    $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'keyword\':\''.$keyword.'\',\'page\':\''.$this->now_page.'\'})" style="font-weight:bold;color:red;">'.$this->now_page.'</a>'."&nbsp;" ;
    for($i=$this->now_page+1;$i<=$this->now_page+$this->view_page;$i++){
      if($i<=$this->total_pages){
        $page.='<a href="#" onclick="post_to_url(\''.$this->page_name.'\', {\'action_mode\':\''.$this->action_mode.'\',\'keyword\':\''.$keyword.'\',\'page\':\''.$i.'\'})">'.$i.'</a>'."&nbsp;" ;
      }
    }
    if($this->now_page+$this->view_page<$this->total_pages){
      $page.="...&nbsp;";
    }
    return $page;
  }
  
  
}

class data_function{

  var $dbname;
  var $where;
  var $expression; 
  var $count;
  var $sql;
  var $image_dir;

  function setDb($dbname){
    $this->dbname = $dbname;
  }

  function query(){
    mysql_query($this->sql); 
  }
  
function select($where_expression,$select_expression = null){
    if($select_expression == null){
      $this->sql = "SELECT * FROM ".$this->dbname." where 1 = 1 ".$where_expression." ";
    }
    else{
      $this->sql = "SELECT ".$select_expression." FROM ".$this->dbname." where 1 = 1 ".$where_expression." ";
    }
    //die($this->sql);
    $count_no = mysql_query($this->sql) or die(mysql_error()); 
    $i=0;
    while($data = mysql_fetch_assoc($count_no)){
      $i++;
      foreach ($data as $key => $value){
        $returnData["$i"]["$key"] = $value;
      }
    }
    if (isset($returnData)){
      return $returnData;
    }
  }
  
  function insert($insert_expression){
    $this->sql='INSERT INTO '.$this->dbname.' SET '.$insert_expression;
    //die($this->sql);
    mysql_query($this->sql) or die(mysql_error());
    return mysql_insert_id();
  }  
  
  function update($where_expression,$update_expression){
    $this->sql = "UPDATE ".$this->dbname." SET ".$update_expression." WHERE 1 = 1 ".$where_expression." ";
    //die($this->sql);
    mysql_query($this->sql) or die(mysql_error());
  }
  
  function delete($where_expression){
    $this->sql="DELETE FROM ".$this->dbname." WHERE 1 = 1 ".$where_expression." ";
    //die($sql);
    mysql_query($this->sql) or die(mysql_error());
  }
  
  function upsert($insert_expression,$update_expression){
    $this->sql = "INSERT INTO ".$this->dbname." SET ".$insert_expression." ON DUPLICATE KEY UPDATE ".$update_expression." ";
    mysql_query($this->sql) or die(mysql_error());
  }
  /*
INSERT 加上 update 的特殊語法
例：
  INSERT INTO 
    `ccdemo`.`info` 
  SET 
    `info_id`=6, `info_name`='ccc', `info_url`='ccc'
  ON DUPLICATE KEY UPDATE
    `info_url` =  'eee'
;
  */
  
  function total($where){
    $this->count = "SELECT count(1) FROM ".$this->dbname." where 1 = 1 ".$where." ";
    $count_no = mysql_query($this->count); 
    $data1 = mysql_fetch_row($count_no); 
    $this->total_records = $data1[0]; 
    //die($this->count);
    return $this->total_records;
  }
  
  function postiswho($_POST){
    $no = 0;
    $txt = "";
    foreach ($_POST as $k1 => $v1){
      if(!is_array($v1)){
        if($no == 0){
          $txt .= " $k1 = '$v1'";
        }
        else{
          $txt .= ", $k1 = '$v1'";
        }
      }
      $no++;
    }
    return $txt;
  }
  
  function postiswho2($my_array){
    $no = 0;
    $txt = "";
    foreach($my_array as $value){
      foreach ($_POST as $k1 => $v1){
        if(!is_array($v1)){
          if($k1 == $value){
            if($no == 0){
              $txt .= " $k1 = '$v1'";
            }
            else{
              $txt .= ", $k1 = '$v1'";
            }
            $no++;
          }
        }
      }
    }
    return $txt;
  }
  
  function assembly_files($_FILES,$pic_subject = null){
    if(isset($_FILES)){
      foreach ($_FILES as $k1 => $v1){
        foreach ($v1 as $k2 => $v2){
          foreach ($v2 as $k3 => $v3){
            if(isset($v3)){
              $ufile[$k3][$k1][$k2] = $v3;
              $no = $k3+1;
              $ufile[$k3][$k1][$pic_subject] = $_POST[$pic_subject.$no];
            }
          }
        }
      }
      return $ufile;
    }
    return null;
  }
  
  function foreach_checked($array){
    foreach ($array as $k1 => $v1){
      foreach ($v1 as $k2 => $v2){
        echo '$array['.$k1.']['.$k2.']='.$v2."<br />\n";
      }
    }
  }
  
  
  function add_category($expression){
    $sql='INSERT INTO '.$this->dbname.' SET '.$expression;
    mysql_query($sql) or die(mysql_error());
  }
  
  function delete_category($album_id){
    $sql="DELETE FROM ".$this->dbname." WHERE album_id = '".$album_id."'";
    mysql_query($sql) or die(mysql_error());
  }
  
  function update_album($dbname,$where,$expression){
    $sql = "UPDATE ".$dbname." SET ".$expression." WHERE 1 = 1 ".$where." ";
    mysql_query($sql) or die('error');
  }

  function update_image($album_id,$img_dir,$files,$ap_subject){
    $img_dir = $img_dir.'/';

    for($x = 0 ;$x < 5 ;$x++){
      //檢測檔案
      $filename = $files['ap_picurl']['name'][$x];
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
        $this->ImageCopyResizedTrue2($files['ap_picurl']['tmp_name'][$x],$img_dir.$new_filename,800,600);
        unlink($files['ap_picurl']['tmp_name'][$x]);

        $expression = "`album_id`='".$album_id."', `ap_picurl` = '".$new_filename."', `ap_subject`	= '".$ap_subject[$x]."'";
        $this->insert($expression);
      }
    }    
  }
  
  function update_image2($share_id,$img_dir,$files,$ap_subject){
    $img_dir = $img_dir.'/';

    for($x = 0 ;$x < 5 ;$x++){
      //檢測檔案
      $filename = $files['ap_picurl']['name'][$x];
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
        $this->ImageCopyResizedTrue2($files['ap_picurl']['tmp_name'][$x],$img_dir.$new_filename,800,600);
        unlink($files['ap_picurl']['tmp_name'][$x]);

        $expression = "`share_id`='".$share_id."', `ap_picurl` = '".$new_filename."', `ap_subject`	= '".$ap_subject[$x]."'";
        $this->insert($expression);
      }
    }    
  }
  
  function update_image_function($img_dir,$files,$file_name){ // BUG 發現不能多傳
    $img_dir = $img_dir.'/';

    for($x = 0 ;$x < 5 ;$x++){
      //檢測檔案
      $filename = $files["$file_name"]['name'][$x];
      if(!empty($filename)){
        $img_name = explode(".",$filename);
        $num = count($img_name);
        $second_name = strtolower($img_name[$num-1]);
        $second_name = strtolower($second_name);
        if( $second_name!="jpg" and $second_name!="jpeg" and $second_name!="gif" )
        {
          return 'alert("系統僅能接受JPG、GIF之圖形檔案！");';
        }
      
         //指定新的檔案名稱
        $time=date("Ymdhis").$x;
        $new_filename  = $time.".".$second_name;
        $this->ImageCopyResizedTrue2($files["$file_name"]['tmp_name'][$x],$img_dir.$new_filename,800,600);
        unlink($files["$file_name"]['tmp_name'][$x]);
        
        return $new_filename;
        //$expression = "`share_id`='".$share_id."', `ap_picurl` = '".$new_filename."', `ap_subject`	= '".$ap_subject[$x]."'";
        //$this->insert($expression);
      }
    }    
  }
  
  function add_image($img_dir,$name,$tmp_name){
    $img_dir = $img_dir.'/';
    if(!empty($name)){
      $img_name = explode(".",$name);
      $num = count($img_name);
      $second_name = strtolower($img_name[$num-1]);
      $second_name = strtolower($second_name);
      if( $second_name!="jpg" and $second_name!="jpeg" and $second_name!="gif" )
      {
        alert("系統僅能接受JPG、GIF之圖形檔案！");
      }
      $time=date("Ymdhis");
      $new_filename  = $time.".".$second_name;
      //$this->ImageCopyResizedTrue2($tmp_name,$img_dir.$new_filename,800,600);
      $this->ImageCopyResizedTrue2($tmp_name,$img_dir.$new_filename,750,563);
      unlink($tmp_name);
      return $new_filename;
    }
  }
  
  function set_image_dir($image_dir){
    $this->image_dir = $image_dir;
  }
  
  function add_image2($name,$tmp_name,$front_name,$height,$width){
    if(!empty($name)){
      $img_name = explode(".",$name);
      $num = count($img_name);
      $second_name = strtolower($img_name[$num-1]);
      //die($second_name);
      if( $second_name!="jpg" and $second_name!="jpeg" and $second_name!="gif" ){
        //alert("系統僅能接受JPG、GIF之圖形檔案！");
        die('error');
      }
      $time=date("Ymdhis");
      $new_filename  = $front_name.$time.".".$second_name;
      $this->ImageCopyResizedTrue2($tmp_name,$this->image_dir.'/'.$new_filename,$height,$width);
      unlink($tmp_name);
      return $new_filename;
    }
  }
  
  function delete_image($where,$img_dir,$name){
    if (isset($where)) {
      $this->delete($where);
      unlink($img_dir.'/'.$name);
    }
  }
  
  function delete_image2($where,$img_dir,$name){
	//die($img_dir.'/'.$name);
    unlink($img_dir.'/'.$name);
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

  function ImageCopyResizedTrue2($src, $dest, $maxWidth,  $maxHeight, $quality=100) {
    if (file_exists($src) && isset($dest)) {
      $destInfo = pathInfo($dest);
      $srcSize = getImageSize($src);
      $srcRatio = $srcSize[0] / $srcSize[1];
      $destRatio = $maxWidth / $maxHeight;
      if ($maxWidth > $srcSize[0] and $maxHeight > $srcSize[1]) {// 原始長寬都比設定長寬小
        $destSize[0] = $srcSize[0];
        $destSize[1] = $srcSize[1];
      } else{
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
}
?>
