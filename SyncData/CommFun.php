<?php //可寫成class $con 與 $rs封裝在內部
 function ConnectDb()
 {
    $hostname_connSQL = "localhost";
    $database_connSQL = "cctest";//cctest";                                       //資料庫名稱     (如有新建案 請改此處)
    $username_connSQL = "root";//root";                                       //資料庫帳號名稱 (如有新建案 請改此處)
    $password_connSQL = "Tcwa0428742715";//123456";                                       //資料庫帳號密碼 (如有新建案 請改此處)
    $connSQL = mysql_connect($hostname_connSQL, $username_connSQL, $password_connSQL) or trigger_error(mysql_error(),E_USER_ERROR); 
    mysql_select_db($database_connSQL, $connSQL);
    mysql_query("SET NAMES UTF8");
    //mysql_query('SET CHARACTER_SET_CLIENT=utf8');
    //mysql_query('SET CHARACTER_SET_RESULTS=utf8');
    //mysql_set_charset('utf8',$connSQL);
    //mysql_query("set names gbk");
    return  $connSQL;
 } 
 function DbExcute($sql)
 {
   return mysql_query($sql);//執行成功 
   //return mysql_affected_rows();//有異動資料才會傳會影響列數
  
  
  //$txt="中文";
  //return mysql_query("INSERT INTO mail_management(receives_time,sends_name,sends_add,m_username,letter_category,letter_alt,letters_number,`show`,receives_name)VALUES('2013-03-14 22:23:05','888','','33e','$txt','','88','1','rrr')"); //傳回什麼東西,當作是否執行伺服器成功的依據 int(true:1,false:0)
 }

 function GetRowsCount($rs)
 {
   return mysql_num_rows($rs);
 }
 function GetRowsData($rs)
 {
    return  mysql_fetch_assoc($rs);//使用過此函是資料庫的指標就會往下移動直到結尾
 }

 function CloseDb($con)
 {
   mysql_close($con);
 }
 //--------------------------------------------------------------------------------------------
 //參數都要有值才能進入;重要
 
 function OutputHeader()
 {
  header('Content-type:text/html; charset=utf-8');//語系統一UTF8 ,中文才不會亂碼
 }
 function CheckSqlTxt() 
 {
	  $flag=(isset($_REQUEST['sqltxt']) && $_REQUEST['sqltxt']!="")?true:false;//strlen(字串)>0
    //$flag2=(isset($_REQUEST['passwd']) && $_REQUEST['passwd']!="")?true:false;
    //$flag3=(isset($_REQUEST['phonenum']) && $_REQUEST['phonenum']!="")?true:false; 
    //$flag4=(isset($_REQUEST['phoneid']) && $_REQUEST['phoneid']!="")?true:false;
    return $flag; //$flag1 && $flag2 && $flag3 && $flag4;
 }
 function  GetSqlTxt() 
 {
    //echo  $_REQUEST['sqltxt'];
    return $_REQUEST['sqltxt'];
 }
 function GetCheckUserParameter() 
 {
		  $username = $_REQUEST['username'];
		  $passwd = $_REQUEST['passwd'];
		  $phonenum = $_REQUEST['phonenum'];
			$phoneid = $_REQUEST['phoneid'];
			$whichdb="cctest";//$_REQUEST['phoneid'];
      return array($username, $passwd, $phonenum,$phoneid,$whichdb);
 }
 function GetTblchildmemberdataCount($mid)
 {
    return "SELECT * FROM childmemberdata WHERE m_id={$mid}";
 }
function GetArraryLength($arrary)
{
    return count($arrary);
}
/* function SynchronizeDataLog($sqldata,$path="")//同步化 Appserver與Webserver
 {
    //$fp=fopen("C:\\tcwa\\".$path."\\SynData.txt","a+");
    $fp=fopen("C:\\tcwa\\Appser\\SynData.txt","a+");
    $nowtime=date("Y-m-d H:i:s");
    fwrite($fp,$sqldata.":".$nowtime."\n");
    fclose($fp);
 }*/ 
 
?>
