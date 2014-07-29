<?php
if (!isset($_SESSION)) {
  session_start();
}
//error_reporting(15);
header("Cache-control:private");
header("Content-Type:text/html; charset=utf-8");
if (!defined("ROOT_PATH")) {
  define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
  
  define("PATH", ROOT_PATH."/cc77");
  define("IMG", ROOT_PATH."/img");
  define("CONNECTIONS", PATH."/Connections");
  define("INCLUDES", PATH."/includes");
  define("CSS",PATH."/CSS");
  define("SYSTEM",PATH."/system");
  
  define("BACKSTAGE",PATH."/backstage");
  define("BCLASS",BACKSTAGE."/class");
  define("BNEWS",BACKSTAGE."/news");
  define("VIEW",BACKSTAGE."/view");
  define("EMAIL_TEMPLATES",BACKSTAGE."/email_templates");
  define("BIMAGES",BACKSTAGE."/images");
  define("C_SUBJECT","親家新觀");
  define("E_SUBJECT","cc77");
}

?>