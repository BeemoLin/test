<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
舊模式用兩個資料夾放圖片，下次改版會改成只用一個資料夾
$img_dir = 'upfildes';
$img_dir2 = 'newpic';

view_page:
  backindexauthority_view.php
  backindexauthorityadd_view.php
  backindexauthorityre_view.php
mode_page:
  page_class.php
*/
$logoutAction = 'logout.php';
$logoutGoTo = 'backindex.php';
$order_name = 'order';    
$photo_name = 'order_photo'; 
$img_dir = 'upfildes';
$img_dir2 = 'newpic';
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
if($_SESSION['MM_UserGroup'] == '權限管理者'){
  if($action_mode=='view_all_data'){ //ok
    $pages = new sam_pages_class;
    $pages->setDb('memberdata','And m_level != "member"','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexauthority.php');
    $Listpage = $pages->getListpage(2,'backindexauthority.php');
    $Endpage = $pages->getEndpage('backindexauthority.php');
    $data = $pages->getData();
    include(VIEW.'/backindexauthority_view.php');
    //SELECT m_id, m_name, m_nick FROM memberdata WHERE m_username = %s
    //DELETE FROM memberdata WHERE m_id=%s
  }
  elseif($action_mode=='add_user_view'){ //ok
    //SELECT m_name FROM memberdata WHERE m_name=%s
    include(VIEW.'/backindexauthorityadd_view.php');
  }
  elseif($action_mode=='add_user'){ //ok
    $data_function = new data_function;
    $pages = new sam_pages_class;
    $data_function->setDb('memberdata');
    if(!empty($_POST['m_username'])){
      $m_username = $_POST['m_username'];
      $pages->setDb('memberdata'," AND m_username = '$m_username' ",'*');
      $total = (int)$pages->total();
      if($total>=1){
        echo "<script>alert('此帳號名稱己有人註冊！');history.go(-1);</script>";
        exit();
      }
    }
    if(!empty($_POST['m_nick'])){
      $m_nick = $_POST['m_nick']; 
    }
    
    if(!empty($_POST['m_name'])){
      $m_name = $_POST['m_name']; 
    }
    else{
        echo "<script>alert('真實姓名 請重新檢查！');history.go(-1);</script>";
        exit();
    }
    
    
    if( !empty($_POST['m_passwd']) || !empty($_POST['m_passwdrecheck'])){
      $m_passwd = $_POST['m_passwd']; 
      if($m_passwd != $_POST['m_passwdrecheck']){
        echo "<script>alert('密碼 請重新檢查！');history.go(-1);</script>";
        exit();
      }    
    }
    if(!empty($_POST['m_level'])){
      $m_level = $_POST['m_level']; 
      if($m_level != '權限管理者' && $m_level != '使用發布者'){
        echo "<script>alert('權限錯誤！');history.go(-1);</script>";
        exit();
      }
    }
    if(!empty($_POST['m_email'])){
      $m_email = $_POST['m_email']; 
      if (!ereg("^[A-Za-z0-9_-]+[A-Za-z0-9_.-]*@[A-Za-z0-9_-]+[A-Za-z0-9_.-]*\.[A-Za-z]{2,5}$", $m_email)) {
        echo "<script>alert('電子信箱錯誤！');history.go(-1);</script>";
        exit();
      }
    }
    @$m_phone = $_POST['m_phone']; 
    @$m_cellphone = $_POST['m_cellphone'];
    @$m_address = $_POST['m_address']; 
    $m_joinDate = $_POST['m_joinDate']; 
    if(!empty($_POST['p_ip'])){
      $p_ip = $_POST['p_ip'];
    }

    $expression = "
      m_name = '$m_name', 
      m_nick = '$m_nick', 
      m_username = '$m_username', 
      m_passwd = '$m_passwd', 
      m_level = '$m_level', 
      m_email = '$m_email', 
      m_phone = '$m_phone', 
      m_cellphone = '$m_cellphone', 
      m_address = '$m_address', 
      m_joinDate = '$m_joinDate', 
      p_ip = '$p_ip'
    ";

    $data_function->insert($expression); 
    
    $pages->setDb('memberdata','And m_level != "member"','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexauthority.php');
    $Listpage = $pages->getListpage(2,'backindexauthority.php');
    $Endpage = $pages->getEndpage('backindexauthority.php');
    $data = $pages->getData();
    include(VIEW.'/backindexauthority_view.php');
  }
  elseif($action_mode=='edit_user_view'){ //ok
    if(isset($_POST['m_id'])){
      $pages = new sam_pages_class;
      $pages->setDb('memberdata'," AND m_id = '".$_POST['m_id']."'","*");
      $row_RecPower = $pages->getData();
      include(VIEW.'/backindexauthorityre_view.php');
    }  
  }
  elseif($action_mode=='edit_user'){ //ok
    if(!empty($_POST['m_id'])){
      $data_function = new data_function;
      $data_function->setDb('memberdata');
      $expression='';
      if(!empty($_POST['m_passwd'])){
        $m_passwd = $_POST['m_passwd'];
        $expression .= " m_passwd='$m_passwd', ";
      }
      $m_id = $_POST['m_id']; 
      $m_name = $_POST['m_name']; 
      $m_nick = $_POST['m_nick'];
      $m_level = $_POST['m_level'];
      $m_email = $_POST['m_email'];
      @$m_phone = $_POST['m_phone'];
      @$m_cellphone = $_POST['m_cellphone'];
      @$m_address = $_POST['m_address'];
      $m_joinDate = $_POST['m_joinDate'];
      $p_ip = $_POST['p_ip'];
      $where = " AND m_id = '$m_id' ";
      $expression .= " m_name='$m_name', m_nick='$m_nick',  m_level='$m_level', m_email='$m_email', m_phone='$m_phone', m_cellphone='$m_cellphone', m_address='$m_address', m_joinDate='$m_joinDate', p_ip='$p_ip'";
      $data_function->update($where,$expression);
    }
    $pages = new sam_pages_class;
    $pages->setDb('memberdata'," AND m_id = '".$_POST['m_id']."'","*");
    $row_RecPower = $pages->getData();
    include(VIEW.'/backindexauthorityre_view.php');
  } 
  elseif($action_mode=='delete_user'){ //ok
    if(!empty($_POST['m_id'])){
      $m_id = $_POST['m_id'];
      $data_function = new data_function;
      $data_function->setDb('memberdata');
      $where = " AND m_id='$m_id' ";
      $data_function->delete($where);
    }
    $pages = new sam_pages_class;
    $pages->setDb('memberdata','And m_level != "member"','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexauthority.php');
    $Listpage = $pages->getListpage(2,'backindexauthority.php');
    $Endpage = $pages->getEndpage('backindexauthority.php');
    $data = $pages->getData();
    include(VIEW.'/backindexauthority_view.php');
  }
  else{ //ok
    $pages = new sam_pages_class;
    $pages->setDb('memberdata','And m_level != "member"','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexauthority.php');
    $Listpage = $pages->getListpage(2,'backindexauthority.php');
    $Endpage = $pages->getEndpage('backindexauthority.php');
    $data = $pages->getData();
    include(VIEW.'/backindexauthority_view.php');
  }
}
include(BCLASS.'/foot.php');
?>