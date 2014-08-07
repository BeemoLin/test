<?php
session_start();
header('Content-type:text/html; charset=utf-8');
require_once('define.php');
require_once(CONNSQL);
require_once(PAGECLASS);


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

switch($action_mode)
{
  // 列表頁面
  case "index":
    $pages = new sam_pages_class;
    $pages->action_mode('index');
    
    // 此段有在select 中select ,'巢狀子查詢' MSSQL 與 MySQL 皆適用
    $select_expression = '`maint_id`, `maint_name`, `maint_cycle`, `maint_date`, `maint_period`, `maint_notice`, `maint_visible`, `maint_co`, `maint_co_tel`, `update_at`, (select `name` FROM `maintainer` WHERE  `maintainer`.`maint_id` = `maintain`.`maint_id` AND `maint_type` = 1 LIMIT 0 , 1) AS `maintainer`, (select `check_state` FROM `maintainlog` WHERE  `maintainlog`.`maint_id` = `maintain`.`maint_id` ORDER BY `uid` DESC LIMIT 0 , 1) AS `maint_state`';
    
    $DBname = '`maintain`';
    $where_expression = ' ORDER BY `maint_id` ASC ';
    
    $pages->setDb($DBname, $where_expression, $select_expression);
    $pages->setPerpage(10,$page);
    $pages->set_base_page('backindex_maint.php');
    $Firstpage = $pages->getFirstpage2();
    $Listpage = $pages->getListpage2(2);
    $Endpage = $pages->getEndpage2();
    $maintData = $pages->getData();

    //echo($pages->sql);

    $cycle_list = array("每週","每月","每季","每半年","每年");
    $week_list = array("週一","週二","週三","週四","週五","週六","週日");


    $action_mode = "index";
    include(VIEW.'/maint/index.php');
    break;

  // 新增資料頁面
  case "new":
    include(VIEW.'/maint/edit.php');
    $action_mode = 'create';
    break;

  // 新增資料單純做資料驗證與新增
  case "create":
    $status = true;
    //這裡做後端驗證資料正確性

    //必填欄位 變數有設定 and 不是空值才算正確
    if(isset($_POST["maint_name"]) && $_POST["maint_name"] != ""){ $maint_name = $_POST["maint_name"]; }else{ $status = false; }
    if(isset($_POST["maint_cycle"]) && $_POST["maint_name"] != ""){ $maint_cycle = $_POST["maint_cycle"]; }else{ $status = false; }
    if(isset($_POST["maint_date"]) && $_POST["maint_name"] != ""){ $maint_date = $_POST["maint_date"]; }else{ $status = false; }
    if(isset($_POST["maint_period"]) && $_POST["maint_period"] != ""){ $maint_period = $_POST["maint_period"]; }else{ $status = false; }
    if(isset($_POST["maint_notice"]) && $_POST["maint_name"] != ""){ $maint_notice = $_POST["maint_notice"]; }else{ $status = false; }
    if(isset($_POST["maint_visible"]) && $_POST["maint_name"] != ""){ $maint_visible = $_POST["maint_visible"]; }else{ $status = false; }

    // 可為空白的欄位
    if(isset($_POST["maint_co"])){ $maint_co = $_POST["maint_co"]; }
    if(isset($_POST["maint_co_tel"])){ $maint_co_tel = $_POST["maint_co_tel"]; }
    
    if(is_array($_POST["staff_name"])){ $staff_name = $_POST["staff_name"]; };
    if(is_array($_POST["staff_tel"])){ $staff_tel = $_POST["staff_tel"]; };
    if(is_array($_POST["manager_name"])){ $manager_name = $_POST["manager_name"]; };
    if(is_array($_POST["manager_tel"])){ $manager_tel = $_POST["manager_tel"]; };
    
    if($status)
    {
      // 驗證完成建立db資料
      $data_function = new data_function; //建立資料庫物件
      $data_function->setDb("maintain");
      $expression = "`maint_name`='".$maint_name."',
                    `maint_cycle` = '".$maint_cycle."',
                    `maint_date` = '".$maint_date."',
                    `maint_period` = '".$maint_period."',
                    `maint_notice` = '".$maint_notice."',
                    `maint_visible` = '".$maint_visible."',
                    `maint_co` = '".$maint_co."',
                    `maint_co_tel` = '".$maint_co_tel."'";
      $data_function->insert($expression);

      // 寫入主表後馬上取出id供副表使用 
      $maint_id = mysql_insert_id();
      
      $data_function->setDb("maintainer");
      
      for($i=0;$i<5;$i++)
      {
        $expression = "`maint_id` = '".$maint_id."',
                    `maint_type` = '0',
                    `name` = '".$staff_name[$i]."',
                    `phone` = '".$staff_tel[$i]."'";
      
        $data_function->insert($expression);
        
        $expression = "`maint_id` = '".$maint_id."',
                    `maint_type` = '1',
                    `name` = '".$manager_name[$i]."',
                    `phone` = '".$manager_tel[$i]."'";
      
        $data_function->insert($expression);
      }
      //資料驗證與新增成功回列表
      $action_mode = 'index';
      echo "<script type='text/javascript'>post_to_url('backindex_maint.php', {'action_mode':'index'});</script>";
    }
    else
    {
      //資料驗證或新增失敗切回新增資料頁
      $action_mode = 'new';
      echo "<script type='text/javascript'>history.back(-1);</script>";
    }
    break;

  // 顯示單筆資料完整內容
  case "show":
    include(VIEW.'/maint/edit.php');
    break;

  // 編輯畫面與新增帶入同一個view 但是要撈出要修改的記錄
  case "edit":
    if(isset($_POST['maint_id']))
    {
      $maint_id = $_POST['maint_id'];
    }

    // 撈出該筆資料
    $data_function = new data_function;
    $data_function->setDb('maintain');
    $where_expression = "AND `maint_id` = '".$maint_id."' ";
    $data = $data_function->select($where_expression);
    
    // 撈出該筆資料的維護人員
    $data_function->setDb('maintainer');
    $where_expression = "AND `maint_id` = '".$maint_id."' AND `maint_type` = 0 ORDER BY `uid` ASC ";
    $staff_data = $data_function->select($where_expression);

    // 撈出該筆資料的維護人員
    $data_function->setDb('maintainer');
    $where_expression = "AND `maint_id` = '".$maint_id."' AND `maint_type` = 1 ORDER BY `uid` ASC ";
    $manager_data = $data_function->select($where_expression);
    
    include(VIEW.'/maint/edit.php');
    $action_mode = 'update';
    break;

  // 驗證與更新資料
  case "update":
    $status = true;
    //這裡做後端驗證資料正確性
    if(isset($_POST['maint_id']))
    {
      $maint_id = $_POST['maint_id'];
    }

    //必填欄位 變數有設定 and 不是空值才算正確
    if(isset($_POST["maint_name"]) && $_POST["maint_name"] != ""){ $maint_name = $_POST["maint_name"]; }else{ $status = false; }
    if(isset($_POST["maint_cycle"]) && $_POST["maint_name"] != ""){ $maint_cycle = $_POST["maint_cycle"]; }else{ $status = false; }
    if(isset($_POST["maint_date"]) && $_POST["maint_name"] != ""){ $maint_date = $_POST["maint_date"]; }else{ $status = false; }
    if(isset($_POST["maint_period"]) && $_POST["maint_period"] != ""){ $maint_period = $_POST["maint_period"]; }else{ $status = false; }
    if(isset($_POST["maint_notice"]) && $_POST["maint_name"] != ""){ $maint_notice = $_POST["maint_notice"]; }else{ $status = false; }
    if(isset($_POST["maint_visible"]) && $_POST["maint_name"] != ""){ $maint_visible = $_POST["maint_visible"]; }else{ $status = false; }

    // 可為空白的欄位
    if(isset($_POST["maint_co"])){ $maint_co = $_POST["maint_co"]; }
    if(isset($_POST["maint_co_tel"])){ $maint_co_tel = $_POST["maint_co_tel"]; }

    if(is_array($_POST["staff_uid"])){ $staff_uid = $_POST["staff_uid"]; };
    if(is_array($_POST["staff_name"])){ $staff_name = $_POST["staff_name"]; };
    if(is_array($_POST["staff_tel"])){ $staff_tel = $_POST["staff_tel"]; };
    
    if(is_array($_POST["manager_uid"])){ $manager_uid = $_POST["manager_uid"]; };
    if(is_array($_POST["manager_name"])){ $manager_name = $_POST["manager_name"]; };
    if(is_array($_POST["manager_tel"])){ $manager_tel = $_POST["manager_tel"]; };
    
    if($status)
    {
      // 驗證完成建立db資料
      $data_function = new data_function; //建立資料庫物件
      $data_function->setDb("maintain");
      $expression = "`maint_name`='".$maint_name."',
                    `maint_cycle` = '".$maint_cycle."',
                    `maint_date` = '".$maint_date."',
                    `maint_period` = '".$maint_period."',
                    `maint_notice` = '".$maint_notice."',
                    `maint_visible` = '".$maint_visible."',
                    `maint_co` = '".$maint_co."',
                    `maint_co_tel` = '".$maint_co_tel."'";
      $where_expression = " AND `maint_id` = '".$maint_id."' ";
      $data_function->update($where_expression, $expression);
      
      $data_function->setDb("maintainer");
      
      for($i=0;$i<5;$i++)
      {
        $expression = "`name` = '".$staff_name[$i]."',
                    `phone` = '".$staff_tel[$i]."'";
        $where_expression = " AND `uid` = '".$staff_uid[$i]."' ";
        $data_function->update($where_expression, $expression);
        
        $expression = "`name` = '".$manager_name[$i]."',
                    `phone` = '".$manager_tel[$i]."'";
        $where_expression = " AND `uid` = '".$manager_uid[$i]."' ";
        $data_function->update($where_expression, $expression);
      }
      //資料驗證與新增成功回列表
      $action_mode = 'index';
      echo "<script type='text/javascript'>post_to_url('backindex_maint.php', {'action_mode':'index'});</script>";
    }
    else
    {
      //資料驗證或新增失敗切回新增資料頁
      $action_mode = 'edit';
      echo "<script type='text/javascript'>post_to_url('backindex_maint.php', {'action_mode':'edit','maint_id':'".$maint_id."'});</script>";
    }

    break;

  // 刪除資料
  case "delete":
    if(isset($_POST['maint_id']))
    {
      $maint_id = $_POST['maint_id'];
       
      $data_function = new data_function;

      //先刪除副表資料
      $data_function->setDb('maintainer');
      $where = "AND maint_id='".$maint_id."'";
      $data_function->delete($where);

      // 刪除主表資料
      $data_function->setDb('maintain');
      $where = "AND maint_id='".$maint_id."'";
      $data_function->delete($where);
    }
    // 回列表頁 
    $action_mode = 'index';
    echo "<script type='text/javascript'>post_to_url('backindex_maint.php', {'action_mode':'index'});</script>";
    break;

  // 預設頁面為列表頁
  default:
    echo $action_mode;
    $action_mode = 'index';
    echo "<script type='text/javascript'>post_to_url('backindex_maint.php', {'action_mode':'index'});</script>";
    break;
 }


include(BCLASS.'/foot.php');
?>
