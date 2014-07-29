<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindexonline_view.php
  backindexonline_select_data_view.php
  backindexonline_selected_view.php
  backindexonlinere_view.php
mode_page:
  page_class.php
*/

//201407 by akai :增加報修條件
function ShowFixClass($datafunction,&$re_fix1,&$re_fix2,&$re_fix3){

  //大項
  $datafunction->setDb('fix1');
  $expression = " ORDER BY cID ASC";
  $re_fix1 = $datafunction->select($expression); 

  
  //中項
  $colname_re_fix2=(isset($_POST['county']))?$_POST['county']:"-1";
  
  $datafunction->setDb('fix2');
  $expression = " AND tCounty ='".$colname_re_fix2."'";
 
  $re_fix2 = $datafunction->select($expression); 
   
  //細項
  if($_POST['list_mode']=="allrefresh"){
    $colname_re_fix3="-1";
  }else{
    $colname_re_fix3=(isset($_POST['town']))?$_POST['town']:"-1";
  }
  $datafunction->setDb('fix3');
  $expression = " AND zTown ='".$colname_re_fix3."'";
  $re_fix3 =  $datafunction->select($expression);
}
//201407 by akai :組合報修條件字串
function CombineFixClass(&$sqllike){
  $sqllike.=(!empty($_POST['bigdetail']))?$_POST['bigdetail']."->":"";
  $sqllike.=(!empty($_POST['middetail']))?$_POST['middetail']."->":"";
  $sqllike.=(!empty($_POST['smalldetail']))?$_POST['smalldetail']:"";
}



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
//======================================================================================================================
//var_dump($action_mode);
if($action_mode=='view_all_data'){
  //die();
  $pages = new sam_pages_class;
  $pages->setDb('exl'," AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $pages->action_mode = $action_mode;
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}
elseif($action_mode=='view_all_data_yes'){
  $pages = new sam_pages_class;
  $pages->setDb('exl',"AND `exl_yesno` = '已完成' AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $pages->action_mode = $action_mode;
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}
elseif($action_mode=='view_all_data_no'){
  $pages = new sam_pages_class;
  $pages->setDb('exl',"AND `exl_yesno` = '未處理' AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $pages->action_mode = $action_mode;
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}
elseif($action_mode=='view_all_data_unknow'){
  $pages = new sam_pages_class;
  $pages->setDb('exl',"AND `exl_yesno` = '維修中' AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $pages->action_mode = $action_mode;
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}
//======================================================================================================================

elseif($action_mode=='select_data'){
  //die("test");
   
    $datafunction = new data_function;
    //===========2014/07/14 AKAI==================
    $datafunction->setDb('memberdata');
    $expression = " AND `m_level`='member' ORDER BY `m_id` ";
    $houser= $datafunction->select($expression); 
     //===========2014/07/14 AKAI==================
     
    ShowFixClass($datafunction,$re_fix1,$re_fix2,$re_fix3);
      
     
     
  include(VIEW.'/backindexonline_select_data_view.php');
}
elseif($action_mode=='selected_view'){

  

   
  $pages = new sam_pages_class;
  $selectSQL=null;
	if(!empty($_POST['exl_name'])){
		$selectSQL .= " AND exl_name= '".$_POST['exl_name']."'";
	}
	if(!empty($_POST['exl_yesno'])){
		$selectSQL .= " AND exl_yesno= '".$_POST['exl_yesno']."'";
	}
	if(!empty($_POST['from_date'])){
		$selectSQL .= " AND exl_date > '".$_POST['from_date']." 0:0:0'";
	}
	if(!empty($_POST['to_date'])){
		$selectSQL .= " AND exl_date < '".$_POST['to_date']." 23:59:59'";
	}
	if(!empty($_POST['from_date_repair'])){
		$selectSQL .= " AND exl_repair > '".$_POST['from_date_repair']." 0:0:0'";
	}
	if(!empty($_POST['to_date_repair'])){
		$selectSQL .= " AND exl_repair < '".$_POST['to_date_repair']." 23:59:59'";
	}
	
	
	CombineFixClass($sqllike);
	if(!empty($sqllike)){
    $selectSQL .= " AND exl_exl  LIKE '".$sqllike."%'";
  }
	
	
  $selectSQL .= "AND `disable` = '0' ORDER BY exl_date DESC";
  
  //var_dump($selectSQL);
  
  $pages->setDb('exl',$selectSQL,'*');
  $data = $pages->getData();
  include(VIEW.'/backindexonline_selected_view.php');
}
elseif($action_mode=='view_select_data'){

  if(isset($_POST['qa_id'])){
    $pages = new sam_pages_class;
    $pages->setDb("qa"," AND qa_id = '".$_POST['qa_id']."'","*");
    $row_Recordset = $pages->getData();
    $pages->setDb("qa_qa2","AND qa_yesno='yes' AND qa_id = '".$_POST['qa_id']."' GROUP BY qa_id ","count(1) as total");
    $yes = $pages->getData();
    if(!is_int($yes['1']['total'])){
      $yes['1']['total'] = '0';
    }
    $pages->setDb("qa_qa2","AND qa_yesno='no' AND qa_id = '".$_POST['qa_id']."' GROUP BY qa_id ","count(1) as total");
    $no = $pages->getData();
    if(is_int($no['1']['total'])){
      $no['1']['total'] = '0';
    }
    include(VIEW.'/backindexonlineshow_view.php');
  }
}
//----------總泰 edit,update 兩個模式
elseif($action_mode=='edit'){
 
  if(isset($_POST['exl_id'])){
    $pages = new sam_pages_class;
    $exl_id = $_POST['exl_id'];
    $where = "AND exl_id='".$exl_id."'";
    $pages->setDb('exl',$where,'*');
    $row_Rec_fix = $pages->getData(); 
    
    //=============增加========================
    if(0){
      $data_function = new data_function;
      $data_function->setDb('tcwaworker');
      $expression = "ORDER BY id";
      $worker = $data_function->select($expression); 
    }
    //=============增加========================
    
    //20140701 by akai MARK
     $dataexlbody = new data_function;
     $dataexlbody->setDb('exlbody');
      
     $expression = "AND exl_id = '" . $_POST['exl_id'] ."' AND exl_yesno='未處理' ORDER BY id DESC";
     $unfix= $dataexlbody->select($expression); 
     
     $expression = "AND exl_id = '" . $_POST['exl_id'] ."' AND exl_yesno='維修中' ORDER BY id DESC";
     $fixing= $dataexlbody->select($expression); 
     
     $expression = "AND exl_id = '" . $_POST['exl_id'] ."' AND exl_yesno='已完成' ORDER BY id DESC";
     $fixed= $dataexlbody->select($expression); 

     $dataexlbody->setDb('exl');
     $expression = "AND exl_id = '" . $_POST['exl_id'] ."' LIMIT 0,1";
     $maindata = $dataexlbody->select($expression);

    //20140701 by akai MARK
    include(VIEW.'/backindexonlinere_view.php');
  }
}
elseif($action_mode=='update'){

  //20140701 By akai
  //$preState= $_POST['preState'];
  $nowState= $_POST['exl_yesno'];
  //var_dump(($preState==$nowState)?"1":"0");
 // var_dump($nowState);
  
 //  $preMark= $_POST['preMark'];
//  die($preMark);
  $nowMark= $_POST['exl_remark'];
  //var_dump($preMark);//."==".$nowMark
  
  $billid=$_POST['exl_id'];
  
   
  $data_function = new data_function;
  $data_function->setDb('exlbody');
  $insert_expression = "
    `exl_id` = '".$billid."',
    `exl_date` = now( ),
    `exl_yesno` ='".$nowState."',
    `exl_remark` ='".$nowMark."',
    `exl_exl` ='',
    `exl_name` ='',
    `exl_adj` ='',
    `exl_phone` =''";
   // `receives_name` ='".$receives_name."'";
  $insert_id = $data_function->insert($insert_expression);
  
  //die();

 
  $data_function->setDb('exl');
	if ($_POST['exl_yesno']=='已完成'){
		$repair_time = 'exl_repair = now( ) ,';
	}
	else{
		$repair_time = "";
	}
  $where = "AND exl_id='".$_POST['exl_id']."'";
  $expression = " exl_yesno='".$_POST['exl_yesno']."' , ".$repair_time." exl_remark='".$_POST['exl_remark']."'"; //增加欄位員工代號
  $data_function->update($where,$expression);     
  
//=============================== //已完成寄出信件===========================================
  if($_POST['exl_yesno'] == 'yes' or $_POST['exl_yesno'] == '已完成') {
    //$_POST['exl_yesno'] == 'yes' ------> 相容舊版
    $data_function->setDb('exl');
    $expression = "AND exl_id='".$_POST['exl_id']."'";
    $repair_data = $data_function->select($expression); 

    $data_function->setDb('memberdata');
    $expression = "AND m_username = '" . $repair_data['1']['exl_name'] ."'";
    $member_data = $data_function->select($expression); 

    $data_function->setDb('adminuser');
    $maillist = $data_function->select(''); 
    
    include(SYSTEM.'/PHPMailer_v5.1/class.phpmailer.php');
    $message = file_get_contents(EMAIL_TEMPLATES.'/repair_finish.html');
      
    $message = str_replace('[c_subject]', 	C_SUBJECT, $message);
    $message = str_replace('[subject]', 	$repair_data['1']['exl_exl'], $message);
    $message = str_replace('[phone]', 		$repair_data['1']['exl_phone'], $message);
    $message = str_replace('[description]', $repair_data['1']['exl_adj'], $message);
    $message = str_replace('[username]', 	$member_data['1']['m_username'], $message);
    $message = str_replace('[status]', 		'已完成', $message);
    $message = str_replace('[remark]', 		$repair_data['1']['exl_remark'], $message);
    
    // Setup PHPMailer
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Host = 'msa.hinet.net';
    $mail->Port = 25;
    $mail->CharSet = "utf8";
    //$mail->SMTPAuth = true;
    //$mail->Username = 'service.tcwa@hinet.net';
    //$mail->Password = 'da909088';
    $mail->SetFrom('service.tcwa@hinet.net', C_SUBJECT);
    $mailto= explode(',', $maillist['1']['mail']);
    foreach ($mailto as $mrs){   
      $mail->AddAddress($mrs); 
    }
    //$mail->AddAddress($member_data['m_email']);
    $mail->Subject = C_SUBJECT."：".$member_data['1']['m_username'].' 線上報修通知 （己完成）';
    $mail->MsgHTML($message);
    //$mail->AltBody(strip_tags($message));
    if(!$mail->Send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
  }
//=============================== //已完成寄出信件===========================================
  $pages = new sam_pages_class;
  $pages->setDb('exl'," AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}
elseif($action_mode=='delete'){
  if(isset($_POST['exl_id'])){
    $data_function = new data_function;
    $data_function->setDb('exl');
    $exl_id = $_POST['exl_id'];
    $where = "AND exl_id='".$exl_id."'";
    //$data_function->delete($where);
    $expression = " disable='1'";
    $data_function->update($where,$expression);   
  }
  $pages = new sam_pages_class;
  $pages->setDb('exl'," AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}
else{
  $pages = new sam_pages_class;
  $pages->setDb('exl'," AND `disable` = '0' ORDER BY exl_date DESC",'*');
  $pages->setPerpage(10,$page);
  $pages->set_base_page('backindexonline.php');
  $Firstpage = $pages->getFirstpage2();
  $Listpage = $pages->getListpage2(2);
  $Endpage = $pages->getEndpage2();
  $data = $pages->getData();
  include(VIEW.'/backindexonline_view.php');
}

include(BCLASS.'/foot.php');
?>
