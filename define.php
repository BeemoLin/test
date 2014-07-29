<?php
if (!isset($_SESSION)) {
  session_start();
}
if(empty($xml)){
  header('Cache-control:private');
  header('Content-Type:text/html; charset=utf-8');
}

//error_reporting(15);
if (!defined('ROOT_PATH')) {
  define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);

  define('CONSTRUCTION_CASE','test');                                //驗証名稱   (如有新建案 請改此處)
  define('PATH', ROOT_PATH.'/test');                                 //目前目錄   (如有新建案 請改此處)
  define('IMG', ROOT_PATH.'/img');                                   //圖形目錄
  define('CONNECTIONS', PATH.'/Connections');                        //資料庫及認證目錄
  define('INCLUDES', PATH.'/includes');                              //引入類別目錄
  define('CSS', PATH.'/CSS');                                        //CSS Style 目錄
  define('SYSTEM', PATH.'/system');                                  //jquery 以及 PHPMailer 目錄

  define('BACKSTAGE', PATH.'/backstage');                            //後臺目錄
  define('BCLASS', BACKSTAGE.'/class');                              //後臺引入類別目錄
  define('BNEWS' ,BACKSTAGE.'/news');                                //新聞圖檔目錄
  define('VIEW', BACKSTAGE.'/view');                                 //引入 View 檔案目錄
  define('EMAIL_TEMPLATES', BACKSTAGE.'/email_templates');           //信件樣板目錄
  define('BIMAGES', BACKSTAGE.'/images');                            //圖形目錄
  define('C_SUBJECT', '測試用');                                   //中文名稱   (如有新建案 請改此處)
  define('E_SUBJECT', 'test');                                       //英文名稱   (如有新建案 請改此處)

  define('CONNSQL', CONNECTIONS.'/connSQL.php');                     //資料庫及認證檔案位置
  define('PAGECLASS', BCLASS.'/page_class.php');                     //引入類別檔案位置
  
  $hostname_connSQL = "localhost";
  $database_connSQL = "ttest";                                       //資料庫名稱     (如有新建案 請改此處)
  $username_connSQL = "test";                                       //資料庫帳號名稱 (如有新建案 請改此處)
  $password_connSQL = "test";                                       //資料庫帳號密碼 (如有新建案 請改此處)
  $connSQL = mysql_pconnect($hostname_connSQL, $username_connSQL, $password_connSQL) or trigger_error(mysql_error(),E_USER_ERROR); 
  mysql_query("SET NAMES UTF8");
  mysql_select_db($database_connSQL, $connSQL);
}

?>
