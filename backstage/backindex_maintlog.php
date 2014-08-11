<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
include(BCLASS.'/head.php');
/*if(count($_POST)>0){ foreach($_POST as $k=>$v){ echo $$k."=".$v; } }*/

$action_mode=(isset($_POST['action_mode']))?$_POST['action_mode']:null;
$page=(isset($_POST['page']))?$_POST['page']:1;

//include(BCLASS.'/head.php');
//1每一筆的時間
function ChangRowColor($rowtime){
  $year = substr($rowtime, 0 ,4);
  $month = substr($rowtime, 5 ,2);
  $day = substr($rowtime, 8 ,2);
  $timesub = mktime(0,0,0, date("m"), date("d"), date("Y") ) - mktime(0,0,0, $month, $day , $year );
  //現在日期-保養日期 > 1天
   return ($timesub>=(86400*1))?'#ffaaaa':'#ddeedd';

}
function CrossRowColor($rowno){
   return (($rowno%2)==1)?'#ddeedd':'#ddddee';
}


function MARK(){
 /*
    處理 選擇點選checkbox的value值
    $chkbox=$_POST['chkbox'];
    $count_chkbox=count($chkbox)-1;

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
  //IN ($all_no)
  $pages->setDb('mail_management',"AND `id` IN ($all_no) ORDER BY `receives_time` DESC ", "*");
  $data3 = $pages->getData();*/
}
function MARK1(){
 /* 新增或修改表頭
      $data_function = new data_function;
      $data_function->setDb("maintainlog");
      $my_array = array($input_date, $input_location, $input_title, $input_desc);
      $expression = $data_function->postiswho2($my_array);
      
      if(!empty($_POST[$input_id])){
        $$input_id = $_POST[$input_id];
        $where_expression = "AND `$input_id`='".$$input_id."'"; 
        $update_expression = $expression;
        $data_function->update($where_expression,$update_expression); 
      }
      else{
    
        $insert_expression = $expression;
        $insert_id = $data_function->insert($insert_expression);
        $$input_id = $insert_id;
      }*/
}
function MARK2(){
/*      
      if(isset($_POST['ap_subject']) && isset($_POST[$pic_id]) ){
        $ap_subject = $_POST['ap_subject'];
        $$input_id = $_POST[$input_id];
        $$pic_id = $_POST[$pic_id];
        $data_function = new data_function;
        $data_function->setDb($photo_name);
        $where = "AND `$pic_id` = '".$$pic_id."'";
        $expression = " ap_subject='".$ap_subject."'";
        $data_function->update($where,$expression); 
      }
*/
      //$action_mode='addpic';
     /* $pages = new sam_pages_class;
      
      //表頭
      $pages->setDb($album_name," AND $input_id = '".$$input_id."'","*");
      $row_Rec = $pages->getData();
      
      //表身
      $pages->setDb($photo_name," AND $input_id = '".$$input_id."'","*");
      $row_RecPhoto = $pages->getData();*/
}
function ViewEquLog($maint_id,$page,&$equname,&$coname,&$Firstpage,&$Listpage,&$Endpage,&$maintData){
    $data_function = new data_function; //建立資料庫物件
    $data_function->setDb("maintain");
    $where_expression = "AND `maint_id` = '".$maint_id."' ";
    $data = $data_function->select($where_expression);
    
    $pages = new sam_pages_class;
    $pages->action_mode('index');
    $pages->setDb('maintainlog', "AND maint_id=".$maint_id." AND check_state=0 ORDER BY `uid` DESC ", '*');
    $pages->setPerpage(10,$page);
    $pages->set_base_page('backindex_maintlog.php');
    
    //return
    $equname=$data[1]["maint_name"];
    $coname=$data[1]["maint_co"];
    //使用javascript創建另一個FORM去submit 並且增加hidden元件做POST參數用
    $Firstpage = $pages->getFirstpage3($maint_id);
    $Listpage = $pages->getListpage3($maint_id,2);
    $Endpage = $pages->getEndpage3($maint_id);
    $maintData = $pages->getData();
    
}
function ShowSelectData($uid,&$data,&$row_RecPhoto,&$main_name,&$main_id){
    $pages = new sam_pages_class;
  
    //表頭
    $pages->setDb('maintainlog',"AND uid=".$uid,'*');
    $data = $pages->getData();
    //表身
    $pages->setDb('maintainlog_photo'," AND maintainlog_uid=".$uid,"*");
    $row_RecPhoto = $pages->getData();
    
    $pages->setDb('maintain',"AND maint_id=".$data[1]["maint_id"],'maint_name');
    $equdata = $pages->getData();
    
    
    $equname=$equdata[1]["maint_name"];
    $main_id=$data[1]["maint_id"];
    //MARK();
  //$action_mode = "checkmaint"; 
    $main_name = "驗收設備:".$equname;
    //$equnameid=$data[1]["maint_id"];
    
}
function IsertCheckPicANDLog($uid,$pic_subject,$pic_url,$img_dir){
        //新增表身
        $data_function = new data_function;
        $data_function->setDb('maintainlog_photo');
       
        $ufile = $data_function->assembly_files($_FILES,$pic_subject);
         
        foreach($ufile as $v1){
          $files_name = $v1[$pic_url]['name'];
          $file_tmp_name = $v1[$pic_url]['tmp_name'];
          $$pic_subject = $v1[$pic_url][$pic_subject];
          if(!empty($files_name)){
            $new_filename = $data_function->add_image($img_dir,$files_name,$file_tmp_name);
            sleep(1);
            $expression = "`maintainlog_uid`='".$uid."', `$pic_url` = '".$new_filename."', `$pic_subject` = '".$$pic_subject."'";
            $data_function->insert($expression);
          }
        }

}
function DelCheckImg($img_dir){
	 
   //post_to_url:'maintainlog_uid','uid','check_picurl','img_dir'
   if( isset($_POST['uid']) && isset($_POST['check_picurl']) ){
    $where = "AND `uid` = ".$_POST['uid'];
    $name = $_POST['check_picurl'];
    
    $data_function = new data_function;
    $data_function->setDb('maintainlog_photo');
    $data_function->delete_image($where,$img_dir,$name);
  }
  
    /*$action_mode='update';
    $pages = new sam_pages_class;
    $pages->setDb($album_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_Rec = $pages->getData();
    $pages->setDb($photo_name," AND $input_id = '".$_POST[$input_id]."'","*");
    $row_RecPhoto = $pages->getData();
    include(VIEW.'/add_and_edit_view.php');*/
}
function UpdCheckImg($pic_subject){

 if(isset($_POST['uid'])){
    $pic_id = $_POST['uid'];
    $$pic_subject = $_POST[$pic_subject];
    
    
    $where_expression = "AND `uid` =".$pic_id;
    
    $update_expression = " `$pic_subject` = '".$$pic_subject."'";
    
    
    
    $data_function = new data_function;
    $data_function->setDb('maintainlog_photo');
    //$data_function->delete_image($where,$img_dir,$name);
    $data_function->update($where_expression, $update_expression); 
  }
}

function ViewCheckLog($page,&$equname,&$coname,&$maint_id,&$keyword,&$data,&$Firstpage,&$Listpage,&$Endpage){
    $maint_id=$_POST['equipment_id'];
   
    $data_function = new data_function; //建立資料庫物件
    $data_function->setDb("maintain");
    $where_expression = "AND `maint_id` = '".$maint_id."' ";
    $data = $data_function->select($where_expression);
 
    $equname=$data[1]["maint_name"];
    $coname=$data[1]["maint_co"];
  
    //查詢關鍵字
      $keyword='';
      if(isset($_POST['wkoa'])){ //按鈕搜尋:submit
        $what_kind_of_action = $_POST['wkoa'];
        if($what_kind_of_action=='keyin'){
         
          if(isset($_POST['keyword'])){
            
            $_SESSION['SQL']=$_POST['keyword'];
            $keyword=$_POST['keyword'];
          }
        }
        elseif($what_kind_of_action=='turn'){ //應該不會執行
           
          if(isset($_SESSION['SQL'])){
           
            $keyword=$_SESSION['SQL'];
          }
        }
      }else{ //頁數:submit
        
        if(isset($_POST['keyword'])){
          
          $_SESSION['SQL']=$_POST['keyword'];
          $keyword=$_POST['keyword'];
        }
      }
      
      
      if (!empty($keyword)){
          $txt_sql="
          AND `check_state` = 1
          AND (`check_time` LIKE '%".$keyword."%' 
          OR `remark` LIKE '%".$keyword."%') 
          ORDER BY `uid` DESC
          ";
          /*
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
          */
      }
      else{
         $txt_sql= " AND `check_state`=1 ORDER BY `uid` DESC";
        /*  $txt_sql="
          AND `disable` = '1' 
          ORDER BY `a`.`takes_time` DESC
    	  ";*/
      }
      
      $pages = new sam_pages_class;
      $pages->action_mode('checkequyes');
      $pages->setDb('maintainlog',"AND `maint_id`=".$maint_id." ".$txt_sql,'*');
      $pages->setPerpage(10,$page);
      $pages->set_base_page('backindex_maintlog.php');
      
      $Firstpage = $pages->getFirstpage5($maint_id,$keyword);
      $Listpage = $pages->getListpage5($maint_id,$keyword,5);
      $Endpage = $pages->getEndpage5($maint_id,$keyword);
      
      $data = $pages->getData();


}

function SendCheck(){
       
   // $sendorupdate=$_POST['sendorupdate'];//20130116 新增
//-----------------------------------信件發放:單筆 與 多筆 (所以要跑迴圈把簽名塞到每一列記錄中)-------------------------------------------
    $post=$_POST['arr'];//arr:二維陣列 被選取發放信件的列
  
  //  @$chkbox=$_POST['chkbox'];//null;
  
    $sign_code=$_POST['sign_code'];//住戶簽名
   
    $admin_sign_code=$_POST['admin_sign_code'];//管理員簽名
   
  
  //@$space1_code=$_POST['space1_code'];//@代表出錯不顯示錯誤訊息
  //@$space2_code=$_POST['space2_code'];

 
  
  $count_post=count($post);//被選取的信件筆數
  $ccount_post=count($post[$count_post-1]);//每一筆信件的攔位數量
  
  
  //$test=$_POST['cou']; $_post[]取html 屬性name 的value值 不是取屬性ID
  //1列6欄
  //var_dump("列:".$count_post);
  //var_dump("====");
  //var_dump("欄:".$ccount_post);
 

  $pages = new data_function;
  $pages->setDb('maintainlog');
  //$sendmailflag="0";//20130117,新增
  for($x=0;$x<=($count_post-1);$x++){//要更新到資料庫;跑筆數
     
    $q2=(empty($post[$x]['check_time']))?"`check_time` = NOW( )":"`check_time` = '".$post[$x]['check_time']."'";
    
   // $main_name = '信件發放';
    //---------------------------------------------------使用Update方式-----------------------------------------------
   
      $update_expression = "".
        $q2.",
        `maint_name` = '".$sign_code."',
        `check_name` = '".$admin_sign_code."',
        
        `maint_state` = '".@$post[$x]['showmaint']."',
        `check_state` = '".@$post[$x]['showcheck']."',
        `remark` = '".$post[$x]['remark']."'";
      
      $where_expression = "AND `uid` =".$post[$x]['uid'];
      
      $pages->update($where_expression,$update_expression);
  }
   GotoMaintPage();
}
function CancelCheck(){
 // $main_name = '查詢發放信件';
      @$chkbox=$_POST['chkbox'];
      $count_chkbox=count($chkbox)-1;//一維陣列

      $all_no='';

      for($x=0;$x<=$count_chkbox;$x++){
        $all_no =($x!=$count_chkbox)?$all_no."$chkbox[$x],": $all_no."$chkbox[$x]";
      }
      
    $no=0;
    if($count_chkbox>=0){
      $pages = new data_function;
    ////////////////////////////////
      $pages->setDb('maintainlog');
      //---------------------------------------------當按取消此攔位全清空(狀態的改變)-------------------------------------------
      $update_expression = " `maint_state` = 0,`check_state` = 0, `maint_name` = NULL, `check_name` = NULL, `check_time` = NULL ";
      $where_expression = " AND `uid` IN ($all_no) ";
      $pages->update($where_expression,$update_expression);
    }
    GotoMaintPage();
}


function GotoMaintPage(){
    echo "<script language='JavaScript'>";
    echo "window.location.href = 'backindex_maint.php'";
    echo "</script>";
}
  


  $img_dir="maintlog_photo";
  $pic_max = '10';
  $pic_url = "check_picurl";
  $pic_subject = "check_picurl_subject";  
  $enable_pic_subject = 'true';
  $img_title="新增驗收照片";
  //$pic_id = "maintainlog_uid"; 
  $form = 'backindex_maintlog.php';
 // $tb_maintainlog_photo='maintainlog_photo';
  //字串可以用變數取代掉;這樣以後共同的版型,只要改變數,不用動到程式
  
switch($action_mode){
  case "index":
  
    $maint_id=$_POST['equipment_id'];
    
    //撈出未驗證的;現在是全撈
    ViewEquLog($maint_id,$page,$equname,$coname,$Firstpage,$Listpage,$Endpage,$maintData);
  
    $main_name="驗收設備保養";
    include(VIEW.'/maintlog/index.php');
    break;
  case "checkmaint": //與backindex_mail.php action_mode=give_data比對
    
    $chkbox=$_POST['chkbox'];
    $uid=$chkbox[0];
   
    ShowSelectData($uid,$data,$row_RecPhoto,$main_name,$main_id);
    include(VIEW.'/maintlog/checkmaint.php');
  
  break;
  case "addpic": //update
      $uid=$_POST['uid'];
      
        //MARK1();
        IsertCheckPicANDLog($uid,$pic_subject,$pic_url,$img_dir);
        //MARK2();
        ShowSelectData($uid,$data,$row_RecPhoto,$main_name,$main_id);
        include(VIEW.'/maintlog/checkmaint.php');
       
      break;
 
  case "delete_image": 
      $uid=$_POST['maintainlog_uid'];
      
      DelCheckImg($img_dir);
      ShowSelectData($uid,$data,$row_RecPhoto,$main_name,$main_id);
      include(VIEW.'/maintlog/checkmaint.php');
    break;
  
  case "update_image":
      $uid=$_POST['maintainlog_uid'];
      UpdCheckImg($pic_subject);
      ShowSelectData($uid,$data,$row_RecPhoto,$main_name,$main_id);
      include(VIEW.'/maintlog/checkmaint.php');
    break;  
  case "checkequyes":
     ViewCheckLog($page,$equname,$coname,$maint_id,$keyword,$data,$Firstpage,$Listpage,$Endpage);
     $main_name = '查詢設備驗收';
      include(VIEW.'/maintlog/checkequyes.php');
    break;
  case "finish_check":////與backindex_mail.php action_mode=fix比對
      SendCheck();
    break;
  case "cancelcheck":
    CancelCheck();
    break;
 }
include(BCLASS.'/foot.php');
?>
