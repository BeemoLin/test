<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);
/*
view_page:
  backindexhouseholder_view.php
  backindexhouseholderre_view.php
  backindexhouseholderadd_view.php
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

if($_SESSION['MM_UserGroup'] == '權限管理者' || $_SESSION['MM_UserGroup'] == '使用發布者'){
  if($action_mode=='view_all_data'){//ok
    $pages = new sam_pages_class;
    $pages->setDb('memberdata','AND m_level = "member" ORDER BY `memberdata`.`m_name` ASC','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexhouseholder.php');
    $Listpage = $pages->getListpage(2,'backindexhouseholder.php');
    $Endpage = $pages->getEndpage('backindexhouseholder.php');
    $data = $pages->getData();
    include(VIEW.'/backindexhouseholder_view.php');
  }
  elseif($action_mode=='edit_user_view'){//ok
  //die("work");
    if(!empty($_POST['m_id'])){
      $pages = new sam_pages_class;
      $pages->setDb("memberdata"," AND m_level = 'member' AND m_id = '".$_POST['m_id']."'","*");
      $row_RecUser = $pages->getData();
      include(VIEW.'/backindexhouseholderre_view.php');
    }
  }
  elseif($action_mode=='set_contact_view'){//ok
  //die("work");
    if(isset($_POST['m_id'])){
      $pages = new sam_pages_class;
      $pages->setDb("memberdata"," AND m_level = 'member' AND m_id = '".$_POST['m_id']."'","*");
      $row_RecUser = $pages->getData();
      include(VIEW.'/back_SetContact_view.php');
    }
  }
  elseif($action_mode=='edit_user'){ //
   
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
      $m_email = $_POST['m_email'];
      $m_phone = $_POST['m_phone'];
      $m_cellphone = $_POST['m_cellphone'];
      $m_address = $_POST['m_address'];
      $m_joinDate = $_POST['m_joinDate'];
      $p_ip = $_POST['p_ip'];
      $where = " AND m_id = '$m_id' ";
      $expression .= " m_name='$m_name', m_nick='$m_nick', m_email='$m_email', m_phone='$m_phone', m_cellphone='$m_cellphone', m_address='$m_address', m_joinDate='$m_joinDate', p_ip='$p_ip', ";

    $m_car1 = $_POST['m_car1'];
    $m_carmum1 = $_POST['m_carmum1'];
    $m_car2 = $_POST['m_car2'];
    $m_carmum2 = $_POST['m_carmum2'];
    $m_car3 = $_POST['m_car3'];
    $m_carmum3 = $_POST['m_carmum3'];
    $m_car4 = $_POST['m_car4'];
    $m_carmum4 = $_POST['m_carmum4'];
    $m_car5 = $_POST['m_car5'];
    $m_carmum5 = $_POST['m_carmum5'];
    $m_moto1 = $_POST['m_moto1'];
    $m_motomum1 = $_POST['m_motomum1'];
    $m_moto2 = $_POST['m_moto2'];
    $m_motomum2 = $_POST['m_motomum2'];
    $m_moto3 = $_POST['m_moto3'];
    $m_motomum3 = $_POST['m_motomum3'];
    $m_moto4 = $_POST['m_moto4'];
    $m_motomum4 = $_POST['m_motomum4'];
    $m_moto5 = $_POST['m_moto5'];
    $m_motomum5 = $_POST['m_motomum5'];
      
      $expression .= " 
      m_car1 = '$m_car1',
      m_carmum1 = '$m_carmum1',
      m_car2 = '$m_car2',
      m_carmum2 = '$m_carmum2',
      m_car3 = '$m_car3',
      m_carmum3 = '$m_carmum3',
      m_car4 = '$m_car4',
      m_carmum4 = '$m_carmum4',
      m_car5 = '$m_car5',
      m_carmum5 = '$m_carmum5',
      m_moto1 = '$m_moto1',
      m_motomum1 = '$m_motomum1',
      m_moto2 = '$m_moto2',
      m_motomum2 = '$m_motomum2',
      m_moto3 = '$m_moto3',
      m_motomum3 = '$m_motomum3',
      m_moto4 = '$m_moto4',
      m_motomum4 = '$m_motomum4',
      m_moto5 = '$m_moto5',
      m_motomum5 = '$m_motomum5'
      ";
      
      $data_function->update($where,$expression);
    }
    $pages = new sam_pages_class;
    
    $pages->setDb("memberdata"," AND m_level = 'member' AND m_id = '".$_POST['m_id']."'","*");
    //die(" AND m_level = 'member' AND m_id = '".$_POST['m_id']."'");
    $row_RecUser = $pages->getData();
    include(VIEW.'/backindexhouseholderre_view.php');
  } 
  elseif($action_mode=='set_contact'){ //
   
    if(!empty($_POST['m_id'])){
      $data_function = new data_function;
      $data_function->setDb('memberdata');
      $m_id = $_POST['m_id']; 
      $where = " AND m_id = '$m_id' ";

      $m_car1 = $_POST['m_car1'];
      $m_carmum1 = $_POST['m_carmum1'];
      $m_car2 = $_POST['m_car2'];
      $m_carmum2 = $_POST['m_carmum2'];
      $m_car3 = $_POST['m_car3'];
      $m_carmum3 = $_POST['m_carmum3'];
      $m_car4 = $_POST['m_car4'];
      $m_carmum4 = $_POST['m_carmum4'];
      $m_car5 = $_POST['m_car5'];
      $m_carmum5 = $_POST['m_carmum5'];
      
      $expression .= " 
      m_car1 = '$m_car1',
      m_carmum1 = '$m_carmum1',
      m_car2 = '$m_car2',
      m_carmum2 = '$m_carmum2',
      m_car3 = '$m_car3',
      m_carmum3 = '$m_carmum3',
      m_car4 = '$m_car4',
      m_carmum4 = '$m_carmum4',
      m_car5 = '$m_car5',
      m_carmum5 = '$m_carmum5'
      ";
      
      $data_function->update($where,$expression);
    }

    echo "<script>window.history.go(-2)</script>";
    exit();
    $pages = new sam_pages_class;
    
    $pages->setDb("memberdata"," AND m_level = 'member' AND m_id = '".$_POST['m_id']."'","*");
    //die(" AND m_level = 'member' AND m_id = '".$_POST['m_id']."'");
    $row_RecUser = $pages->getData();
    include(VIEW.'/back_SetContact_view.php');
  } 
  elseif($action_mode=='add_user_view'){ //ok
  //die("work");
    //SELECT m_name FROM memberdata WHERE m_name=%s
    include(VIEW.'/backindexhouseholderadd_view.php');
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
      if($m_level != 'member'){
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
    $m_phone = $_POST['m_phone']; 
    $m_cellphone = $_POST['m_cellphone'];
    $m_address = $_POST['m_address']; 
    $m_joinDate = $_POST['m_joinDate']; 
    if(!empty($_POST['p_ip'])){
      $p_ip = $_POST['p_ip'];
    }
    else{
      echo "<script>alert('網路卡設定錯誤！');history.go(-1);</script>";
      exit();
    }
    
    $m_car1 = $_POST['m_car1'];
    $m_carmum1 = $_POST['m_carmum1'];
    $m_car2 = $_POST['m_car2'];
    $m_carmum2 = $_POST['m_carmum2'];
    $m_car3 = $_POST['m_car3'];
    $m_carmum3 = $_POST['m_carmum3'];
    $m_car4 = $_POST['m_car4'];
    $m_carmum4 = $_POST['m_carmum4'];
    $m_car5 = $_POST['m_car5'];
    $m_carmum5 = $_POST['m_carmum5'];
    $m_moto1 = $_POST['m_moto1'];
    $m_motomum1 = $_POST['m_motomum1'];
    $m_moto2 = $_POST['m_moto2'];
    $m_motomum2 = $_POST['m_motomum2'];
    $m_moto3 = $_POST['m_moto3'];
    $m_motomum3 = $_POST['m_motomum3'];
    $m_moto4 = $_POST['m_moto4'];
    $m_motomum4 = $_POST['m_motomum4'];
    $m_moto5 = $_POST['m_moto5'];
    $m_motomum5 = $_POST['m_motomum5'];
    
    
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
      p_ip = '$p_ip',
      m_car1 = '$m_car1',
      m_carmum1 = '$m_carmum1',
      m_car2 = '$m_car2',
      m_carmum2 = '$m_carmum2',
      m_car3 = '$m_car3',
      m_carmum3 = '$m_carmum3',
      m_car4 = '$m_car4',
      m_carmum4 = '$m_carmum4',
      m_car5 = '$m_car5',
      m_carmum5 = '$m_carmum5',
      m_moto1 = '$m_moto1',
      m_motomum1 = '$m_motomum1',
      m_moto2 = '$m_moto2',
      m_motomum2 = '$m_motomum2',
      m_moto3 = '$m_moto3',
      m_motomum3 = '$m_motomum3',
      m_moto4 = '$m_moto4',
      m_motomum4 = '$m_motomum4',
      m_moto5 = '$m_moto5',
      m_motomum5 = '$m_motomum5'
    ";

    $data_function->insert($expression); 
    
    $pages->setDb('memberdata','AND m_level = "member" ORDER BY `memberdata`.`m_name` ASC','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexhouseholder.php');
    $Listpage = $pages->getListpage(2,'backindexhouseholder.php');
    $Endpage = $pages->getEndpage('backindexhouseholder.php');
    $data = $pages->getData();
    include(VIEW.'/backindexhouseholder_view.php');
  }
  elseif($action_mode=='delete_user'){ //
    if(!empty($_POST['m_id'])){
      $m_id = $_POST['m_id'];
      $data_function = new data_function;
      $data_function->setDb('memberdata');
      $where = " AND m_id='$m_id' ";
      $data_function->delete($where);
    }
    $pages = new sam_pages_class;
    $pages->setDb('memberdata','AND m_level = "member" ORDER BY `memberdata`.`m_name` ASC','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexhouseholder.php');
    $Listpage = $pages->getListpage(2,'backindexhouseholder.php');
    $Endpage = $pages->getEndpage('backindexhouseholder.php');
    $data = $pages->getData();
    include(VIEW.'/backindexhouseholder_view.php');
  }
  else{
    $pages = new sam_pages_class;
    $pages->setDb('memberdata','AND m_level = "member" ORDER BY `memberdata`.`m_name` ASC','*');
    $pages->setPerpage(10,$page);
    $Firstpage = $pages->getFirstpage('backindexhouseholder.php');
    $Listpage = $pages->getListpage(2,'backindexhouseholder.php');
    $Endpage = $pages->getEndpage('backindexhouseholder.php');
    $data = $pages->getData();
    include(VIEW.'/backindexhouseholder_view.php');
  }
}

include(BCLASS.'/foot.php');
?>
